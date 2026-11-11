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
        <form method="POST" action="{{ route('cashier.orders.store') }}" id="checkout-form">
            @csrf
            <div class="checkout-grid" style="margin-top:22px">
                <section>
                    <div class="eyebrow" style="margin-bottom:10px">Pilih produk</div>
                    @foreach ($products as $product)
                        <label class="product-pick">
                            <input class="product-check" type="checkbox" name="items[{{ $product->id }}][product_id]" value="{{ $product->id }}" data-unit-price-cents="{{ (int) round((float) $product->price * 100) }}" @checked(old('items.'.$product->id.'.product_id') == $product->id)>
                            <span><strong>{{ $product->name }}</strong><br><span class="muted">Rp{{ number_format((float) $product->price, 0, ',', '.') }} · stok {{ $product->stock }}</span></span>
                            <input class="product-quantity" type="number" name="items[{{ $product->id }}][quantity]" value="{{ old('items.'.$product->id.'.quantity', 1) }}" min="1" max="{{ $product->stock }}" @disabled(old('items.'.$product->id.'.product_id') != $product->id) aria-label="Jumlah {{ $product->name }}">
                        </label>
                    @endforeach
                </section>
                <aside class="panel">
                    <h2>Ringkasan penjualan</h2>
                    <p class="sub">Stok akan diperiksa dan dikurangi setelah transaksi berhasil disimpan.</p>
                    <p style="margin:18px 0 6px">Total item <strong id="cart-count">0</strong></p>
                    <p style="margin:0 0 18px">Total <strong id="order-total">Rp0</strong></p>
                    <div class="field">
                        <label for="paid-amount">Uang dibayar</label>
                        <input id="paid-amount" name="paid_amount" type="number" min="0.01" step="0.01" value="{{ old('paid_amount') }}" required inputmode="decimal" aria-describedby="payment-status">
                    </div>
                    <div id="quick-payments" class="actions" aria-label="Nominal pembayaran cepat"></div>
                    <p id="change-amount" style="margin:16px 0 4px">Kembalian <strong>Rp0</strong></p>
                    <p id="payment-status" class="muted" role="status" aria-live="polite">Pilih produk untuk menghitung total.</p>
                    <button class="btn" type="submit" style="width:100%;margin-top:16px">Bayar & cetak struk</button>
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
    const productChecks = [...document.querySelectorAll('.product-check')];
    const paidAmount = document.querySelector('#paid-amount');
    const quickPayments = document.querySelector('#quick-payments');
    const rupiah = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    });

    function renderQuickPayments(totalCents) {
        quickPayments.replaceChildren();
        if (totalCents <= 0) {
            return;
        }

        const amounts = [
            totalCents,
            Math.ceil(totalCents / 1000000) * 1000000,
            Math.ceil(totalCents / 5000000) * 5000000,
            Math.ceil(totalCents / 10000000) * 10000000,
        ];

        [...new Set(amounts)].forEach((amountCents) => {
            const button = document.createElement('button');
            button.className = 'btn outline small';
            button.type = 'button';
            button.textContent = amountCents === totalCents ? 'Uang pas' : rupiah.format(amountCents / 100);
            button.addEventListener('click', () => {
                paidAmount.value = (amountCents / 100).toFixed(2);
                updateSummary();
            });
            quickPayments.append(button);
        });
    }

    function updateSummary() {
        const selected = productChecks.filter((checkbox) => checkbox.checked);
        const totalCents = selected.reduce((total, checkbox) => {
            const quantity = Number(checkbox.closest('.product-pick').querySelector('.product-quantity').value);
            return total + Number(checkbox.dataset.unitPriceCents) * (Number.isInteger(quantity) ? quantity : 0);
        }, 0);
        const paidCents = Math.round(Number(paidAmount.value) * 100) || 0;
        const differenceCents = paidCents - totalCents;

        document.querySelector('#cart-count').textContent = String(selected.reduce((count, checkbox) => {
            return count + (Number(checkbox.closest('.product-pick').querySelector('.product-quantity').value) || 0);
        }, 0));
        document.querySelector('#order-total').textContent = rupiah.format(totalCents / 100);
        document.querySelector('#change-amount strong').textContent = rupiah.format(Math.max(0, differenceCents) / 100);
        document.querySelector('#payment-status').textContent = totalCents === 0
            ? 'Pilih produk untuk menghitung total.'
            : differenceCents < 0
                ? `Pembayaran kurang ${rupiah.format(Math.abs(differenceCents) / 100)}.`
                : 'Pembayaran cukup.';
        renderQuickPayments(totalCents);
    }

    productChecks.forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            checkbox.closest('.product-pick').querySelector('.product-quantity').disabled = !checkbox.checked;
            updateSummary();
        });
        checkbox.closest('.product-pick').querySelector('.product-quantity').addEventListener('input', updateSummary);
    });
    paidAmount.addEventListener('input', updateSummary);
    updateSummary();
</script>
@endsection
