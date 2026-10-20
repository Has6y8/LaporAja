<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>@yield('title') — LaporAja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/medium-zoom@1.0.8/dist/medium-zoom.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #059669;
            --bs-primary-rgb: 5, 150, 105;
            --sidebar-w: 260px;
            --sidebar-bg: #064e3b;
            --bottom-nav-h: 64px;
        }
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background: #f1f5f9; overflow-x: hidden; padding-bottom: 0; }

        .btn-primary {
            --bs-btn-bg: #059669;
            --bs-btn-border-color: #059669;
            --bs-btn-hover-bg: #047857;
            --bs-btn-hover-border-color: #047857;
            --bs-btn-active-bg: #047857;
            --bs-btn-active-border-color: #047857;
            --bs-btn-focus-shadow-rgb: 5, 150, 105;
        }

        .form-control:focus, .form-select:focus {
            border-color: #059669;
            box-shadow: 0 0 0 .2rem rgba(5,150,105,.15);
        }

        /* ============================================
           SIDEBAR (DESKTOP)
           ============================================ */
        .app-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            color: #fff;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: transform .3s ease, filter .3s ease;
        }

        body.cam-active .app-sidebar {
            filter: brightness(0.35);
            pointer-events: none;
        }
        body.cam-active .bottom-nav {
            filter: brightness(0.35);
            pointer-events: none;
        }
        body.cam-active .mobile-header {
            filter: brightness(0.35);
            pointer-events: none;
        }

        .sidebar-inner {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: .65rem;
            font-weight: 700; font-size: 1.15rem;
            color: #fff; padding: .5rem; margin-bottom: 1.25rem;
            text-decoration: none;
        }
        .sidebar-brand:hover { color: #fff; }

        .sidebar-user {
            background: rgba(255,255,255,.08);
            border-radius: 12px;
            padding: .85rem;
            display: flex; align-items: center; gap: .7rem;
            margin-bottom: 1.25rem;
        }
        .user-avatar {
            width: 40px; height: 40px; background: #059669;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 600; font-size: .9rem; flex-shrink: 0;
        }
        .user-info { overflow: hidden; }
        .user-info .name {
            font-size: .85rem; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-info .role {
            font-size: .68rem; color: #6ee7b7;
            letter-spacing: .5px; font-weight: 600; text-transform: uppercase;
        }

        .menu-label {
            color: #6ee7b7; font-size: .7rem;
            text-transform: uppercase; letter-spacing: 1px;
            font-weight: 600; padding: .75rem .85rem .35rem;
        }
        .sidebar-menu {
            flex: 1; display: flex; flex-direction: column;
            gap: .25rem; list-style: none; padding: 0; margin: 0;
        }
        .menu-item {
            display: flex; align-items: center; gap: .7rem;
            padding: .65rem .85rem; border-radius: 8px;
            color: #a7f3d0; text-decoration: none;
            font-size: .9rem; font-weight: 500; transition: all .15s;
        }
        .menu-item:hover { background: rgba(255,255,255,.1); color: #fff; }
        .menu-item.active { background: #059669; color: #fff; }

        .sidebar-logout {
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,.1);
            margin-top: 1rem;
        }
        .logout-btn {
            display: flex; align-items: center; gap: .7rem;
            padding: .6rem .85rem; border: none; background: transparent;
            color: #fca5a5; border-radius: 8px; font-size: .9rem;
            font-weight: 500; width: 100%; text-align: left;
            cursor: pointer; transition: all .15s;
        }
        .logout-btn:hover { background: rgba(239,68,68,.1); }

        /* ============================================
           MAIN CONTENT
           ============================================ */
        .app-main {
            margin-left: var(--sidebar-w);
            padding: 1.5rem;
            min-height: 100vh;
        }

        /* ============================================
           MOBILE HEADER + BOTTOM NAV
           ============================================ */
        .mobile-header {
            display: none;
            background: var(--sidebar-bg);
            padding: .8rem 1rem;
            position: sticky; top: 0;
            z-index: 999998;
            color: #fff;
            align-items: center;
            justify-content: space-between;
        }
        .mobile-brand {
            font-weight: 700; display: flex;
            align-items: center; gap: .5rem;
            color: #fff; text-decoration: none;
        }
        .mobile-brand:hover { color: #fff; }

        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: var(--bottom-nav-h);
            background: #fff;
            border-top: 1px solid #e2e8f0;
            z-index: 999997;
            padding-bottom: env(safe-area-inset-bottom);
            box-shadow: 0 -4px 20px rgba(0,0,0,.05);
        }
        .bottom-nav-inner {
            display: flex; height: var(--bottom-nav-h);
            align-items: stretch;
            max-width: 640px;
            margin: 0 auto;
        }
        .bottom-nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
            color: #64748b;
            text-decoration: none;
            font-size: .68rem;
            font-weight: 500;
            padding: .4rem .25rem;
            transition: color .15s;
            position: relative;
        }
        .bottom-nav-item i {
            font-size: 1.35rem;
            line-height: 1;
        }
        .bottom-nav-item.active {
            color: #059669;
        }
        .bottom-nav-item.active::before {
            content: '';
            position: absolute;
            top: 0; left: 50%;
            transform: translateX(-50%);
            width: 32px; height: 3px;
            background: #059669;
            border-radius: 0 0 4px 4px;
        }
        .bottom-nav-item .nav-badge {
            position: absolute;
            top: 6px; right: calc(50% - 22px);
            background: #ef4444;
            color: #fff;
            font-size: .58rem;
            padding: 1px 5px;
            border-radius: 999px;
            font-weight: 700;
            min-width: 16px;
            text-align: center;
        }
        .bottom-nav-item.center-btn {
            position: relative;
        }
        .bottom-nav-item.center-btn i {
            background: #059669;
            color: #fff;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 6px 16px rgba(5,150,105,.4);
            margin-top: -20px;
            border: 3px solid #fff;
        }
        .bottom-nav-item.center-btn span {
            margin-top: 2px;
            color: #059669;
            font-weight: 600;
        }

        /* ============================================
           MOBILE RESPONSIVE
           ============================================ */
        @media (max-width: 991px) {
            .app-sidebar { display: none; }
            .app-main {
                margin-left: 0;
                padding: 1rem;
                padding-bottom: calc(var(--bottom-nav-h) + 1rem);
            }
            .mobile-header { display: flex; }
            .bottom-nav { display: block; }

            /* Cards lebih compact di mobile */
            .card-body { padding: 1rem !important; }

            /* Judul menyesuaikan */
            h4, .h4 { font-size: 1.15rem; }
            h5, .h5 { font-size: 1rem; }

            /* Table jadi stacked */
            .mobile-friendly-table thead { display: none; }
            .mobile-friendly-table tr {
                display: block;
                border-bottom: 1px solid #f1f5f9;
                padding: .75rem 0;
            }
            .mobile-friendly-table td {
                display: flex;
                justify-content: space-between;
                padding: .25rem 0;
                border: none;
            }
            .mobile-friendly-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #64748b;
                font-size: .78rem;
            }
        }

        /* ============================================
           CARD & KOMPONEN
           ============================================ */
        .stat-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            transition: all .2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,.06);
        }
        .stat-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
        }

        .laporan-item {
            display: flex; gap: 1rem;
            padding: 1.15rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            text-decoration: none; color: inherit;
            transition: background .15s;
            align-items: flex-start;
        }
        .laporan-item:last-child { border-bottom: none; }
        .laporan-item:hover { background: #f8fafc; }
        .laporan-thumb {
            width: 70px; height: 70px;
            border-radius: 10px; object-fit: cover; flex-shrink: 0;
            background: #f1f5f9;
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8; font-size: 1.5rem;
        }
        @media (max-width: 575px) {
            .laporan-thumb { width: 56px; height: 56px; font-size: 1.2rem; }
            .laporan-item { padding: .9rem 1rem; gap: .75rem; }
        }

        .status-badge {
            padding: .3rem .75rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .status-pending  { background: #fef3c7; color: #92400e; }
        .status-diproses { background: #dbeafe; color: #1e40af; }
        .status-selesai  { background: #d1fae5; color: #065f46; }
        .status-ditolak  { background: #fee2e2; color: #991b1b; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }

        .zoomable { cursor: zoom-in; transition: transform .2s; }
        .zoomable:hover { transform: scale(1.01); }

        /* ============================================
           CAMERA OVERLAY
           ============================================ */
        .laporaja-cam-overlay {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            z-index: 1050;
            background: rgba(0,0,0,.85);
            align-items: center; justify-content: center;
            padding: 1rem;
            overflow-y: auto;
        }
        .laporaja-cam-overlay.active { display: flex; }
        .laporaja-cam-dialog {
            background: #fff; border-radius: 16px;
            max-width: 720px; width: 100%;
            overflow: hidden;
            display: flex; flex-direction: column;
            max-height: calc(100vh - 2rem);
            box-shadow: 0 20px 60px rgba(0,0,0,.5);
        }
        .laporaja-cam-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e2e8f0; flex-shrink: 0;
        }
        .laporaja-cam-close {
            background: transparent; border: none; font-size: 1.75rem;
            line-height: 1; cursor: pointer; color: #64748b;
            padding: 0; width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .laporaja-cam-close:hover { background: #f1f5f9; color: #0f172a; }
        .laporaja-cam-body {
            background: #000; position: relative;
            flex: 1; min-height: 0;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .laporaja-cam-body video {
            width: 100%; max-height: 60vh;
            display: block; object-fit: contain;
        }
        .laporaja-cam-error {
            display: none; position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            color: #fff; padding: 2rem;
            text-align: center; flex-direction: column;
            align-items: center; justify-content: center;
        }
        .laporaja-cam-error.show { display: flex; }
        .laporaja-cam-error i { font-size: 3.5rem; opacity: .6; }
        .laporaja-cam-error p { margin: 1rem 0 .5rem; font-size: .9rem; max-width: 400px; }
        .laporaja-cam-error small { font-size: .78rem; opacity: .7; }
        .laporaja-cam-footer {
            display: flex; justify-content: space-between; align-items: center;
            gap: .75rem; padding: 1rem 1.25rem;
            border-top: 1px solid #e2e8f0; background: #f8fafc; flex-shrink: 0;
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- MOBILE HEADER --}}
<div class="mobile-header">
    <a href="{{ route('dashboard') }}" class="mobile-brand">
        <i class="bi bi-megaphone-fill"></i> LaporAja
    </a>
    
    {{-- TOMBOL PROFIL DI MOBILE --}}
    <a href="{{ route('profile.index') }}" class="d-flex align-items-center gap-2 text-decoration-none text-white">
        <span class="small opacity-75">{{ auth()->user()->name }}</span>
        <i class="bi bi-person-circle fs-5"></i>
    </a>
</div>

{{-- SIDEBAR (DESKTOP) --}}
<aside class="app-sidebar">
    <div class="sidebar-inner">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="bi bi-megaphone-fill"></i> LaporAja
        </a>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="role">{{ auth()->user()->roleLabel() }}</div>
            </div>
        </div>

        @include('layouts.sidebar-menu')

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<main class="app-main">
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

{{-- BOTTOM NAV (MOBILE) --}}
@php $user = auth()->user(); @endphp
<nav class="bottom-nav">
    <div class="bottom-nav-inner">

        <a href="{{ route('dashboard') }}"
           class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i>
            <span>Home</span>
        </a>

        @if($user->isUser())
            <a href="{{ route('laporan.create') }}"
               class="bottom-nav-item center-btn {{ request()->routeIs('laporan.create') ? 'active' : '' }}">
                <i class="bi bi-plus-lg"></i>
                <span>Lapor</span>
            </a>
            <a href="{{ route('komplain.index') }}"
               class="bottom-nav-item {{ request()->routeIs('komplain.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i>
                <span>Komplain</span>
            </a>
        @elseif($user->isStaff())
            <a href="{{ route('staff.laporan') }}"
               class="bottom-nav-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i>
                <span>Tugas</span>
            </a>
        @else
            @php $pendingVerif = \App\Models\Laporan::where('moderation_status','pending')->count(); @endphp
            <a href="{{ route('admin.verifikasi') }}"
               class="bottom-nav-item {{ request()->routeIs('admin.verifikasi') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i>
                <span>Verifikasi</span>
                @if($pendingVerif > 0)
                    <span class="nav-badge">{{ $pendingVerif }}</span>
                @endif
            </a>
            @php $pendingKomplain = \App\Models\Komplain::where('status','pending')->count(); @endphp
            <a href="{{ route('admin.komplain') }}"
               class="bottom-nav-item {{ request()->routeIs('admin.komplain') ? 'active' : '' }}">
                <i class="bi bi-chat-square-text-fill"></i>
                <span>Komplain</span>
                @if($pendingKomplain > 0)
                    <span class="nav-badge">{{ $pendingKomplain }}</span>
                @endif
            </a>
        @endif

        <a href="{{ route('histori') }}"
           class="bottom-nav-item {{ request()->routeIs('histori') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Histori</span>
        </a>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/medium-zoom@1.0.8/dist/medium-zoom.min.js"></script>
<script>
    if (typeof mediumZoom === 'function') {
        mediumZoom('.zoomable', { background: 'rgba(0,0,0,.85)' });
    }

    window.LaporAjaStreams = {};
    window.LaporAja_updateBodyState = function () {
        const hasActive = document.querySelector('.laporaja-cam-overlay.active');
        document.body.classList.toggle('cam-active', !!hasActive);
    };

    window.LaporAja_openCamera = function (name) {
        const overlay = document.getElementById('cam_overlay_' + name);
        const video   = document.getElementById('cam_video_' + name);
        const errorEl = document.getElementById('cam_error_' + name);
        const errMsg  = document.getElementById('cam_error_msg_' + name);
        const btnCap  = document.getElementById('cam_capture_' + name);
        if (!overlay) return;

        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        window.LaporAja_updateBodyState();

        errorEl.classList.remove('show');
        btnCap.disabled = false;
        video.srcObject = null;

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            errorEl.classList.add('show');
            errMsg.textContent = 'Browser tidak mendukung akses kamera.';
            btnCap.disabled = true;
            return;
        }

        navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } },
            audio: false
        })
        .then(function (stream) {
            window.LaporAjaStreams[name] = stream;
            video.srcObject = stream;
            video.play().catch(function () {});
        })
        .catch(function (err) {
            let msg = 'Tidak bisa akses kamera.';
            if (err.name === 'NotAllowedError') msg = 'Izin kamera ditolak. Aktifkan izin kamera.';
            else if (err.name === 'NotFoundError') msg = 'Kamera tidak ditemukan.';
            else if (err.name === 'NotReadableError') msg = 'Kamera sedang dipakai aplikasi lain.';
            errorEl.classList.add('show');
            errMsg.textContent = msg;
            btnCap.disabled = true;
        });
    };

    window.LaporAja_closeCamera = function (name) {
        const overlay = document.getElementById('cam_overlay_' + name);
        const video   = document.getElementById('cam_video_' + name);
        if (window.LaporAjaStreams[name]) {
            window.LaporAjaStreams[name].getTracks().forEach(t => t.stop());
            delete window.LaporAjaStreams[name];
        }
        if (video) video.srcObject = null;
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
        window.LaporAja_updateBodyState();
    };

    window.LaporAja_capture = function (name) {
        const video  = document.getElementById('cam_video_' + name);
        const canvas = document.getElementById('cam_canvas_' + name);
        const input  = document.getElementById('input_' + name);
        const prevEl = document.getElementById('preview_' + name);
        const prevWr = document.getElementById('preview_wrap_' + name);
        if (!video.videoWidth) { alert('Kamera belum siap.'); return; }

        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);

        canvas.toBlob(function (blob) {
            if (!blob) return;
            const file = new File([blob], 'foto_' + Date.now() + '.jpg', { type: 'image/jpeg' });
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            prevEl.src = URL.createObjectURL(blob);
            prevWr.style.display = 'block';
            setTimeout(() => { if (typeof mediumZoom === 'function') mediumZoom('.zoomable'); }, 100);
            window.LaporAja_closeCamera(name);
        }, 'image/jpeg', 0.9);
    };

    window.LaporAja_previewFile = function (event, previewId, previewWrapId) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById(previewId).src = e.target.result;
            document.getElementById(previewWrapId).style.display = 'block';
            setTimeout(() => { if (typeof mediumZoom === 'function') mediumZoom('.zoomable'); }, 100);
        };
        reader.readAsDataURL(file);
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.laporaja-cam-overlay.active').forEach(function (el) {
                const name = el.id.replace('cam_overlay_', '');
                window.LaporAja_closeCamera(name);
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>