<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LaporAja') }} — Pelaporan Sarana Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--green:#0b8f68;--deep:#07553f;--ink:#142d26;--muted:#71847c}
        *{box-sizing:border-box}body{margin:0;font-family:Inter,system-ui,sans-serif;background:#f5f8f6;color:var(--ink)}
        .hero{min-height:100vh;overflow:hidden;position:relative;background:radial-gradient(circle at 80% 10%,#d7f5e7 0,transparent 28%),linear-gradient(135deg,#f8fbf9 0%,#edf8f2 100%)}
        .navwrap{max-width:1160px;margin:auto;padding:28px 24px;display:flex;align-items:center;justify-content:space-between}
        .brand{display:flex;gap:12px;align-items:center;font-weight:800;font-size:1.2rem;color:var(--deep);text-decoration:none}
        .brand-mark{display:grid;place-items:center;width:44px;height:44px;border-radius:15px;background:var(--green);color:white;font-size:1.3rem;box-shadow:0 10px 25px #0b8f6833}
        .navtag{font-size:.85rem;color:var(--muted);font-weight:600}
        .hero-inner{max-width:1160px;margin:auto;padding:70px 24px 100px;display:grid;grid-template-columns:1.1fr .9fr;gap:60px;align-items:center}
        .eyebrow{display:inline-flex;align-items:center;gap:8px;padding:8px 13px;border:1px solid #c7ead8;border-radius:999px;background:#fff;color:var(--deep);font-size:.78rem;font-weight:700}
        h1{font-size:clamp(2.6rem,5vw,4.7rem);line-height:1.06;letter-spacing:-.055em;font-weight:800;margin:22px 0}
        h1 span{color:var(--green)}.lead{font-size:1.05rem;line-height:1.85;color:#60766c;max-width:550px}
        .actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:30px}.btn-hero{padding:13px 19px;border-radius:13px;font-weight:700;text-decoration:none;display:inline-flex;gap:9px;align-items:center}
        .primary{background:var(--green);color:#fff;box-shadow:0 12px 25px #0b8f682b}.primary:hover{background:var(--deep);color:#fff}
        .secondary{background:#fff;color:var(--deep);border:1px solid #dce9e1}.secondary:hover{background:#f0f8f3;color:var(--deep)}
        .visual{position:relative;padding:25px}.visual-card{background:#fff;border:1px solid #e2eee7;border-radius:28px;padding:26px;box-shadow:0 30px 80px #184d3520;transform:rotate(1deg)}
        .visual-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:26px}.visual-title{font-weight:800}.tiny{font-size:.75rem;color:#83948b}
        .status-line{display:flex;gap:14px;align-items:center;padding:16px 0;border-bottom:1px solid #edf2ee}.status-line:last-child{border:0}
        .ico{width:44px;height:44px;display:grid;place-items:center;border-radius:14px;background:#e7f7ef;color:var(--green);font-size:1.2rem;flex-shrink:0}
        .float-chip{position:absolute;bottom:4px;left:-2px;background:#fff;padding:15px 18px;border:1px solid #e4eee8;border-radius:17px;box-shadow:0 15px 35px #174b3420;font-size:.83rem;font-weight:700}
        .float-chip i{color:var(--green);font-size:1.1rem;margin-right:7px}
        .features{max-width:1160px;margin:-40px auto 0;padding:0 24px 70px;display:grid;grid-template-columns:repeat(3,1fr);gap:18px;position:relative}
        .feature{background:#fff;border:1px solid #e5eee8;border-radius:20px;padding:23px;box-shadow:0 12px 35px #174b3408}.feature i{font-size:1.4rem;color:var(--green)}
        .feature h3{font-size:1rem;font-weight:800;margin:13px 0 7px}.feature p{font-size:.87rem;line-height:1.7;color:var(--muted);margin:0}
        @media(max-width:760px){.hero-inner{grid-template-columns:1fr;padding-top:35px;gap:28px}.visual{padding:5px}.features{grid-template-columns:1fr;margin-top:0}.navtag{display:none}.hero-inner{padding-bottom:60px}h1{font-size:2.8rem}}
    </style>
</head>
<body>
<section class="hero">
    <nav class="navwrap">
        <a class="brand" href="{{ url('/') }}"><span class="brand-mark"><i class="bi bi-megaphone-fill"></i></span>LaporAja</a>
        <span class="navtag">Pelaporan sarana & prasarana sekolah</span>
        <a class="btn-hero secondary" href="{{ route('login') }}">Masuk <i class="bi bi-arrow-right"></i></a>
    </nav>
    <div class="hero-inner">
        <div>
            <span class="eyebrow"><i class="bi bi-stars"></i> Layanan digital sekolah</span>
            <h1>Laporan jelas.<br><span>Penanganan tuntas.</span></h1>
            <p class="lead">Sampaikan laporan kerusakan sarana sekolah dengan mudah, pantau perkembangannya, dan lihat riwayat penanganan dalam satu tempat.</p>
            <div class="actions">
                <a class="btn-hero primary" href="{{ route('login') }}">Mulai Melapor <i class="bi bi-arrow-up-right"></i></a>
                <a class="btn-hero secondary" href="{{ route('register') }}">Ajukan Akun</a>
            </div>
        </div>
        <div class="visual">
            <div class="visual-card">
                <div class="visual-top"><div><div class="tiny mb-1">CONTOH PEMANTAUAN</div><div class="visual-title">Status laporan</div></div><span class="badge rounded-pill text-bg-success">Live tracking</span></div>
                <div class="status-line"><div class="ico"><i class="bi bi-send-check"></i></div><div class="flex-grow-1"><div class="fw-bold">Laporan terkirim</div><div class="tiny">Data masuk ke sistem</div></div><i class="bi bi-check-circle-fill text-success"></i></div>
                <div class="status-line"><div class="ico"><i class="bi bi-tools"></i></div><div class="flex-grow-1"><div class="fw-bold">Sedang ditangani</div><div class="tiny">Petugas melakukan pemeriksaan</div></div><span class="badge text-bg-warning">Proses</span></div>
                <div class="status-line"><div class="ico"><i class="bi bi-check2-circle"></i></div><div class="flex-grow-1"><div class="fw-bold">Selesai diperbaiki</div><div class="tiny">Bukti perbaikan tersimpan</div></div><i class="bi bi-circle text-secondary"></i></div>
            </div>
            <div class="float-chip"><i class="bi bi-shield-check"></i> Terpantau dan terdokumentasi</div>
        </div>
    </div>
</section>
<div class="features">
    <article class="feature"><i class="bi bi-camera-fill"></i><h3>Lengkapi bukti</h3><p>Sertakan foto dan lokasi agar laporan mudah dipahami petugas.</p></article>
    <article class="feature"><i class="bi bi-graph-up-arrow"></i><h3>Pantau progres</h3><p>Lihat status laporan dan catatan penanganan secara terstruktur.</p></article>
    <article class="feature"><i class="bi bi-clock-history"></i><h3>Riwayat tersimpan</h3><p>Periksa kembali laporan yang sudah selesai atau ditolak.</p></article>
</div>
</body>
</html>
