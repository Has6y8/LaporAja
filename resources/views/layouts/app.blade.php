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
    <link href="https://unpkg.com/medium-zoom@1.0.8/dist/medium-zoom.css" rel="stylesheet">
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
            --c-border-2: #cbd5e1;
            --c-bg: #f8fafc;
            --c-white: #fff;
            --c-danger: #dc2626;
            --c-danger-soft: #fef2f2;
            --c-warning: #d97706;
            --c-warning-soft: #fffbeb;
            --c-info: #2563eb;
            --c-info-soft: #eff6ff;
            --r-xs: 8px;
            --r-sm: 10px;
            --r-md: 14px;
            --r-lg: 20px;
            --r-xl: 28px;
            --r-full: 999px;
            --sh-xs: 0 1px 2px rgba(15,23,42,.04);
            --sh-sm: 0 1px 3px rgba(15,23,42,.06);
            --sh-md: 0 4px 12px rgba(15,23,42,.06);
            --sh-lg: 0 10px 30px rgba(15,23,42,.08);
            --sh-xl: 0 20px 50px rgba(6,78,59,.12);
            --tr: 180ms cubic-bezier(.4,0,.2,1);
            --sidebar-w: 268px;
            --bottom-nav-h: 68px;
        }

        * { font-family: 'Inter', -apple-system, system-ui, sans-serif; -webkit-tap-highlight-color: transparent; }
        html { scroll-behavior: smooth; }
        body {
            background: var(--c-bg);
            color: var(--c-ink);
            font-size: .9375rem;
            line-height: 1.55;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ========== BUTTONS ========== */
        .btn {
            border-radius: var(--r-sm);
            font-weight: 600;
            transition: all var(--tr);
            min-height: 42px;
            padding: .55rem 1rem;
        }
        .btn:active { transform: scale(.98); }
        .btn-primary {
            --bs-btn-bg: var(--c-primary);
            --bs-btn-border-color: var(--c-primary);
            --bs-btn-hover-bg: var(--c-primary-dark);
            --bs-btn-hover-border-color: var(--c-primary-dark);
            --bs-btn-active-bg: var(--c-primary-dark);
            --bs-btn-active-border-color: var(--c-primary-dark);
            box-shadow: 0 4px 12px rgba(5,150,105,.18);
        }
        .btn-primary:hover { box-shadow: 0 6px 16px rgba(5,150,105,.28); }
        .btn-light {
            background: #fff;
            border: 1px solid var(--c-border);
            color: var(--c-ink-2);
        }
        .btn-light:hover { background: var(--c-bg); border-color: var(--c-border-2); color: var(--c-ink); }
        .btn-ghost {
            background: transparent;
            border: 1px solid transparent;
            color: var(--c-ink-2);
        }
        .btn-ghost:hover { background: var(--c-bg); color: var(--c-ink); }
        .btn-sm { min-height: 36px; padding: .35rem .8rem; font-size: .8125rem; }

        /* ========== FORM ========== */
        .form-control, .form-select {
            border-radius: var(--r-sm);
            border: 1px solid var(--c-border);
            padding: .6rem .85rem;
            font-size: .9375rem;
            transition: all var(--tr);
            min-height: 44px;
            background-color: #fff;
            color: var(--c-ink);
        }
        .form-control::placeholder { color: var(--c-muted-2); }
        .form-control:focus, .form-select:focus {
            border-color: var(--c-primary-light);
            box-shadow: 0 0 0 3px rgba(16,185,129,.15);
            background-color: #fff;
        }
        .form-label { font-size: .8125rem; font-weight: 600; color: var(--c-ink-2); margin-bottom: .4rem; }
        .form-text { font-size: .75rem; color: var(--c-muted); }
        textarea.form-control { min-height: 100px; resize: vertical; }

        /* ========== CARD ========== */
        .card {
            border: 1px solid var(--c-border);
            border-radius: var(--r-lg);
            background: #fff;
            box-shadow: var(--sh-sm);
            transition: all var(--tr);
        }
        .card.border-0 { border: 1px solid var(--c-border) !important; }
        .card.hoverable:hover { box-shadow: var(--sh-md); transform: translateY(-2px); }
        .card-body { padding: 1.25rem; }
        .card-header {
            background: #fff !important;
            border-bottom: 1px solid var(--c-border);
            padding: 1rem 1.25rem;
            border-radius: var(--r-lg) var(--r-lg) 0 0 !important;
        }

        /* ========== BADGE / STATUS ========== */
        .badge {
            font-weight: 600;
            font-size: .72rem;
            padding: .35rem .7rem;
            border-radius: var(--r-full);
            letter-spacing: .01em;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .3rem .75rem;
            border-radius: var(--r-full);
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

        /* ========== SIDEBAR (desktop) ========== */
        .app-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: linear-gradient(180deg, #064e3b 0%, #033b2b 100%);
            color: #fff;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: transform 240ms cubic-bezier(.4,0,.2,1);
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.2) transparent;
        }
        .app-sidebar::-webkit-scrollbar { width: 4px; }
        .app-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.2); border-radius: 4px; }

        body.cam-active .app-sidebar,
        body.cam-active .bottom-nav,
        body.cam-active .mobile-header { filter: brightness(.3); pointer-events: none; }
        body.cam-active { overflow: hidden; }

        .sidebar-inner {
            padding: 1.15rem;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            font-weight: 800;
            font-size: 1.15rem;
            color: #fff;
            padding: .4rem .4rem 1.25rem;
            text-decoration: none;
            letter-spacing: -.02em;
        }
        .sidebar-brand:hover { color: #fff; }
        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 6px 18px rgba(16,185,129,.35);
        }

        .sidebar-user {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: var(--r-md);
            padding: .85rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.35rem;
        }
        .user-avatar {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: var(--r-full);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: .9rem;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(16,185,129,.25);
        }
        .user-info { overflow: hidden; min-width: 0; }
        .user-info .name {
            font-size: .85rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-info .role {
            font-size: .65rem;
            color: #6ee7b7;
            letter-spacing: .06em;
            font-weight: 700;
            text-transform: uppercase;
        }

        .menu-label {
            color: #6ee7b7;
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            font-weight: 700;
            padding: .85rem .85rem .35rem;
        }
        .sidebar-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: .15rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .7rem .85rem;
            border-radius: var(--r-sm);
            color: #b8d8cb;
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: all var(--tr);
        }
        .menu-item:hover { background: rgba(255,255,255,.08); color: #fff; }
        .menu-item.active {
            background: linear-gradient(90deg, #059669, #047857);
            color: #fff;
            box-shadow: 0 4px 12px rgba(5,150,105,.3);
        }
        .menu-item i { font-size: 1.05rem; width: 20px; text-align: center; }

        .sidebar-logout {
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,.1);
            margin-top: 1rem;
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .7rem .85rem;
            border: none;
            background: transparent;
            color: #fca5a5;
            border-radius: var(--r-sm);
            font-size: .875rem;
            font-weight: 600;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: all var(--tr);
        }
        .logout-btn:hover { background: rgba(239,68,68,.12); color: #fecaca; }

        /* ========== MAIN ========== */
        .app-main {
            margin-left: var(--sidebar-w);
            padding: 1.5rem;
            min-height: 100vh;
        }
        .content-wrap { max-width: 1200px; margin: 0 auto; }

        /* ========== MOBILE HEADER ========== */
        .mobile-header {
            display: none;
            background: #fff;
            padding: .75rem 1rem;
            position: sticky;
            top: 0;
            z-index: 900;
            border-bottom: 1px solid var(--c-border);
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
        }
        .mobile-brand {
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: .5rem;
            color: var(--c-deep);
            text-decoration: none;
            font-size: 1rem;
            letter-spacing: -.01em;
        }
        .mobile-brand:hover { color: var(--c-deep); }
        .mobile-brand .brand-icon-sm {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: .9rem;
        }
        .icon-btn {
            width: 40px; height: 40px;
            background: var(--c-bg);
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            color: var(--c-ink-2);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all var(--tr);
        }
        .icon-btn:hover { background: var(--c-soft); color: var(--c-primary); border-color: var(--c-soft-2); }

        /* ========== DRAWER BACKDROP ========== */
        .drawer-backdrop {
            position: fixed; inset: 0;
            background: rgba(15,23,42,.5);
            opacity: 0;
            pointer-events: none;
            transition: opacity var(--tr);
            z-index: 999998;
            backdrop-filter: blur(2px);
        }
        body.drawer-open .drawer-backdrop { opacity: 1; pointer-events: auto; }
        body.drawer-open { overflow: hidden; }

        /* ========== BOTTOM NAV (mobile) ========== */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: var(--bottom-nav-h);
            background: rgba(255,255,255,.98);
            backdrop-filter: blur(10px);
            border-top: 1px solid var(--c-border);
            z-index: 900;
            padding-bottom: env(safe-area-inset-bottom);
            box-shadow: 0 -4px 20px rgba(15,23,42,.06);
        }
        .bottom-nav-inner {
            display: flex;
            height: var(--bottom-nav-h);
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
            gap: 3px;
            color: var(--c-muted);
            text-decoration: none;
            font-size: .68rem;
            font-weight: 600;
            padding: .35rem .25rem;
            transition: color var(--tr);
            position: relative;
        }
        .bottom-nav-item i { font-size: 1.3rem; line-height: 1; }
        .bottom-nav-item.active { color: var(--c-primary); }
        .bottom-nav-item.active::before {
            content: '';
            position: absolute;
            top: 0; left: 50%;
            transform: translateX(-50%);
            width: 26px; height: 3px;
            background: var(--c-primary);
            border-radius: 0 0 4px 4px;
        }
        .bottom-nav-item .nav-badge {
            position: absolute;
            top: 6px; right: calc(50% - 22px);
            background: var(--c-danger);
            color: #fff;
            font-size: .58rem;
            padding: 1px 5px;
            border-radius: var(--r-full);
            font-weight: 700;
            min-width: 16px;
            text-align: center;
        }
        .bottom-nav-item.center-btn i {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            box-shadow: 0 8px 20px rgba(5,150,105,.35);
            margin-top: -22px;
            border: 4px solid #fff;
        }
        .bottom-nav-item.center-btn span { margin-top: 2px; color: var(--c-primary); }

        /* ========== PAGE HEADER ========== */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .page-header h4 { font-weight: 800; font-size: 1.35rem; margin: 0 0 .25rem; letter-spacing: -.02em; }
        .page-header p { margin: 0; color: var(--c-muted); font-size: .875rem; }

        /* ========== STAT CARD ========== */
        .stat-card {
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            transition: all var(--tr);
            background: #fff;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--sh-md); border-color: var(--c-soft-2); }
        .stat-card .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .stat-card .stat-value { font-size: 1.5rem; font-weight: 800; line-height: 1; letter-spacing: -.03em; }
        .stat-card .stat-label { font-size: .78rem; color: var(--c-muted); margin-top: .3rem; font-weight: 500; }

        /* ========== LAPORAN ITEM ========== */
        .laporan-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 1.15rem;
            border-bottom: 1px solid var(--c-border);
            text-decoration: none;
            color: inherit;
            transition: background var(--tr);
            align-items: flex-start;
        }
        .laporan-item:last-child { border-bottom: none; }
        .laporan-item:hover { background: var(--c-soft); color: inherit; }
        .laporan-thumb {
            width: 68px; height: 68px;
            border-radius: var(--r-sm);
            object-fit: cover;
            flex-shrink: 0;
            background: var(--c-bg);
            display: flex; align-items: center; justify-content: center;
            color: var(--c-muted-2);
            font-size: 1.4rem;
            overflow: hidden;
            border: 1px solid var(--c-border);
        }
        .laporan-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .laporan-title { font-weight: 600; font-size: .9rem; margin-bottom: .3rem; color: var(--c-ink); }
        .laporan-meta { font-size: .75rem; color: var(--c-muted); display: flex; flex-wrap: wrap; gap: .85rem; margin-bottom: .4rem; }
        .laporan-meta i { font-size: .75rem; margin-right: .2rem; }

        /* ========== ALERT / TOAST ========== */
        .toast-wrap {
            position: fixed;
            top: 1rem; right: 1rem;
            z-index: 9999999;
            display: flex;
            flex-direction: column;
            gap: .5rem;
            max-width: 380px;
            width: calc(100% - 2rem);
        }
        .toast-item {
            background: #fff;
            border: 1px solid var(--c-border);
            border-left: 4px solid var(--c-primary);
            border-radius: var(--r-sm);
            padding: .85rem 1rem;
            box-shadow: var(--sh-lg);
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            font-size: .875rem;
            color: var(--c-ink-2);
            animation: toastIn 220ms cubic-bezier(.4,0,.2,1);
        }
        .toast-item.is-danger { border-left-color: var(--c-danger); }
        .toast-item.is-warning { border-left-color: var(--c-warning); }
        .toast-item.is-info { border-left-color: var(--c-info); }
        .toast-item .toast-icon { font-size: 1.1rem; flex-shrink: 0; color: var(--c-primary); }
        .toast-item.is-danger .toast-icon { color: var(--c-danger); }
        .toast-item.is-warning .toast-icon { color: var(--c-warning); }
        .toast-item.is-info .toast-icon { color: var(--c-info); }
        .toast-close { margin-left: auto; background: none; border: none; color: var(--c-muted-2); cursor: pointer; padding: 0; font-size: 1rem; line-height: 1; }

        @keyframes toastIn {
            from { opacity: 0; transform: translateY(-8px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--c-muted);
        }
        .empty-state .empty-icon {
            width: 72px; height: 72px;
            background: var(--c-soft);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--c-primary);
            margin-bottom: 1rem;
        }
        .empty-state .empty-title { font-weight: 600; color: var(--c-ink-2); margin-bottom: .35rem; font-size: .95rem; }
        .empty-state .empty-desc { font-size: .8rem; max-width: 320px; margin: 0 auto; }

        /* ========== MODAL ========== */
        .modal-content {
            border: none;
            border-radius: var(--r-lg);
            box-shadow: var(--sh-xl);
        }
        .modal-header {
            border-bottom: 1px solid var(--c-border);
            padding: 1rem 1.25rem;
        }
        .modal-title { font-weight: 700; font-size: 1rem; }
        .modal-body { padding: 1.25rem; }
        .modal-footer {
            border-top: 1px solid var(--c-border);
            padding: 1rem 1.25rem;
            gap: .5rem;
        }

        /* ========== CAMERA OVERLAY (preserved) ========== */
        .laporaja-cam-overlay {
            display: none;
            position: fixed; inset: 0;
            z-index: 1050;
            background: rgba(0,0,0,.9);
            align-items: center;
            justify-content: center;
            padding: 1rem;
            overflow-y: auto;
        }
        .laporaja-cam-overlay.active { display: flex; }
        .laporaja-cam-dialog {
            background: #fff;
            border-radius: var(--r-lg);
            max-width: 720px;
            width: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            max-height: calc(100vh - 2rem);
            box-shadow: var(--sh-xl);
        }
        .laporaja-cam-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--c-border);
            flex-shrink: 0;
        }
        .laporaja-cam-close {
            background: transparent;
            border: none;
            font-size: 1.75rem;
            line-height: 1;
            cursor: pointer;
            color: var(--c-muted);
            padding: 0;
            width: 32px;
            height: 32px;
            border-radius: var(--r-xs);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .laporaja-cam-close:hover { background: var(--c-bg); color: var(--c-ink); }
        .laporaja-cam-body {
            background: #000;
            position: relative;
            flex: 1;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .laporaja-cam-body video { width: 100%; max-height: 60vh; display: block; object-fit: contain; }
        .laporaja-cam-error {
            display: none;
            position: absolute; inset: 0;
            color: #fff;
            padding: 2rem;
            text-align: center;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .laporaja-cam-error.show { display: flex; }
        .laporaja-cam-error i { font-size: 3.5rem; opacity: .6; }
        .laporaja-cam-error p { margin: 1rem 0 .5rem; font-size: .9rem; max-width: 400px; }
        .laporaja-cam-error small { font-size: .78rem; opacity: .7; }
        .laporaja-cam-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--c-border);
            background: var(--c-bg);
            flex-shrink: 0;
        }

        .zoomable { cursor: zoom-in; transition: transform var(--tr); }
        .zoomable:hover { transform: scale(1.01); }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991px) {
            .app-sidebar { transform: translateX(-100%); }
            body.drawer-open .app-sidebar { transform: translateX(0); }

            .app-main { margin-left: 0; padding: 1rem; padding-bottom: calc(var(--bottom-nav-h) + 1.5rem); }
            .mobile-header { display: flex; }
            .bottom-nav { display: block; }

            .card-body { padding: 1rem; }
            .card-header { padding: .85rem 1rem; }
            .page-header { margin-bottom: 1rem; }
            .page-header h4 { font-size: 1.15rem; }
            .page-header p { font-size: .8125rem; }

            .laporan-thumb { width: 56px; height: 56px; font-size: 1.15rem; }
            .laporan-item { padding: .85rem 1rem; gap: .75rem; }
            .laporan-title { font-size: .86rem; }
            .laporan-meta { font-size: .72rem; gap: .65rem; }

            .stat-card .stat-value { font-size: 1.25rem; }
            .stat-card .stat-label { font-size: .7rem; }
            .stat-card .stat-icon { width: 38px; height: 38px; font-size: 1rem; }

            .toast-wrap { top: .75rem; right: .75rem; width: calc(100% - 1.5rem); }
        }

        @media (max-width: 575px) {
            .btn { min-height: 44px; }
            .btn-sm { min-height: 36px; }
            .content-wrap { padding: 0; }
        }
    </style>
</head>
<body>

{{-- DRAWER BACKDROP --}}
<div class="drawer-backdrop" onclick="toggleDrawer()"></div>

{{-- MOBILE HEADER --}}
<div class="mobile-header">
    <button class="icon-btn" onclick="toggleDrawer()" aria-label="Menu">
        <i class="bi bi-list"></i>
    </button>
    <a href="{{ route('dashboard') }}" class="mobile-brand">
        <span class="brand-icon-sm"><i class="bi bi-megaphone-fill"></i></span>
        LaporAja
    </a>
    <a href="{{ route('profile.index') }}" class="icon-btn" aria-label="Profil">
        <i class="bi bi-person-fill"></i>
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
            <a href="{{ route('admin.komplain') }}"
               class="bottom-nav-item {{ request()->routeIs('admin.komplain') ? 'active' : '' }}">
                <i class="bi bi-chat-square-text-fill"></i>
                <span>Komplain</span>
            </a>
            @if($user->isSuperAdmin() || $user->can_manage_users)
                <a href="{{ route('admin.users') }}"
                   class="bottom-nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Users</span>
                </a>
            @endif
        @endif

        <a href="{{ route('profile.index') }}"
           class="bottom-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i>
            <span>Profil</span>
        </a>
    </div>
</nav>

{{-- TOAST WRAP --}}
<div class="toast-wrap" id="toastWrap"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/medium-zoom@1.0.8/dist/medium-zoom.min.js"></script>
<script>
    /* ====== DRAWER ====== */
    function toggleDrawer() { document.body.classList.toggle('drawer-open'); }

    /* ====== TOAST ====== */
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
        const close = () => { el.style.opacity = '0'; el.style.transform = 'translateY(-8px)'; setTimeout(() => el.remove(), 220); };
        el.querySelector('.toast-close').addEventListener('click', close);
        setTimeout(close, 5000);
    }

    @if(session('success')) showToast(@json(session('success')), 'success'); @endif
    @if(session('error'))   showToast(@json(session('error')), 'danger'); @endif

    /* ====== MEDIUM ZOOM ====== */
    if (typeof mediumZoom === 'function') {
        mediumZoom('.zoomable', { background: 'rgba(0,0,0,.88)' });
    }

    /* ====== CAMERA ====== */
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
            if (document.body.classList.contains('drawer-open')) toggleDrawer();
        }
    });
</script>
@stack('scripts')
</body>
</html>