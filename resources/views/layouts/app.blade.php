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
            --c-soft-2: #d1fae5;
            --c-ink: #0f172a;
            --c-ink-2: #334155;
            --c-muted: #64748b;
            --c-muted-2: #94a3b8;
            --c-border: #e2e8f0;
            --c-bg: #f8fafc;
            
            --c-danger: #ef4444;
            --c-warning: #f59e0b;
            --c-info: #3b82f6;
            
            --r-sm: 12px;
            --r-md: 16px;
            --r-lg: 24px;
            --r-full: 999px;
            
            --sh-sm: 0 1px 3px rgba(15,23,42,.05);
            --sh-md: 0 4px 20px -2px rgba(15,23,42,.08);
            --sh-lg: 0 12px 30px -4px rgba(15,23,42,.1);
            --tr: 200ms cubic-bezier(.4,0,.2,1);
            
            --sidebar-w: 280px;
            --bottom-nav-h: 72px;
        }

        * { font-family: 'Inter', -apple-system, system-ui, sans-serif; -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; }
        body {
            background-color: #f4f6f8;
            background-image: radial-gradient(#d1d5db 1px, transparent 1px);
            background-size: 20px 20px;
            color: var(--c-ink);
            font-size: .9375rem;
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ========== BUTTONS ========== */
        .btn { border-radius: var(--r-sm); font-weight: 600; transition: all var(--tr); min-height: 44px; padding: .6rem 1.25rem; display: inline-flex; align-items: center; justify-content: center; gap: .5rem; }
        .btn:active { transform: scale(.97); }
        .btn-primary { --bs-btn-bg: var(--c-primary); --bs-btn-border-color: var(--c-primary); --bs-btn-hover-bg: var(--c-primary-dark); --bs-btn-hover-border-color: var(--c-primary-dark); box-shadow: 0 4px 12px rgba(5,150,105,.2); }
        .btn-primary:hover { box-shadow: 0 6px 16px rgba(5,150,105,.3); transform: translateY(-1px); }
        .btn-light { background: #fff; border: 1px solid var(--c-border); color: var(--c-ink-2); box-shadow: var(--sh-sm); }
        .btn-light:hover { background: var(--c-bg); border-color: #cbd5e1; transform: translateY(-1px); }
        .btn-sm { min-height: 36px; padding: .35rem .85rem; font-size: .8125rem; border-radius: 8px; }

        /* ========== FORMS ========== */
        .form-control, .form-select {
            border-radius: var(--r-sm);
            border: 1px solid var(--c-border);
            padding: .65rem 1rem;
            font-size: .9375rem;
            transition: all var(--tr);
            min-height: 46px;
            background-color: #fff;
            color: var(--c-ink);
            box-shadow: inset 0 1px 2px rgba(0,0,0,.02);
        }
        .form-control::placeholder { color: var(--c-muted-2); }
        .form-control:focus, .form-select:focus { border-color: var(--c-primary-light); box-shadow: 0 0 0 4px rgba(16,185,129,.15); background-color: #fff; }
        .form-label { font-size: .8125rem; font-weight: 600; color: var(--c-ink-2); margin-bottom: .5rem; }
        .form-text { font-size: .75rem; color: var(--c-muted); }
        textarea.form-control { min-height: 100px; resize: vertical; }

        .input-group-text {
            background-color: #f8fafc; border: 1px solid var(--c-border); border-right: none;
            border-radius: var(--r-sm) 0 0 var(--r-sm); color: var(--c-muted); padding: 0 1rem;
        }
        .input-group .form-control { border-left: none; border-radius: 0 var(--r-sm) var(--r-sm) 0; }
        .input-group:focus-within .input-group-text { border-color: var(--c-primary-light); background-color: #fff; }

        /* ========== CARDS & LAYOUT ========== */
        .card {
            border: 1px solid var(--c-border);
            border-radius: var(--r-lg);
            background: #fff;
            box-shadow: var(--sh-md);
            transition: all var(--tr);
            overflow: hidden;
        }
        .card:hover { box-shadow: var(--sh-lg); border-color: #cbd5e1; }
        .card-body { padding: 1.5rem; }
        .card-header { background: #fff !important; border-bottom: 1px solid var(--c-border); padding: 1.25rem 1.5rem; border-radius: var(--r-lg) var(--r-lg) 0 0 !important; }

        /* ========== BADGES & STATUS ========== */
        .badge { font-weight: 600; font-size: .72rem; padding: .35rem .7rem; border-radius: var(--r-full); letter-spacing: .01em; }
        .status-badge { display: inline-flex; align-items: center; gap: .4rem; padding: .35rem .85rem; border-radius: var(--r-full); font-size: .75rem; font-weight: 700; letter-spacing: .02em; white-space: nowrap; }
        .status-pending  { background: #fef3c7; color: #b45309; }
        .status-diproses { background: #dbeafe; color: #1d4ed8; }
        .status-selesai  { background: #d1fae5; color: #047857; }
        .status-ditolak  { background: #fee2e2; color: #b91c1c; }

        /* ========== ALERTS (Untuk halaman yang pakai alert-soft) ========== */
        .alert-soft { padding: .85rem 1rem; border-radius: var(--r-sm); font-size: .8125rem; display: flex; align-items: flex-start; gap: .55rem; margin-bottom: 1.25rem; }
        .alert-soft.alert-success { background: var(--c-soft); color: #065f46; border-left: 3px solid var(--c-primary); }
        .alert-soft.alert-danger  { background: #fef2f2; color: #991b1b; border-left: 3px solid #dc2626; }
        .alert-soft.alert-info    { background: #eff6ff; color: #1e40af; border-left: 3px solid #2563eb; }

        /* ========== SIDEBAR ========== */
        .app-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-w);
            background: #064e3b; color: #fff; z-index: 999999;
            display: flex; flex-direction: column; overflow-y: auto;
            border-right: 1px solid rgba(255,255,255,.05); transition: transform 300ms cubic-bezier(.4,0,.2,1);
        }
        .sidebar-inner { padding: 1.5rem; display: flex; flex-direction: column; min-height: 100%; }
        .sidebar-brand { display: flex; align-items: center; gap: .75rem; font-weight: 800; font-size: 1.35rem; color: #fff; padding: .5rem .5rem 1.5rem; text-decoration: none; letter-spacing: -.03em; }
        .sidebar-brand .brand-icon { width: 42px; height: 42px; background: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; box-shadow: 0 8px 20px rgba(16,185,129,.4); }

        .sidebar-user { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.1); border-radius: var(--r-md); padding: 1rem; display: flex; align-items: center; gap: .85rem; margin-bottom: 2rem; }
        .user-avatar { width: 46px; height: 46px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.1rem; flex-shrink: 0; }
        .user-info { overflow: hidden; min-width: 0; }
        .user-info .name { font-size: .9rem; font-weight: 700; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-info .role { font-size: .7rem; color: #6ee7b7; letter-spacing: .08em; font-weight: 800; text-transform: uppercase; }

        .menu-label { color: #6ee7b7; font-size: .7rem; text-transform: uppercase; letter-spacing: .1em; font-weight: 800; padding: 1rem .85rem .5rem; }
        .sidebar-menu { flex: 1; display: flex; flex-direction: column; gap: .2rem; list-style: none; padding: 0; margin: 0; }
        .menu-item { display: flex; align-items: center; gap: .85rem; padding: .75rem 1rem; border-radius: var(--r-sm); color: #a7f3d0; text-decoration: none; font-size: .9rem; font-weight: 600; transition: all var(--tr); }
        .menu-item:hover { background: rgba(255,255,255,.1); color: #fff; }
        .menu-item.active { background: #10b981; color: #fff; box-shadow: 0 4px 12px rgba(16,185,129,.3); }
        .menu-item i { font-size: 1.15rem; width: 24px; text-align: center; }

        .sidebar-logout { padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,.1); margin-top: auto; }
        .logout-btn { display: flex; align-items: center; gap: .85rem; padding: .75rem 1rem; border: none; background: transparent; color: #fca5a5; border-radius: var(--r-sm); font-size: .9rem; font-weight: 600; width: 100%; text-align: left; cursor: pointer; transition: all var(--tr); }
        .logout-btn:hover { background: rgba(239,68,68,.15); color: #fecaca; }

        /* ========== MAIN ========== */
        .app-main { margin-left: var(--sidebar-w); padding: 2.5rem; min-height: 100vh; }
        .content-wrap { max-width: 1100px; margin: 0 auto; }

        /* ========== MOBILE HEADER & BOTTOM NAV ========== */
        .mobile-header { display: none; background: rgba(255,255,255,.95); backdrop-filter: blur(10px); padding: .85rem 1.25rem; position: sticky; top: 0; z-index: 900; border-bottom: 1px solid var(--c-border); align-items: center; justify-content: space-between; }
        .mobile-brand { font-weight: 800; font-size: 1.15rem; color: var(--c-deep); text-decoration: none; display: flex; align-items: center; gap: .5rem; letter-spacing: -.02em; }
        .mobile-brand .brand-icon-sm { width: 34px; height: 34px; background: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1rem; }
        
        .bottom-nav { display: none; position: fixed; bottom: 0; left: 0; right: 0; height: var(--bottom-nav-h); background: rgba(255,255,255,.98); backdrop-filter: blur(10px); border-top: 1px solid var(--c-border); z-index: 900; padding-bottom: env(safe-area-inset-bottom); box-shadow: 0 -4px 20px rgba(15,23,42,.05); }
        .bottom-nav-inner { display: flex; height: var(--bottom-nav-h); align-items: stretch; max-width: 640px; margin: 0 auto; }
        .bottom-nav-item { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; color: var(--c-muted); text-decoration: none; font-size: .7rem; font-weight: 700; transition: color var(--tr); position: relative; }
        .bottom-nav-item i { font-size: 1.35rem; line-height: 1; }
        .bottom-nav-item.active { color: var(--c-primary); }
        .bottom-nav-item.center-btn i { background: #10b981; color: #fff; width: 54px; height: 54px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 8px 20px rgba(16,185,129,.4); margin-top: -24px; border: 4px solid #fff; }

        /* ========== PAGE HEADER ========== */
        .page-header { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 2rem; }
        .page-header h4 { font-weight: 800; font-size: 1.75rem; margin: 0 0 .35rem; letter-spacing: -.04em; color: var(--c-deep); }
        .page-header p { margin: 0; color: var(--c-muted); font-size: .95rem; }

        /* ========== LIST LAPORAN (Untuk Histori & Staff) ========== */
        .laporan-item { display: flex; gap: 1.25rem; padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--c-border); text-decoration: none; color: inherit; transition: background var(--tr); align-items: center; }
        .laporan-item:last-child { border-bottom: none; }
        .laporan-item:hover { background: var(--c-soft); color: inherit; }
        .laporan-thumb { width: 72px; height: 72px; border-radius: var(--r-sm); object-fit: cover; flex-shrink: 0; background: var(--c-bg); display: flex; align-items: center; justify-content: center; color: var(--c-muted-2); font-size: 1.5rem; overflow: hidden; border: 1px solid var(--c-border); }
        .laporan-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .laporan-title { font-weight: 600; font-size: .95rem; margin-bottom: .35rem; color: var(--c-ink); }
        .laporan-meta { font-size: .78rem; color: var(--c-muted); display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: .5rem; }
        .laporan-meta i { font-size: .78rem; margin-right: .3rem; }

        /* ========== STAT CARD (Untuk Dashboard Admin/Lama) ========== */
        .stat-card { border: 1px solid var(--c-border); border-radius: var(--r-md); transition: all var(--tr); background: #fff; height: 100%; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--sh-md); border-color: var(--c-soft-2); }
        .stat-card .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .stat-card .stat-value { font-size: 1.5rem; font-weight: 800; line-height: 1; letter-spacing: -.03em; }
        .stat-card .stat-label { font-size: .78rem; color: var(--c-muted); margin-top: .3rem; font-weight: 500; }

        /* ========== EMPTY STATE (Untuk Histori, Komplain, Approvals) ========== */
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--c-muted); }
        .empty-state .empty-icon { width: 72px; height: 72px; background: var(--c-soft); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--c-primary); margin-bottom: 1rem; }
        .empty-state .empty-title { font-weight: 600; color: var(--c-ink-2); margin-bottom: .35rem; font-size: .95rem; }
        .empty-state .empty-desc { font-size: .8rem; max-width: 320px; margin: 0 auto; }

        /* ========== TOASTS & MODAL ========== */
        .toast-wrap { position: fixed; top: 1.5rem; right: 1.5rem; z-index: 9999999; display: flex; flex-direction: column; gap: .75rem; max-width: 380px; width: calc(100% - 3rem); }
        .toast-item { background: #fff; border: 1px solid var(--c-border); border-left: 4px solid var(--c-primary); border-radius: var(--r-sm); padding: 1rem 1.25rem; box-shadow: var(--sh-lg); display: flex; align-items: flex-start; gap: .75rem; font-size: .9rem; color: var(--c-ink-2); animation: toastIn 300ms cubic-bezier(.4,0,.2,1); }
        .toast-item.is-danger { border-left-color: var(--c-danger); }
        .toast-item.is-warning { border-left-color: var(--c-warning); }
        .toast-item.is-info { border-left-color: var(--c-info); }
        .toast-icon { font-size: 1.2rem; flex-shrink: 0; color: var(--c-primary); }
        .toast-item.is-danger .toast-icon { color: var(--c-danger); }
        .toast-close { margin-left: auto; background: none; border: none; color: var(--c-muted-2); cursor: pointer; padding: 0; font-size: 1.1rem; line-height: 1; }
        @keyframes toastIn { from { opacity: 0; transform: translateY(-10px) scale(.95); } to { opacity: 1; transform: translateY(0) scale(1); } }

        .modal-content { border: none; border-radius: var(--r-lg); box-shadow: 0 24px 60px rgba(15,23,42,.15); }
        .modal-header { border-bottom: 1px solid var(--c-border); padding: 1.25rem 1.5rem; }
        .modal-title { font-weight: 700; font-size: 1.1rem; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { border-top: 1px solid var(--c-border); padding: 1.25rem 1.5rem; gap: .75rem; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991px) {
            .app-sidebar { transform: translateX(-100%); }
            body.drawer-open .app-sidebar { transform: translateX(0); }
            .app-main { margin-left: 0; padding: 1.25rem; padding-bottom: calc(var(--bottom-nav-h) + 2rem); }
            .mobile-header { display: flex; }
            .bottom-nav { display: block; }
            .page-header h4 { font-size: 1.5rem; }
            .card-body { padding: 1.25rem; }
            .laporan-item { padding: 1rem 1.25rem; gap: 1rem; }
        }

        /* CAMERA OVERLAY */
        .laporaja-cam-overlay { display: none; position: fixed; inset: 0; z-index: 1050; background: rgba(0,0,0,.9); align-items: center; justify-content: center; padding: 1rem; overflow-y: auto; }
        .laporaja-cam-overlay.active { display: flex; }
        .laporaja-cam-dialog { background: #fff; border-radius: var(--r-lg); max-width: 720px; width: 100%; overflow: hidden; display: flex; flex-direction: column; max-height: calc(100vh - 2rem); }
        .laporaja-cam-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; border-bottom: 1px solid var(--c-border); flex-shrink: 0; }
        .laporaja-cam-close { background: transparent; border: none; font-size: 1.75rem; line-height: 1; cursor: pointer; color: var(--c-muted); padding: 0; width: 32px; height: 32px; border-radius: var(--r-sm); display: flex; align-items: center; justify-content: center; }
        .laporaja-cam-body { background: #000; position: relative; flex: 1; min-height: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .laporaja-cam-body video { width: 100%; max-height: 60vh; display: block; object-fit: contain; }
        .laporaja-cam-error { display: none; position: absolute; inset: 0; color: #fff; padding: 2rem; text-align: center; flex-direction: column; align-items: center; justify-content: center; }
        .laporaja-cam-error.show { display: flex; }
        .laporaja-cam-error i { font-size: 3.5rem; opacity: .6; }
        .laporaja-cam-error p { margin: 1rem 0 .5rem; font-size: .9rem; max-width: 400px; }
        .laporaja-cam-error small { font-size: .78rem; opacity: .7; }
        .laporaja-cam-footer { display: flex; justify-content: space-between; align-items: center; gap: .75rem; padding: 1rem 1.25rem; border-top: 1px solid var(--c-border); background: var(--c-bg); flex-shrink: 0; }
        .zoomable { cursor: zoom-in; transition: transform var(--tr); }
        .zoomable:hover { transform: scale(1.02); }
    </style>
</head>
<body>

{{-- DRAWER BACKDROP --}}
<div class="drawer-backdrop" onclick="toggleDrawer()" style="position: fixed; inset: 0; background: rgba(15,23,42,.6); opacity: 0; pointer-events: none; transition: opacity var(--tr); z-index: 999998; backdrop-filter: blur(4px);"></div>

{{-- MOBILE HEADER --}}
<div class="mobile-header">
    <button class="icon-btn" onclick="toggleDrawer()" style="background:transparent;border:none;font-size:1.5rem;color:var(--c-ink-2);">
        <i class="bi bi-list"></i>
    </button>
    <a href="{{ route('dashboard') }}" class="mobile-brand">
        <span class="brand-icon-sm"><i class="bi bi-megaphone-fill"></i></span>
        LaporAja
    </a>
    <a href="{{ route('profile.index') }}" style="color:var(--c-ink-2);font-size:1.3rem;">
        <i class="bi bi-person-circle"></i>
    </a>
</div>

{{-- SIDEBAR --}}
<aside class="app-sidebar">
    <div class="sidebar-inner">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <span class="brand-icon"><i class="bi bi-megaphone-fill"></i></span>
            LaporAja
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

{{-- MAIN --}}
<main class="app-main">
    <div class="content-wrap">
        @yield('content')
    </div>
</main>

{{-- BOTTOM NAV --}}
@php $user = auth()->user(); @endphp
<nav class="bottom-nav">
    <div class="bottom-nav-inner">
        <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i>
            <span>Home</span>
        </a>

        @if($user->isUser())
            <a href="{{ route('laporan.create') }}" class="bottom-nav-item center-btn {{ request()->routeIs('laporan.create') ? 'active' : '' }}">
                <i class="bi bi-plus-lg"></i>
                <span style="margin-top:4px;color:var(--c-primary);font-weight:800;">Lapor</span>
            </a>
            <a href="{{ route('komplain.index') }}" class="bottom-nav-item {{ request()->routeIs('komplain.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i>
                <span>Komplain</span>
            </a>
        @elseif($user->isStaff())
            <a href="{{ route('staff.laporan') }}" class="bottom-nav-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i>
                <span>Tugas</span>
            </a>
        @else
            <a href="{{ route('admin.komplain') }}" class="bottom-nav-item {{ request()->routeIs('admin.komplain') ? 'active' : '' }}">
                <i class="bi bi-chat-square-text-fill"></i>
                <span>Komplain</span>
            </a>
            @if($user->isAdmin())
                <a href="{{ route('admin.users') }}" class="bottom-nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Users</span>
                </a>
            @endif
        @endif

        <a href="{{ route('profile.index') }}" class="bottom-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i>
            <span>Profil</span>
        </a>
    </div>
</nav>

{{-- TOAST WRAP --}}
<div class="toast-wrap" id="toastWrap"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleDrawer() { 
        document.body.classList.toggle('drawer-open'); 
        const backdrop = document.querySelector('.drawer-backdrop');
        if(document.body.classList.contains('drawer-open')) {
            backdrop.style.opacity = '1'; backdrop.style.pointerEvents = 'auto';
        } else {
            backdrop.style.opacity = '0'; backdrop.style.pointerEvents = 'none';
        }
    }

    function showToast(message, type) {
        type = type || 'success';
        const wrap = document.getElementById('toastWrap');
        if (!wrap) return;
        const icons = { success: 'check-circle-fill', danger: 'x-circle-fill', error: 'x-circle-fill', warning: 'exclamation-triangle-fill', info: 'info-circle-fill' };
        const cls = (type === 'error') ? 'danger' : type;
        const el = document.createElement('div');
        el.className = 'toast-item is-' + cls;
        el.innerHTML = `<i class="bi bi-${icons[type] || 'check-circle-fill'} toast-icon"></i>
                        <div style="flex:1;">${message}</div>
                        <button class="toast-close" aria-label="Close">&times;</button>`;
        wrap.appendChild(el);
        const close = () => { el.style.opacity = '0'; el.style.transform = 'translateY(-10px)'; setTimeout(() => el.remove(), 200); };
        el.querySelector('.toast-close').addEventListener('click', close);
        setTimeout(close, 5000);
    }

    @if(session('success')) showToast(@json(session('success')), 'success'); @endif
    @if(session('error'))   showToast(@json(session('error')), 'danger'); @endif

    /* CAMERA LOGIC */
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
            if (err.name === 'NotAllowedError') msg = 'Izin kamera ditolak.';
            else if (err.name === 'NotFoundError') msg = 'Kamera tidak ditemukan.';
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
        };
        reader.readAsDataURL(file);
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.laporaja-cam-overlay.active').forEach(function (el) {
                const name = el.id.replace('cam_overlay_', '');
                window.LaporAja_closeCamera(name);
            });
            if (document.body.classList.contains('drawer-open')) toggleDrawer();
        }
    });
</script>
@stack('scripts')
</body>
</html>