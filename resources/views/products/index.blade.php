@extends('layouts.market')

@section('title', 'Kelola Produk | MerlinMarket')

@section('content')
<main class="page">
    <div class="eyebrow">Area administrator</div>
    <div class="toolbar">
        <div><h1 class="page-title">Kelola produk</h1><p class="sub">Tambah produk dan atur stok katalog MerlinMarket.</p></div>
        <a class="btn" href="{{ route('admin.products.create') }}">Tambah produk</a>
    </div>
    @if ($products->isEmpty())
        <div class="empty">Belum ada produk. Tambahkan produk pertama MerlinMarket.</div>
    @else
        <div class="table-wrap">
            <table>
                <thead><tr><th>Produk</th><th>SKU</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td><td>{{ $product->sku }}</td>
                        <td>Rp{{ number_format((float) $product->price, 0, ',', '.') }}</td><td>{{ $product->stock }}</td>
                        <td><div class="actions">
                            <a class="btn outline small" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                            <form class="inline-form" method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')<button class="btn danger small" type="submit">Hapus</button>
                            </form>
                        </div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $products->links() }}</div>
    @endif
</main>
@endsection
