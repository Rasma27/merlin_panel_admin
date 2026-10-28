@extends('layouts.market')

@section('title', 'MerlinMarket | Belanja Mudah, Semua Ada')

@section('content')
<main class="page">
    <section class="hero">
        <div class="eyebrow">Temukan pilihan terbaik</div>
        <h1>Belanja nyaman,<br><span>pilihan lebih dekat.</span></h1>
        <p>MerlinMarket menghadirkan produk pilihan dengan pengalaman belanja yang praktis. Jelajahi katalog dan temukan yang Anda butuhkan.</p>
        <a class="btn" href="#produk">Jelajahi produk</a>
    </section>

    <section id="produk">
        <div class="section-head">
            <div><div class="eyebrow">Katalog MerlinMarket</div><h2>Produk pilihan</h2></div>
            <span class="muted">Diperbarui oleh tim kami</span>
        </div>
        @if ($products->isEmpty())
            <div class="empty">Produk baru akan segera hadir. Silakan kembali lagi nanti.</div>
        @else
            <div class="grid">
                @foreach ($products as $product)
                    <article class="card">
                        @if ($product->image_path)
                            <img class="product-image" src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}">
                        @else
                            <div class="placeholder" aria-hidden="true">MM</div>
                        @endif
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="muted">Stok tersedia: {{ $product->stock }}</div>
                        <div class="price">Rp{{ number_format((float) $product->price, 0, ',', '.') }}</div>
                    </article>
                @endforeach
            </div>
        @endif
        <div class="section-head">
            <p class="sub">Ingin berbelanja langsung? Kunjungi toko MerlinMarket dan hubungi kasir kami.</p>
            <a class="btn secondary" href="{{ route('login') }}">Masuk ke akun</a>
        </div>
    </section>
</main>
@endsection
