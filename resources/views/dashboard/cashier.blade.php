@extends('layouts.market')

@section('title', 'Kasir | MerlinMarket')

@section('content')
<main class="page">
    <div class="eyebrow">Point of sale · MerlinMarket</div>
    <h1 class="page-title">Buat transaksi</h1>
    <p class="sub">Halo, {{ auth()->user()->name }}. Pilih produk dan jumlah yang dibeli untuk membuat invoice.</p>

    @if ($errors->any())
        <div class="notice error-list" role="alert">{{ $errors->first() }}</div>
    @endif
    @if ($products->isEmpty())
        <div class="empty" style="margin-top:20px">Belum ada produk dengan stok tersedia. Hubungi administrator MerlinMarket.</div>
    @else
        <form method="POST" action="{{ route('cashier.orders.store') }}">
            @csrf
            <div class="checkout-grid" style="margin-top:22px">
                <section>
                    <div class="eyebrow" style="margin-bottom:10px">Pilih produk</div>
                    @foreach ($products as $product)
                        <label class="product-pick">
                            <input class="product-check" type="checkbox" name="items[{{ $product->id }}][product_id]" value="{{ $product->id }}">
                            <span><strong>{{ $product->name }}</strong><br><span class="muted">Rp{{ number_format((float) $product->price, 0, ',', '.') }} · stok {{ $product->stock }}</span></span>
                            <input class="product-quantity" type="number" name="items[{{ $product->id }}][quantity]" value="1" min="1" max="{{ $product->stock }}" disabled aria-label="Jumlah {{ $product->name }}">
                        </label>
                    @endforeach
                </section>
                <aside class="panel">
                    <h2>Ringkasan penjualan</h2>
                    <p class="sub">Stok akan diperiksa dan dikurangi setelah transaksi berhasil disimpan.</p>
                    <button class="btn" type="submit" style="width:100%;margin-top:16px">Simpan & unduh invoice</button>
                </aside>
            </div>
        </form>
    @endif

    <div class="section-head"><div><div class="eyebrow">Riwayat Anda</div><h2>Transaksi terbaru</h2></div></div>
    @if ($orders->isEmpty())
        <div class="empty">Riwayat transaksi akan tampil di sini.</div>
    @else
        <div class="table-wrap">
            <table><thead><tr><th>Invoice</th><th>Tanggal</th><th>Total</th><th>Dokumen</th></tr></thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr><td>{{ $order->invoice_number }}</td><td>{{ $order->created_at->format('d/m/Y H:i') }}</td><td>Rp{{ number_format((float) $order->total, 0, ',', '.') }}</td><td><a class="text-link" href="{{ route('orders.invoice', $order) }}">Unduh invoice</a></td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</main>
<script>
    document.querySelectorAll('.product-check').forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            checkbox.closest('.product-pick').querySelector('.product-quantity').disabled = !checkbox.checked;
        });
    });
</script>
@endsection
