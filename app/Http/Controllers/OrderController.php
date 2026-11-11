<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('dashboard.cashier', [
            'products' => Product::query()->where('stock', '>', 0)->orderBy('name')->get(),
            'orders' => Order::query()->where('user_id', auth()->id())->latest()->take(8)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'paid_amount' => ['required', 'numeric', 'min:0.01', 'decimal:0,2'],
        ]);

        $order = DB::transaction(function () use ($data, $request): Order {
            $quantities = collect($data['items'])->keyBy('product_id');
            $products = Product::query()
                ->whereIn('id', $quantities->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $quantities->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Salah satu produk sudah tidak tersedia.',
                ]);
            }

            foreach ($quantities as $productId => $item) {
                if ($products[$productId]->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => 'Stok produk '.$products[$productId]->name.' tidak mencukupi.',
                    ]);
                }
            }

            $totalCents = 0;
            foreach ($quantities as $productId => $item) {
                $unitPriceCents = (int) round((float) $products[$productId]->price * 100);
                $totalCents += $unitPriceCents * $item['quantity'];
            }

            $paidCents = (int) round((float) $data['paid_amount'] * 100);
            if ($paidCents < $totalCents) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Uang dibayar belum mencukupi total transaksi.',
                ]);
            }

            $order = Order::create([
                'invoice_number' => 'MM-'.now()->format('Ymd').'-'.Str::upper(Str::random(8)),
                'user_id' => $request->user()->id,
                'total' => 0,
                'paid_amount' => number_format($paidCents / 100, 2, '.', ''),
                'change_amount' => number_format(($paidCents - $totalCents) / 100, 2, '.', ''),
            ]);

            foreach ($quantities as $productId => $item) {
                $product = $products[$productId];
                $unitPriceCents = (int) round((float) $product->price * 100);
                $subtotalCents = $unitPriceCents * $item['quantity'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => number_format($subtotalCents / 100, 2, '.', ''),
                ]);
                $product->decrement('stock', $item['quantity']);
            }

            $order->update(['total' => number_format($totalCents / 100, 2, '.', '')]);

            return $order;
        });

        OrderPlaced::dispatch($order);

        return redirect()->route('orders.receipt', $order)
            ->with('status', 'Transaksi berhasil. Struk siap dicetak.')
            ->with('print_receipt', true);
    }
}
