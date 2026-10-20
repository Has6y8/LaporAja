<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — LaporAja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #059669;
            --bs-primary-rgb: 5, 150, 105;
        }
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { min-height: 100vh; background: #f1f5f9; }

        .btn-primary {
            --bs-btn-bg: #059669;
            --bs-btn-border-color: #059669;
            --bs-btn-hover-bg: #047857;
            --bs-btn-hover-border-color: #047857;
            --bs-btn-active-bg: #047857;
            --bs-btn-active-border-color: #047857;
            --bs-btn-focus-shadow-rgb: 5, 150, 105;
        }

        .brand-side {
            background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
            color: #fff;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        .brand-side::before,
        .brand-side::after {
            content: '';
            position: absolute;
            background: rgba(255,255,255,.06);
            border-radius: 50%;
        }
        .brand-side::before { width: 480px; height: 480px; top: -180px; right: -180px; }
        .brand-side::after { width: 320px; height: 320px; bottom: -140px; left: -140px; }

        .brand-side .container-content { position: relative; z-index: 1; }

        .logo-badge {
            width: 46px; height: 46px;
            background: rgba(255,255,255,.15);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            backdrop-filter: blur(8px);
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin-bottom: .85rem;
        }
        .feature-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,.15);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .form-control:focus {
            border-color: #059669;
            box-shadow: 0 0 0 .2rem rgba(5,150,105,.15);
        }

        @media (max-width: 991px) {
            .brand-side { display: none; }
        }
    
        /* LaporAja guest pages: login and registration */
        :root{--bs-primary:#087f5b;--bs-primary-rgb:8,127,91;--guest-ink:#173b2d}
        body{background:#f2f7f4!important;color:var(--guest-ink)}
        .brand-side{background:radial-gradient(circle at 90% 15%,#ffffff1b 0 9%,transparent 9.5%),linear-gradient(145deg,#0b8f68 0%,#07553f 72%,#063b2e 100%)!important}
        .brand-side::before,.brand-side::after{background:#ffffff0b!important}
        .brand-side .container-content{max-width:540px;margin-left:auto;margin-right:auto}
        .brand-side h1,.brand-side h2{letter-spacing:-.05em;font-weight:800}
        .brand-side .feature-item{display:flex;align-items:center;gap:13px;padding:13px 15px;border:1px solid #ffffff20;background:#ffffff0b;border-radius:14px;margin-top:10px}
        .brand-side .feature-icon{width:38px;height:38px;display:grid;place-items:center;border-radius:12px;background:#ffffff1a;color:#c9f7df;flex-shrink:0}
        body:has(.brand-side) .col-lg-6:last-child>div{background:#fff;border:1px solid #e3ede6;border-radius:24px;padding:34px!important;box-shadow:0 24px 70px #123d2d10}
        body:has(.brand-side) h2{font-size:1.9rem;letter-spacing:-.04em;color:#173b2d}
        body:has(.brand-side) .form-control{border:1px solid #dce8e0;border-radius:11px;padding:.72rem .9rem;min-height:45px}
        body:has(.brand-side) .form-control:focus{border-color:#4bb58b;box-shadow:0 0 0 .22rem #0b8f6819}
        body:has(.brand-side) .btn-primary{--bs-btn-bg:#087f5b;--bs-btn-border-color:#087f5b;--bs-btn-hover-bg:#066749;--bs-btn-hover-border-color:#066749;border-radius:11px;box-shadow:0 8px 18px #087f5b25}
        @media(max-width:991px){.brand-side{min-height:auto!important;padding:28px 22px!important}.brand-side .container-content:first-child{padding-top:10px!important}.brand-side .feature-item{display:none}.brand-side .container-content:last-child{margin-top:24px}.brand-side h1,.brand-side h2{font-size:1.65rem}body:has(.brand-side) .col-lg-6:last-child{min-height:auto!important;padding:20px!important}body:has(.brand-side) .col-lg-6:last-child>div{padding:25px!important}}
        
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row g-0">
        {{-- BRAND SIDE --}}
        <div class="col-lg-6 brand-side p-4 p-lg-5 d-flex flex-column justify-content-between">
            <div class="container-content">
                <div class="d-flex align-items-center gap-3 mb-5">
                    <div class="logo-badge"><i class="bi bi-megaphone-fill"></i></div>
                    <span class="fs-4 fw-bold">LaporAja</span>
                </div>

                <h1 class="display-5 fw-bold lh-sm mb-3">
                    Laporkan Kerusakan<br>Sekolah dengan Mudah
                </h1>
                <p class="fs-6 opacity-75 mb-4" style="max-width:400px;">
                    Sistem pengaduan sarana & prasarana SMK Negeri 5 Surakarta.
                </p>

                <div class="mt-4">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-camera-fill"></i></div>
                        <span>Upload foto bukti kerusakan</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <span>Tracking status perbaikan real-time</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                        <span>Riwayat laporan tersimpan rapi</span>
                    </div>
                </div>
            </div>

            <div class="container-content">
                <small class="opacity-75">© {{ date('Y') }} LaporAja — XII RPL C</small>
            </div>
        </div>

        {{-- FORM SIDE --}}
        <div class="col-lg-6 d-flex align-items-center justify-content-center p-4" style="min-height:100vh;">
            <div style="width:100%;max-width:420px;">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
