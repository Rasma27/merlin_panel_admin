<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f1e9">
    <title>@yield('title', 'MerlinMarket')</title>
    <style>
        :root{font-family:Arial,sans-serif;color:#252421;background:#f5f1e9;--brand:#a43b2a;--ink:#252421;--muted:#746e66;--line:#ded7cc;--paper:#fbf9f4}*{box-sizing:border-box}body{margin:0;min-width:320px}a{color:inherit;text-decoration:none}button,input,textarea,select{font:inherit}.shell{max-width:1240px;margin:auto;padding:0 28px}.topbar{height:74px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:20px}.brand{display:flex;align-items:center;gap:10px;font-size:15px;font-weight:800;letter-spacing:.3px}.mark{width:35px;height:35px;display:grid;place-items:center;background:var(--brand);color:white;font-size:13px}.nav{display:flex;align-items:center;gap:19px;font-size:12px}.nav a:hover,.text-link{color:var(--brand)}.user-nav{display:flex;align-items:center;gap:12px}.page{padding:34px 0 58px}.eyebrow{font-size:10px;letter-spacing:1.4px;text-transform:uppercase;color:var(--brand);font-weight:700}.page-title{margin:8px 0 5px;font-size:clamp(24px,4vw,36px);letter-spacing:-.7px}.sub{color:var(--muted);font-size:13px;line-height:1.7;margin:0}.hero{padding:73px 0 58px;max-width:730px}.hero h1{font-size:clamp(42px,8vw,82px);line-height:1;letter-spacing:-3px;margin:17px 0}.hero h1 span{color:var(--brand)}.hero p{max-width:570px;line-height:1.8;color:var(--muted);font-size:15px}.section-head{display:flex;justify-content:space-between;align-items:end;gap:18px;margin:32px 0 17px}.section-head h2{font-size:21px;margin:0}.grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:15px}.card{background:var(--paper);border:1px solid var(--line);padding:14px}.product-image{width:100%;aspect-ratio:1/1;object-fit:cover;background:#eee8dd}.placeholder{width:100%;aspect-ratio:1/1;display:grid;place-items:center;background:#eee8dd;color:#a89c8d;font-size:28px}.product-name{font-size:14px;font-weight:700;margin:13px 0 5px}.muted{color:var(--muted);font-size:11px}.price{color:var(--brand);font-weight:800;font-size:14px;margin-top:10px}.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:11px 15px;border:0;background:var(--brand);color:white;font-size:12px;font-weight:700;cursor:pointer}.btn:hover{background:#832e21}.btn.secondary{background:var(--ink)}.btn.outline{border:1px solid var(--line);background:transparent;color:var(--ink)}.btn.danger{background:#8c2922}.btn.small{padding:8px 10px;font-size:11px}.notice{padding:12px 14px;background:#edf2e8;border:1px solid #d5dfcc;color:#36533b;font-size:12px;margin:14px 0}.error-list,.field-error{color:#a43b2a;font-size:12px}.stat-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));border-top:1px solid var(--line);border-bottom:1px solid var(--line);margin:24px 0}.stat{padding:19px 22px;border-right:1px solid var(--line)}.stat:last-child{border-right:0}.stat strong{display:block;color:var(--brand);font-size:30px;margin:8px 0}.table-wrap{overflow-x:auto;border:1px solid var(--line);background:var(--paper)}table{width:100%;border-collapse:collapse;font-size:12px}th,td{text-align:left;padding:13px 14px;border-bottom:1px solid #ebe6dd;white-space:nowrap}th{font-size:10px;text-transform:uppercase;letter-spacing:.7px;color:var(--muted)}tr:last-child td{border-bottom:0}.inline-form{display:inline}.toolbar{display:flex;justify-content:space-between;align-items:center;gap:12px;margin:22px 0 14px}.form-card{max-width:760px;background:var(--paper);border:1px solid var(--line);padding:24px}.fields{display:grid;grid-template-columns:1fr 1fr;gap:16px}.field{margin-bottom:15px}.field.full{grid-column:1/-1}.field label{display:block;font-size:11px;font-weight:700;margin-bottom:7px}.field input,.field textarea,.field select{width:100%;border:1px solid #cfc7bb;background:#fffefa;padding:11px 12px;font-size:13px}.field textarea{min-height:110px;resize:vertical}.field input:focus,.field textarea:focus,.field select:focus{outline:2px solid #e6c6b7;border-color:var(--brand)}.actions{display:flex;align-items:center;gap:9px}.pagination{margin-top:16px;font-size:12px}.checkout-grid{display:grid;grid-template-columns:1.2fr .8fr;gap:20px;align-items:start}.product-pick{display:flex;align-items:center;gap:13px;padding:13px;border:1px solid var(--line);background:var(--paper)}.product-pick+.product-pick{border-top:0}.product-pick input[type=number]{width:75px;margin-left:auto;padding:8px;border:1px solid var(--line)}.product-pick input[type=checkbox]{accent-color:var(--brand)}.panel{background:var(--paper);border:1px solid var(--line);padding:20px}.panel h2,.panel h3{margin:0 0 12px;font-size:16px}.footer{border-top:1px solid var(--line);padding:19px 0 27px;color:var(--muted);font-size:11px}.login-wrap{min-height:calc(100vh - 150px);display:grid;grid-template-columns:1fr 420px;gap:70px;align-items:center;max-width:980px;margin:auto}.login-card{background:var(--paper);border-top:3px solid var(--brand);padding:28px}.login-copy h1{font-size:44px;line-height:1.05}.empty{padding:30px;text-align:center;background:var(--paper);border:1px dashed var(--line);color:var(--muted);font-size:13px}.pagination nav{display:flex;gap:8px}@media(max-width:850px){.grid{grid-template-columns:repeat(2,minmax(0,1fr))}.checkout-grid{grid-template-columns:1fr}.login-wrap{grid-template-columns:1fr;gap:20px;padding:30px 0}.login-copy p{max-width:540px}}@media(max-width:560px){.shell{padding:0 17px}.topbar{height:65px}.nav{gap:10px;font-size:11px}.hero{padding:52px 0 35px}.hero h1{letter-spacing:-2px}.grid{grid-template-columns:1fr 1fr;gap:9px}.card{padding:9px}.product-name{font-size:12px}.stat-grid{grid-template-columns:1fr}.stat{border-right:0;border-bottom:1px solid var(--line);padding:13px 4px}.stat:last-child{border-bottom:0}.fields{grid-template-columns:1fr}.field.full{grid-column:auto}.section-head,.toolbar{align-items:flex-start;flex-direction:column}.user-nav .user-name{display:none}.page{padding-top:25px}}
    </style>
</head>
<body>
<div class="shell">
    <header class="topbar">
        <a class="brand" href="{{ route('home') }}"><span class="mark">MM</span> MerlinMarket</a>
        <nav class="nav" aria-label="Navigasi utama">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Ringkasan</a>
                    <a href="{{ route('admin.products.index') }}">Produk</a>
                @else
                    <a href="{{ route('cashier.dashboard') }}">Kasir</a>
                @endif
                <span class="user-nav"><span class="user-name">{{ auth()->user()->name }}</span>
                    <form class="inline-form" method="POST" action="{{ route('logout') }}">@csrf<button class="btn outline small" type="submit">Keluar</button></form>
                </span>
            @else
                <a href="{{ route('login') }}">Masuk</a>
            @endauth
        </nav>
    </header>
    @if (session('status'))
        <div class="notice" role="status">{{ session('status') }}</div>
    @endif
    @yield('content')
    <footer class="footer">MerlinMarket · Belanja praktis, layanan terpercaya · {{ date('Y') }}</footer>
</div>
@stack('scripts')
</body>
</html>
