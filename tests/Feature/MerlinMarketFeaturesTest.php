<?php

namespace Tests\Feature;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MerlinMarketFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_and_manipulate_a_product_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('admin.products.store'), [
            'sku' => 'MM-TEST-1',
            'name' => 'Produk uji',
            'description' => 'Deskripsi produk',
            'price' => '25000.00',
            'stock' => 4,
            'rotation' => 90,
            'image' => UploadedFile::fake()->image('produk.png', 120, 80),
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::query()->where('sku', 'MM-TEST-1')->firstOrFail();
        $this->assertStringEndsWith('.webp', $product->image_path);
        Storage::disk('public')->assertExists($product->image_path);
    }

    public function test_cashier_can_record_a_sale_and_download_its_pdf_invoice(): void
    {
        Event::fake([OrderPlaced::class]);
        $cashier = User::factory()->create(['role' => 'kasir']);
        $product = Product::create([
            'sku' => 'MM-SALE-1',
            'name' => 'Produk transaksi',
            'price' => '12500.00',
            'stock' => 5,
        ]);

        $response = $this->actingAs($cashier)->post(route('cashier.orders.store'), [
            'items' => [
                $product->id => [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
            'paid_amount' => '30000.00',
        ]);

        $order = Order::query()->firstOrFail();
        $response->assertRedirect(route('orders.receipt', $order));
        $response->assertSessionHas('print_receipt', true);
        $this->assertSame(3, $product->fresh()->stock);
        $this->assertSame('25000.00', $order->fresh()->total);
        $this->assertSame('30000.00', $order->fresh()->paid_amount);
        $this->assertSame('5000.00', $order->fresh()->change_amount);
        Event::assertDispatched(OrderPlaced::class, function (OrderPlaced $event) use ($order): bool {
            $payload = $event->broadcastWith();

            return $event->broadcastOn()[0]->name === 'private-admin.orders'
                && $payload['invoice_number'] === $order->invoice_number
                && $payload['cashier_name'] === $order->user->name;
        });

        $invoice = $this->get(route('orders.invoice', $order));
        $invoice->assertOk();
        $this->assertStringStartsWith('%PDF-', $invoice->getContent());
        $invoice->assertHeader('content-type', 'application/pdf');

        $receipt = $this->withSession(['print_receipt' => true])->get(route('orders.receipt', $order));
        $receipt->assertOk()
            ->assertSee('Produk transaksi')
            ->assertSee('Dibayar')
            ->assertSee('Kembalian')
            ->assertSee('window.print()')
            ->assertSee(route('orders.invoice', $order), false);
    }

    public function test_cashier_cannot_complete_a_sale_with_insufficient_payment(): void
    {
        $cashier = User::factory()->create(['role' => 'kasir']);
        $product = Product::create([
            'sku' => 'MM-UNDERPAID',
            'name' => 'Produk belum lunas',
            'price' => '12500.00',
            'stock' => 5,
        ]);

        $this->actingAs($cashier)->from(route('cashier.dashboard'))->post(route('cashier.orders.store'), [
            'items' => [
                $product->id => [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
            'paid_amount' => '24999.99',
        ])->assertSessionHasErrors('paid_amount');

        $this->assertSame(5, $product->fresh()->stock);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_cashier_cannot_sell_more_than_available_stock(): void
    {
        $cashier = User::factory()->create(['role' => 'kasir']);
        $product = Product::create([
            'sku' => 'MM-LOW-STOCK',
            'name' => 'Stok terbatas',
            'price' => '10000.00',
            'stock' => 1,
        ]);

        $this->actingAs($cashier)->from(route('cashier.dashboard'))->post(route('cashier.orders.store'), [
            'items' => [
                $product->id => [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
            'paid_amount' => '20000.00',
        ])->assertSessionHasErrors('items');

        $this->assertSame(1, $product->fresh()->stock);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_cashier_cannot_download_another_users_invoice(): void
    {
        $owner = User::factory()->create(['role' => 'kasir']);
        $otherCashier = User::factory()->create(['role' => 'kasir']);
        $order = Order::create([
            'invoice_number' => 'MM-TEST-INVOICE',
            'user_id' => $owner->id,
            'total' => '0.00',
        ]);

        $this->actingAs($otherCashier)->get(route('orders.invoice', $order))->assertForbidden();
    }

    public function test_cashier_cannot_view_another_users_receipt(): void
    {
        $owner = User::factory()->create(['role' => 'kasir']);
        $otherCashier = User::factory()->create(['role' => 'kasir']);
        $order = Order::create([
            'invoice_number' => 'MM-TEST-RECEIPT',
            'user_id' => $owner->id,
            'total' => '0.00',
        ]);

        $this->actingAs($otherCashier)->get(route('orders.receipt', $order))->assertForbidden();
    }

    public function test_only_admins_can_authorize_the_order_notifications_channel(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->postJson('/broadcasting/auth', [
                'socket_id' => '1234.5678',
                'channel_name' => 'private-admin.orders',
            ])
            ->assertOk();
    }

    public function test_cashiers_cannot_authorize_the_order_notifications_channel(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'kasir']))
            ->postJson('/broadcasting/auth', [
                'socket_id' => '1234.5678',
                'channel_name' => 'private-admin.orders',
            ])
            ->assertForbidden();
    }

    public function test_guests_cannot_authorize_the_order_notifications_channel(): void
    {
        $this->postJson('/broadcasting/auth', [
            'socket_id' => '1234.5678',
            'channel_name' => 'private-admin.orders',
        ])->assertForbidden();
    }
}
