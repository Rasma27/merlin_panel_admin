@extends('layouts.market')

@section('title', 'Masuk | MerlinMarket')

@section('content')
<main class="login-wrap">
    <section class="login-copy">
        <div class="eyebrow">Akses pengguna</div>
        <h1>Selamat datang<br>kembali.</h1>
        <p class="sub">Masuk ke MerlinMarket untuk mengelola produk sebagai admin atau mencatat transaksi sebagai kasir.</p>
        <p class="muted" style="margin-top:22px">Area admin dan kasir dilindungi autentikasi dan akses berdasarkan peran.</p>
    </section>
    <form class="login-card" method="POST" action="{{ route('login.store') }}">
        @csrf
        <h2 style="margin:0 0 7px">Masuk ke akun</h2>
        <p class="sub" style="margin-bottom:20px">Gunakan email dan kata sandi akun Anda.</p>
        @if ($errors->any())<div class="notice error-list" role="alert">{{ $errors->first() }}</div>@endif
        <div class="field"><label for="email">Alamat email</label><input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>@error('email')<div class="field-error">{{ $message }}</div>@enderror</div>
        <div class="field"><label for="password">Kata sandi</label><input id="password" type="password" name="password" autocomplete="current-password" required>@error('password')<div class="field-error">{{ $message }}</div>@enderror</div>
        <label class="muted" style="display:flex;align-items:center;gap:8px;margin:3px 0 17px"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
        <button class="btn" type="submit" style="width:100%">Masuk</button>
        <p class="muted" style="margin:18px 0 0;line-height:1.7">Akun demo:<br>Admin: admin@gmail.com · password<br>Kasir: kasir@gmail.com · password</p>
    </form>
</main>
@endsection
