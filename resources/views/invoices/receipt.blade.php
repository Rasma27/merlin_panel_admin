<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk {{ $order->invoice_number }} | MerlinMarket</title>
    <style>
        *{box-sizing:border-box}body{margin:0;padding:24px;background:#f5f1e9;color:#252421;font:14px/1.5 Arial,sans-serif}.receipt{max-width:360px;margin:0 auto;padding:24px;background:#fff}.center{text-align:center}.brand{font-size:20px;font-weight:700}.muted{color:#746e66;font-size:12px}.rule{border:0;border-top:1px dashed #746e66;margin:16px 0}table{width:100%;border-collapse:collapse;font-size:12px}th,td{padding:5px 0;text-align:left;vertical-align:top}th:last-child,td:last-child{text-align:right}.totals p{display:flex;justify-content:space-between;margin:5px 0}.totals .grand-total{font-weight:700;font-size:16px}.actions{display:flex;justify-content:center;gap:8px;margin:16px auto;max-width:360px}.actions a,.actions button{padding:10px 13px;border:0;background:#a43b2a;color:#fff;text-decoration:none;font:inherit;font-weight:700;cursor:pointer}.actions a.secondary{background:#252421}@media print{@page{size:80mm auto;margin:4mm}body{padding:0;background:#fff;font-size:12px}.receipt{max-width:none;padding:0}.actions{display:none}}
    </style>
</head>
<body>
    <main class="receipt">
        <header class="center">
            <div class="brand">MerlinMarket</div>
            <div class="muted">Bukti pembayaran</div>
            <hr class="rule">
            <strong>{{ $order->invoice_number }}</strong>
            <div class="muted">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div class="muted">Kasir: {{ $order->user->name }}</div>
        </header>
        <hr class="rule">
        <table>
            <thead><tr><th>Produk</th><th>Jumlah</th><th>Subtotal</th></tr></thead>
            <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}<br><span class="muted">Rp{{ number_format((float) $item->unit_price, 0, ',', '.') }} / item</span></td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp{{ number_format((float) $item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr class="rule">
        <div class="totals">
            <p class="grand-total"><span>Total</span><span>Rp{{ number_format((float) $order->total, 0, ',', '.') }}</span></p>
            <p><span>Dibayar</span><span>Rp{{ number_format((float) $order->paid_amount, 0, ',', '.') }}</span></p>
            <p><span>Kembalian</span><span>Rp{{ number_format((float) $order->change_amount, 0, ',', '.') }}</span></p>
        </div>
        <hr class="rule">
        <p class="center muted">Terima kasih telah berbelanja di MerlinMarket.</p>
    </main>
    <nav class="actions" aria-label="Aksi struk">
        <button type="button" onclick="window.print()">Cetak struk</button>
        <a class="secondary" href="{{ route('orders.invoice', $order) }}">Unduh PDF</a>
        <a class="secondary" href="{{ route('cashier.dashboard') }}">Transaksi baru</a>
    </nav>
    @if (session('print_receipt'))
        <script>window.addEventListener('load', () => window.print());</script>
    @endif
</body>
</html>
