<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function show(Request $request, Order $order): Response
    {
        $this->authorizeOrderAccess($request, $order);

        $order->load(['user', 'items']);

        return Pdf::loadView('invoices.show', compact('order'))
            ->download($order->invoice_number.'.pdf');
    }

    public function receipt(Request $request, Order $order): Response
    {
        $this->authorizeOrderAccess($request, $order);

        $order->load(['user', 'items']);

        return response()->view('invoices.receipt', compact('order'));
    }

    private function authorizeOrderAccess(Request $request, Order $order): void
    {
        abort_unless(
            $request->user()->role === 'admin' || $request->user()->id === $order->user_id,
            403,
            'Invoice ini bukan milik akun Anda.'
        );
    }
}
