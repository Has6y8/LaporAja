<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#059669">
    <title>@yield('title') — LaporAja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --c-primary: #059669;
            --c-primary-dark: #047857;
            --c-primary-light: #10b981;
            --c-deep: #064e3b;
            --c-soft: #ecfdf5;
            --c-ink: #0f172a;
            --c-ink-2: #334155;
            --c-muted: #64748b;
            --c-border: #e2e8f0;
            --c-bg: #f8fafc;
            --r-sm: 10px;
            --r-md: 14px;
            --r-lg: 20px;
            --tr: 180ms cubic-bezier(.4,0,.2,1);
        }
        * { font-family: 'Inter', -apple-system, system-ui, sans-serif; -webkit-tap-highlight-color: transparent; }
        body { min-height: 100vh; background: var(--c-bg); color: var(--c-ink); font-size: .9375rem; -webkit-font-smoothing: antialiased; }

        .btn-primary {
            --bs-btn-bg: var(--c-primary);
            --bs-btn-border-color: var(--c-primary);
            --bs-btn-hover-bg: var(--c-primary-dark);
            --bs-btn-hover-border-color: var(--c-primary-dark);
            --bs-btn-active-bg: var(--c-primary-dark);
            --bs-btn-active-border-color: var(--c-primary-dark);
            border-radius: var(--r-sm);
            font-weight: 600;
            min-height: 44px;
            transition: all var(--tr);
            box-shadow: 0 4px 12px rgba(5,150,105,.2);
        }
        .btn-primary:hover { box-shadow: 0 6px 18px rgba(5,150,105,.28); }

        .form-control, .form-select {
            border-radius: var(--r-sm);
            border: 1px solid var(--c-border);
            padding: .65rem .9rem;
            font-size: .9375rem;
            min-height: 44px;
            transition: all var(--tr);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--c-primary-light);
            box-shadow: 0 0 0 3px rgba(16,185,129,.15);
        }
        .form-label { font-size: .8125rem; font-weight: 600; color: var(--c-ink-2); margin-bottom: .4rem; }

        /* ===== BRAND SIDE ===== */
        .brand-side {
            background:
                radial-gradient(circle at 85% 15%, rgba(255,255,255,.08) 0 30%, transparent 31%),
                radial-gradient(circle at 15% 85%, rgba(16,185,129,.35) 0 40%, transparent 41%),
                linear-gradient(150deg, #059669 0%, #064e3b 60%, #033b2b 100%);
            color: #fff;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        .brand-inner {
            position: relative;
            z-index: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: space-between;
            max-width: 560px;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -.02em;
            margin-bottom: 3rem;
        }
        .brand-logo .logo-mark {
            width: 44px; height: 44px;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            backdrop-filter: blur(8px);
        }
        .brand-side h1 {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -.04em;
            margin-bottom: 1rem;
        }
        .brand-side .lead {
            font-size: 1rem;
            line-height: 1.7;
            color: rgba(255,255,255,.8);
            margin-bottom: 2rem;
            max-width: 420px;
        }
        .feature-list { display: flex; flex-direction: column; gap: .75rem; margin-top: 1rem; }
        .feature-item {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .85rem 1rem;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: var(--r-md);
            font-size: .875rem;
            font-weight: 500;
        }
        .feature-item .feature-icon {
            width: 36px; height: 36px;
            background: rgba(16,185,129,.25);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            color: #a7f3d0;
        }
        .brand-footer { font-size: .8rem; color: rgba(255,255,255,.6); }

        /* ===== FORM SIDE ===== */
        .form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 1.5rem;
        }
        .form-card {
            width: 100%;
            max-width: 440px;
        }
        .form-card h2 {
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: -.03em;
            margin-bottom: .35rem;
            color: var(--c-ink);
        }
        .form-card .sub {
            color: var(--c-muted);
            font-size: .875rem;
            margin-bottom: 1.75rem;
        }

        .alert-soft {
            padding: .85rem 1rem;
            border-radius: var(--r-sm);
            font-size: .8125rem;
            display: flex;
            align-items: flex-start;
            gap: .55rem;
            margin-bottom: 1.25rem;
        }
        .alert-soft.alert-success { background: var(--c-soft); color: #065f46; border-left: 3px solid var(--c-primary); }
        .alert-soft.alert-danger  { background: #fef2f2; color: #991b1b; border-left: 3px solid #dc2626; }
        .alert-soft.alert-info    { background: #eff6ff; color: #1e40af; border-left: 3px solid #2563eb; }

        .demo-box {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: var(--r-md);
            background: var(--c-soft);
            border: 1px solid #d1fae5;
        }
        .demo-box .title {
            font-weight: 700;
            font-size: .75rem;
            color: var(--c-primary);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: .6rem;
            display: flex;
            align-items: center;
            gap: .35rem;
        }
        .demo-box .row-demo {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .5rem .9rem;
            font-size: .72rem;
            color: var(--c-ink-2);
        }
        .demo-box .row-demo b { color: var(--c-ink); }

        .link-primary {
            color: var(--c-primary);
            font-weight: 600;
            text-decoration: none;
        }
        .link-primary:hover { color: var(--c-primary-dark); text-decoration: underline; }

        @media (max-width: 991px) {
            .brand-side { display: none; }
            .form-side { padding: 1.5rem 1.25rem; min-height: auto; align-items: flex-start; padding-top: 2.5rem; padding-bottom: 2.5rem; }
            .form-card { max-width: 100%; }
            .form-card h2 { font-size: 1.5rem; }
        }

        .mobile-brand-top {
            display: none;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            font-weight: 800;
            color: var(--c-deep);
            font-size: 1.1rem;
            margin-bottom: 1.75rem;
            letter-spacing: -.02em;
        }
        .mobile-brand-top .logo-mark {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            box-shadow: 0 6px 18px rgba(16,185,129,.3);
        }
        @media (max-width: 991px) { .mobile-brand-top { display: flex; } }
    </style>
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
        {{-- BRAND SIDE --}}
        <div class="col-lg-6 brand-side">
            <div class="brand-inner">
                <div>
                    <div class="brand-logo">
                        <span class="logo-mark"><i class="bi bi-megaphone-fill"></i></span>
                        LaporAja
                    </div>

                    <h1>Laporkan Kerusakan<br>Sekolah dengan Mudah</h1>
                    <p class="lead">Sistem pengaduan sarana & prasarana SMK Negeri 5 Surakarta.</p>

                    <div class="feature-list">
                        <div class="feature-item">
                            <span class="feature-icon"><i class="bi bi-camera-fill"></i></span>
                            <span>Upload foto bukti kerusakan</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon"><i class="bi bi-graph-up-arrow"></i></span>
                            <span>Tracking status perbaikan real-time</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon"><i class="bi bi-shield-check"></i></span>
                            <span>Riwayat laporan tersimpan rapi</span>
                        </div>
                    </div>
                </div>

                <div class="brand-footer">© {{ date('Y') }} LaporAja — XII RPL C</div>
            </div>
        </div>

        {{-- FORM SIDE --}}
        <div class="col-lg-6 form-side">
            <div class="form-card">
                <div class="mobile-brand-top">
                    <span class="logo-mark"><i class="bi bi-megaphone-fill"></i></span>
                    LaporAja
                </div>
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>