@extends('layouts.market')

@section('title', ($product->exists ? 'Edit Produk' : 'Tambah Produk').' | MerlinMarket')

@section('content')
<main class="page">
    <div class="eyebrow">Katalog MerlinMarket</div>
    <h1 class="page-title">{{ $product->exists ? 'Edit produk' : 'Tambah produk' }}</h1>
    <p class="sub">Gambar akan dipotong menjadi persegi, diputar sesuai pilihan, diberi watermark MerlinMarket, dan disimpan sebagai WebP.</p>

    <form class="form-card" method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if ($product->exists) @method('PUT') @endif
        <div class="fields">
            <div class="field"><label for="name">Nama produk</label><input id="name" name="name" value="{{ old('name', $product->name) }}" required maxlength="160">@error('name')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="sku">SKU</label><input id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required maxlength="80">@error('sku')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="price">Harga (Rp)</label><input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" min="0.01" step="0.01" required>@error('price')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="stock">Stok</label><input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>@error('stock')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field full"><label for="description">Deskripsi</label><textarea id="description" name="description" maxlength="3000">{{ old('description', $product->description) }}</textarea>@error('description')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="image">Gambar produk {{ $product->exists ? '(opsional)' : '' }}</label><input id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" {{ $product->exists ? '' : 'required' }}>@error('image')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="rotation">Putar gambar sebelum crop</label><select id="rotation" name="rotation"><option value="0">Tanpa rotasi</option><option value="90" @selected(old('rotation') === '90')>90°</option><option value="180" @selected(old('rotation') === '180')>180°</option><option value="270" @selected(old('rotation') === '270')>270°</option></select>@error('rotation')<div class="field-error">{{ $message }}</div>@enderror</div>
        </div>
        @if ($product->image_path)
            <p class="muted">Gambar saat ini</p><img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" width="120">
        @endif
        @if ($errors->any())<div class="error-list" role="alert">Periksa kembali data produk yang ditandai.</div>@endif
        <div class="actions" style="margin-top:16px"><button class="btn" type="submit">Simpan produk</button><a class="btn outline" href="{{ route('admin.products.index') }}">Batal</a></div>
    </form>
</main>
@endsection
