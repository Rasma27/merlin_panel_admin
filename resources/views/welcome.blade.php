<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f2efe9">
    <title>{{ config('app.name', 'Ruang Kerja') }} | Sistem Operasional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{font-family:'DM Sans',sans-serif;color:#202421;background:#f2efe9;--green:#1d553f;--muted:#727970;--line:#d9ddd4}*{box-sizing:border-box}body{margin:0;min-width:320px;background:radial-gradient(ellipse at 87% 8%,rgba(205,222,163,.42),transparent 31%),#f2efe9}a{color:inherit;text-decoration:none}.shell{max-width:1120px;margin:auto;padding:26px 34px}.nav{height:55px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(32,36,33,.13)}.brand{display:flex;align-items:center;gap:10px;font:800 16px 'Manrope',sans-serif}.mark{width:34px;height:34px;display:grid;place-items:center;border-radius:9px;background:var(--green);color:#d3ef77}.login{padding:10px 15px;border:1px solid #bfc5ba;border-radius:4px;font-size:12px;font-weight:700}.hero{padding:100px 0 78px;max-width:720px}.eyebrow{color:var(--green);font-size:10px;font-weight:700}.hero h1{font:600 clamp(40px,7vw,68px)/1.08 'Manrope',sans-serif;letter-spacing:0;margin:20px 0}.hero h1 span{color:var(--green)}.hero p{max-width:520px;color:var(--muted);font-size:14px;line-height:1.8}.primary{display:inline-block;margin-top:14px;padding:13px 17px;border-radius:4px;background:var(--green);color:white;font-size:12px;font-weight:700}.section{border-top:1px solid var(--line);padding-top:25px}.section h2{font:600 21px 'Manrope',sans-serif;letter-spacing:0;margin:0 0 17px}.roles{display:grid;grid-template-columns:1fr 1fr;gap:14px}.role{background:#fbfcf9;border:1px solid var(--line);border-radius:5px;padding:20px}.role h3{font:700 14px 'Manrope',sans-serif;margin:0 0 8px}.role p{font-size:11px;color:var(--muted);line-height:1.6;margin:0}.footer{margin-top:38px;padding-top:15px;border-top:1px solid var(--line);font-size:10px;color:#777e75}@media(max-width:600px){.shell{padding:18px 20px}.hero{padding:68px 0 55px}.roles{grid-template-columns:1fr}}
    </style>
    <style>
        :root{font-family:'DM Sans',sans-serif;color:#252421;background:#f4f0e9;--green:#a43b2a;--muted:#706b64;--line:#d5cec2}body{background:linear-gradient(90deg,transparent 49.95%,rgba(37,36,33,.045) 50%,transparent 50.05%),#f4f0e9}.shell{max-width:1360px;padding:22px 5vw}.nav{height:63px;border-bottom:1px solid #cfc7bb}.brand{font-family:'DM Sans',sans-serif;font-size:14px;text-transform:uppercase;letter-spacing:1px}.mark{border-radius:2px;background:#a43b2a;color:#fff3e3;font:700 16px 'DM Sans',sans-serif}.login{border:0;border-radius:2px;background:#252421;color:#fff;padding:11px 17px}.hero{max-width:none;min-height:450px;padding:86px 0 73px;position:relative;display:flex;flex-direction:column;justify-content:center}.hero:after{content:'01 / 02';position:absolute;right:1%;top:48%;transform:translateY(-50%);font:800 clamp(95px,19vw,250px)/.8 'Manrope',sans-serif;color:#e9e2d6;letter-spacing:0;z-index:0;pointer-events:none}.hero>*{position:relative;z-index:1}.eyebrow{color:#a43b2a;font-family:'DM Sans',sans-serif;letter-spacing:1.3px}.hero h1{font:600 clamp(48px,7vw,88px)/.98 'Manrope',sans-serif;max-width:790px;margin:20px 0 22px}.hero h1 span{color:#a43b2a}.hero p{max-width:450px;font-size:14px}.primary{margin-top:18px;border-radius:2px;background:#a43b2a;padding:15px 20px}.section{border-top:2px solid #252421;padding-top:21px}.section h2{font-size:17px}.roles{gap:0;border-top:1px solid var(--line);border-bottom:1px solid var(--line)}.role{background:transparent;border:0;border-right:1px solid var(--line);border-radius:0;padding:22px 25px 22px 0}.role:last-child{border-right:0;padding-left:25px}.role h3{font-size:13px;text-transform:uppercase;letter-spacing:.8px}.role p{font-size:12px}.footer{border:0;margin-top:22px;padding:0;font-family:'DM Sans',sans-serif}@media(max-width:600px){.hero{min-height:390px;padding:57px 0}.hero:after{top:70%;right:0;font-size:100px}.role,.role:last-child{padding:18px 0;border-right:0;border-bottom:1px solid var(--line)}.role:last-child{border-bottom:0}}
    </style>
    <style>
        .primary{align-self:flex-start}@media(min-width:601px){.hero:after{top:auto;bottom:16px;transform:none;right:0}}@media(max-width:600px){.hero:after{display:none}}
    </style>
</head>
<body>
<div class="shell">
    <header class="nav"><a class="brand" href="{{ route('home') }}"><span class="mark">R</span> Ruang Kerja</a><a class="login" href="{{ route('login') }}">Masuk</a></header>
    <main>
        <section class="hero">
            <div class="eyebrow">SISTEM INFORMASI · AKSES TERKENDALI</div>
            <h1>Satu ruang kerja.<br><span>Dua peran.</span></h1>
            <p>Kelola aktivitas operasional melalui akses yang sesuai untuk setiap pengguna. Masuk sebagai admin atau kasir untuk menuju ruang kerja Anda.</p>
            <a class="primary" href="{{ route('login') }}">Masuk ke sistem</a>
        </section>
        <section class="section">
            <h2>Ruang untuk setiap peran</h2>
            <div class="roles">
                <article class="role"><h3>Admin</h3><p>Kelola ruang kerja dan akses sesuai kewenangan administrator.</p></article>
                <article class="role"><h3>Kasir</h3><p>Akses halaman operasional kasir yang dipisahkan dengan middleware role.</p></article>
            </div>
        </section>
    </main>
    <footer class="footer">{{ config('app.name', 'Ruang Kerja') }} · Akses sesuai peran · {{ date('Y') }}</footer>
</div>
</body>
</html>