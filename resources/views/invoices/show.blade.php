<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        body{font-family:DejaVu Sans,sans-serif;color:#252421;font-size:12px}header{border-bottom:3px solid #a43b2a;padding-bottom:15px;margin-bottom:25px}.brand{font-size:22px;font-weight:bold;color:#a43b2a}.muted{color:#746e66;font-size:10px}.invoice{float:right;text-align:right}.invoice h1{font-size:18px;margin:0 0 6px}table{width:100%;border-collapse:collapse;margin-top:25px}th,td{border-bottom:1px solid #ded7cc;padding:10px;text-align:left}th{background:#f5f1e9;font-size:10px;text-transform:uppercase}.right{text-align:right}.total{font-weight:bold;font-size:14px;color:#a43b2a}.thanks{margin-top:35px;padding-top:12px;border-top:1px solid #ded7cc;color:#746e66}
    </style>
</head>
<body>
<header>
    <div class="invoice"><h1>INVOICE</h1><strong>{{ $order->invoice_number }}</strong><p class="muted">{{ $order->created_at->format('d/m/Y H:i') }}</p></div>
    <div class="brand">MerlinMarket</div><div class="muted">Bukti transaksi resmi</div>
</header>
<p><strong>Kasir:</strong> {{ $order->user->name }}</p>
<table>
    <thead><tr><th>Produk</th><th class="right">Harga</th><th class="right">Jumlah</th><th class="right">Subtotal</th></tr></thead>
    <tbody>
    @foreach ($order->items as $item)
        <tr><td>{{ $item->product_name }}</td><td class="right">Rp{{ number_format((float) $item->unit_price, 0, ',', '.') }}</td><td class="right">{{ $item->quantity }}</td><td class="right">Rp{{ number_format((float) $item->subtotal, 0, ',', '.') }}</td></tr>
    @endforeach
    <tr><td colspan="3" class="right total">Total</td><td class="right total">Rp{{ number_format((float) $order->total, 0, ',', '.') }}</td></tr>
    </tbody>
</table>
<p class="thanks">Terima kasih telah berbelanja di MerlinMarket.</p>
</body>
</html>
