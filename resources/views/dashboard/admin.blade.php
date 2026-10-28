@extends('layouts.market')

@section('title', 'Ringkasan Admin | MerlinMarket')

@section('content')
<main class="page">
    <div class="eyebrow">Area administrator</div>
    <h1 class="page-title">Ringkasan admin</h1>
    <p class="sub">Selamat bekerja, {{ auth()->user()->name }}. Pantau katalog dan transaksi MerlinMarket.</p>
    <div id="order-notification" class="notice" role="status" aria-live="polite" hidden></div>

    <section class="stat-grid" aria-label="Statistik MerlinMarket">
        <article class="stat"><span class="muted">Produk</span><strong>{{ $productCount }}</strong><span class="muted">Produk terdaftar</span></article>
        <article class="stat"><span class="muted">Transaksi</span><strong id="order-count">{{ $orderCount }}</strong><span class="muted">Invoice tersimpan</span></article>
        <article class="stat"><span class="muted">Pengguna</span><strong>{{ $userCount }}</strong><span class="muted">Akun admin dan kasir</span></article>
    </section>

    <div class="section-head">
        <div><div class="eyebrow">Katalog</div><h2>Kelola produk</h2></div>
        <a class="btn" href="{{ route('admin.products.index') }}">Buka katalog admin</a>
    </div>
    <div class="panel">
        <h3>Produk dan gambar</h3>
        <p class="sub">Tambahkan foto produk. MerlinMarket akan melakukan crop, rotasi pilihan, watermark, dan konversi WebP otomatis.</p>
    </div>

    <div class="section-head"><div><div class="eyebrow">Aktivitas toko</div><h2>Transaksi terbaru</h2></div></div>
    @if ($orders->isEmpty())
        <div class="empty">Belum ada transaksi di MerlinMarket.</div>
    @else
        <div class="table-wrap">
            <table>
                <thead><tr><th>Invoice</th><th>Kasir</th><th>Tanggal</th><th>Total</th><th>Dokumen</th></tr></thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr><td>{{ $order->invoice_number }}</td><td>{{ $order->user->name }}</td><td>{{ $order->created_at->format('d/m/Y H:i') }}</td><td>Rp{{ number_format((float) $order->total, 0, ',', '.') }}</td><td><a class="text-link" href="{{ route('orders.invoice', $order) }}">Unduh invoice</a></td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</main>
@push('scripts')
    @vite('resources/js/app.js')
@endpush
@endsection
