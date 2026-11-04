<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#059669">
    <title>@yield('title') — LaporAja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            --r-sm: 10px;
            --r-md: 14px;
            --r-lg: 20px;
            --tr: 180ms cubic-bezier(.4,0,.2,1);
        }

        * { font-family: 'Inter', -apple-system, system-ui, sans-serif; -webkit-tap-highlight-color: transparent; }
        body { background-color: #f8fafc; color: var(--c-ink); min-height: 100vh; margin: 0; overflow-x: hidden; }

        .auth-wrapper { display: flex; min-height: 100vh; width: 100%; position: relative; }
        
        /* =========================================
           DESKTOP VIEW (Kiri Gambar, Kanan Form)
           ========================================= */
        @media (min-width: 992px) {
            .auth-image-side {
                width: 50%;
                /* GAMBAR SEKOLAH (DESKTOP) */
                background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReSw_vM67L7OxWZt3L59-G27v-_L0i_7IhHkwaFDeK7w&s=10');
                background-size: cover;
                background-position: center;
                position: relative;
                display: flex;
            }

            /* Overlay warna hijau transparan */
            .auth-image-side::before {
                content: '';
                position: absolute; inset: 0;
                background: linear-gradient(135deg, rgba(6, 78, 59, 0.85) 0%, rgba(5, 150, 105, 0.6) 100%);
            }

            .auth-image-content {
                position: relative; z-index: 1;
                display: flex; flex-direction: column; justify-content: space-between;
                height: 100%; padding: 4rem; color: #fff; width: 100%;
            }

            .brand-logo { display: flex; align-items: center; gap: 0.75rem; font-weight: 800; font-size: 1.5rem; color: #fff; text-decoration: none; }
            .brand-logo .logo-mark { width: 44px; height: 44px; background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
            
            .image-text h2 { font-size: 2.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 1rem; letter-spacing: -0.03em; }
            .image-text p { font-size: 1.1rem; opacity: 0.9; max-width: 480px; line-height: 1.6; }

            .auth-form-side {
                width: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.5rem;
                background: #fff;
            }

            .auth-form-container { width: 100%; max-width: 400px; }
            .mobile-brand-logo { display: none !important; }
        }

        /* =========================================
           MOBILE VIEW (Gambar Full Background)
           ========================================= */
        @media (max-width: 991px) {
            .auth-wrapper {
                align-items: center;
                justify-content: center;
                padding: 1.5rem 1rem;
            }

            .auth-image-side {
                position: fixed;
                inset: 0;
                width: 100%;
                height: 100vh;
                z-index: -1;
                /* GAMBAR SEKOLAH (MOBILE) */
                background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReSw_vM67L7OxWZt3L59-G27v-_L0i_7IhHkwaFDeK7w&s=10');
                background-size: cover;
                background-position: center;
            }

            .auth-image-side::before {
                content: '';
                position: absolute; inset: 0;
                background: linear-gradient(135deg, rgba(6, 78, 59, 0.9) 0%, rgba(5, 150, 105, 0.8) 100%);
            }

            /* Konten teks di gambar disembunyikan di HP */
            .auth-image-content { display: none; }

            .auth-form-side {
                width: 100%;
                background: transparent;
                display: block;
            }

            /* Kotak Form Putih Melayang */
            .auth-form-container {
                background: #fff;
                padding: 2.5rem 1.75rem;
                border-radius: 24px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 420px;
                margin: 0 auto;
                position: relative;
            }
        }

        /* =========================================
           LOGO MOBILE (Khusus di dalam form)
           ========================================= */
        .mobile-brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--c-deep);
            margin-bottom: 2rem;
            letter-spacing: -0.03em;
        }
        .mobile-brand-logo .logo-mark {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            box-shadow: 0 8px 16px rgba(16,185,129,.3);
        }

        /* =========================================
           STYLING FORM (Sama untuk Desktop & Mobile)
           ========================================= */
        .form-label { font-size: .8125rem; font-weight: 600; color: var(--c-ink-2); margin-bottom: 0.4rem; }
        .form-control {
            border-radius: var(--r-sm); border: 1px solid var(--c-border);
            padding: 0.75rem 1rem; font-size: .9375rem; min-height: 48px;
            transition: all var(--tr); background-color: #f8fafc;
        }
        .form-control:focus { border-color: var(--c-primary-light); box-shadow: 0 0 0 4px rgba(16,185,129,.15); background-color: #fff; }
        
        .input-group-text {
            background-color: #f8fafc; border: 1px solid var(--c-border); border-right: none;
            border-radius: var(--r-sm) 0 0 var(--r-sm); color: var(--c-muted); padding: 0 1rem;
        }
        .input-group .form-control { border-left: none; border-radius: 0 var(--r-sm) var(--r-sm) 0; }
        .input-group:focus-within .input-group-text { border-color: var(--c-primary-light); background-color: #fff; }

        .btn-primary {
            --bs-btn-bg: var(--c-primary); --bs-btn-border-color: var(--c-primary);
            --bs-btn-hover-bg: var(--c-primary-dark); --bs-btn-hover-border-color: var(--c-primary-dark);
            border-radius: var(--r-sm); font-weight: 600; min-height: 48px; transition: all var(--tr);
            box-shadow: 0 4px 12px rgba(5,150,105,.2);
        }
        .btn-primary:hover { box-shadow: 0 6px 16px rgba(5,150,105,.3); }

        .alert-soft { padding: .85rem 1rem; border-radius: var(--r-sm); font-size: .8125rem; display: flex; align-items: flex-start; gap: .55rem; margin-bottom: 1.25rem; }
        .alert-soft.alert-danger { background: #fef2f2; color: #991b1b; border-left: 3px solid #dc2626; }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        {{-- BACKGROUND / GAMBAR SEKOLAH --}}
        <div class="auth-image-side">
            <div class="auth-image-content">
                <a href="{{ route('login') }}" class="brand-logo">
                    <span class="logo-mark"><i class="bi bi-megaphone-fill"></i></span>
                    LaporAja
                </a>
                
                <div class="image-text">
                    <h2>Laporkan Kerusakan<br>Sekolah dengan Mudah.</h2>
                    <p>Bersama-sama jaga fasilitas sekolah. Sampaikan keluhan sarana dan prasarana secara cepat, transparan, dan terpantau.</p>
                </div>

                <div style="font-size: 0.85rem; opacity: 0.7;">
                    &copy; {{ date('Y') }} LaporAja — SMK Negeri 5 Surakarta
                </div>
            </div>
        </div>

        {{-- FORM LOGIN (Kanan di Desktop, Melayang di Mobile) --}}
        <div class="auth-form-side">
            <div class="auth-form-container">
                
                {{-- LOGO KHUSUS TAMPILAN MOBILE --}}
                <div class="mobile-brand-logo">
                    <span class="logo-mark"><i class="bi bi-megaphone-fill"></i></span>
                    LaporAja
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>