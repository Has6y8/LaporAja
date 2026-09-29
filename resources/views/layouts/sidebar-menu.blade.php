@php $user = auth()->user(); @endphp

<ul class="sidebar-menu">
    <li class="menu-label">Menu</li>

    {{-- ============================================
         DASHBOARD (semua role)
         ============================================ --}}
    <li>
        <a href="{{ route('dashboard') }}"
           class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
    </li>

    {{-- ============================================
         USER MENU
         ============================================ --}}
    @if($user->isUser())
        <li>
            <a href="{{ route('laporan.create') }}"
               class="menu-item {{ request()->routeIs('laporan.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle-fill"></i> Buat Laporan
            </a>
        </li>

        <li>
            <a href="{{ route('komplain.index') }}"
               class="menu-item {{ request()->routeIs('komplain.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i> Komplain Saya
                @php
                    $c = \App\Models\Komplain::where('user_id', $user->id)
                        ->where('status', 'direspon')
                        ->whereNull('read_at')
                        ->count();
                @endphp
                @if($c > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $c }}</span>
                @endif
            </a>
        </li>
    @endif

    {{-- ============================================
         STAFF MENU
         ============================================ --}}
    @if($user->isStaff())
        <li>
            <a href="{{ route('staff.laporan') }}"
               class="menu-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i> Tugas Laporan
                @php
                    $c = \App\Models\Laporan::whereIn('status', ['pending', 'diproses'])->count();
                @endphp
                @if($c > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $c }}</span>
                @endif
            </a>
        </li>

        <li>
            <a href="{{ route('komplain.index') }}"
               class="menu-item {{ request()->routeIs('komplain.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i> Komplain Saya
                @php
                    $c = \App\Models\Komplain::where('user_id', $user->id)
                        ->where('status', 'direspon')
                        ->whereNull('read_at')
                        ->count();
                @endphp
                @if($c > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $c }}</span>
                @endif
            </a>
        </li>
    @endif

    {{-- ============================================
         HISTORI (semua role)
         ============================================ --}}
    <li>
        <a href="{{ route('histori') }}"
           class="menu-item {{ request()->routeIs('histori') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Histori
        </a>
    </li>

    {{-- ============================================
         ADMIN MENU (Admin & Super Admin)
         ============================================ --}}
    @if($user->isAdmin())
        <li class="menu-label mt-2">Admin</li>

        <li>
            <a href="{{ route('admin.verifikasi') }}"
               class="menu-item {{ request()->routeIs('admin.verifikasi') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i> Verifikasi Laporan
                @php
                    $c = \App\Models\Laporan::where('moderation_status', 'pending')
                        ->where('status', 'pending')
                        ->count();
                @endphp
                @if($c > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $c }}</span>
                @endif
            </a>
        </li>

        <li>
            <a href="{{ route('admin.komplain') }}"
               class="menu-item {{ request()->routeIs('admin.komplain') ? 'active' : '' }}">
                <i class="bi bi-chat-square-text-fill"></i> Komplain Masuk
                @php
                    $c = \App\Models\Komplain::where('status', 'pending')->count();
                @endphp
                @if($c > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $c }}</span>
                @endif
            </a>
        </li>

        <li>
            <a href="{{ route('admin.users') }}"
               class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Kelola User
            </a>
        </li>
    @endif

    {{-- ============================================
         SUPER ADMIN MENU
         ============================================ --}}
    @if($user->isSuperAdmin())
        <li class="menu-label mt-2">Super Admin</li>
        <li>
            <a href="{{ route('super.approvals') }}"
               class="menu-item {{ request()->routeIs('super.approvals') ? 'active' : '' }}">
                <i class="bi bi-person-check-fill"></i> Pengajuan Akun
                @php
                    $c = \App\Models\User::where('status_akun', 'pending')->count();
                @endphp
                @if($c > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $c }}</span>
                @endif
            </a>
        </li>
    @endif
</ul>