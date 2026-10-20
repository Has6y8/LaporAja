@php $user = auth()->user(); @endphp

<ul class="sidebar-menu">
    <li class="menu-label">Menu</li>

    {{-- DASHBOARD --}}
    <li>
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>
    </li>

    {{-- USER MENU --}}
    @if($user->isUser())
        <li>
            <a href="{{ route('laporan.create') }}" class="menu-item {{ request()->routeIs('laporan.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle-fill"></i> Buat Laporan
            </a>
        </li>
        <li>
            <a href="{{ route('komplain.index') }}" class="menu-item {{ request()->routeIs('komplain.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i> Komplain Saya
            </a>
        </li>
    @endif

    {{-- STAFF MENU --}}
    @if($user->isStaff())
        <li>
            <a href="{{ route('staff.laporan') }}" class="menu-item {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i> Tugas Laporan
            </a>
        </li>
        <li>
            <a href="{{ route('komplain.index') }}" class="menu-item {{ request()->routeIs('komplain.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i> Komplain Saya
            </a>
        </li>
    @endif

    {{-- HISTORI & PROFIL --}}
    <li>
        <a href="{{ route('histori') }}" class="menu-item {{ request()->routeIs('histori') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Histori
        </a>
    </li>
    <li>
        <a href="{{ route('profile.index') }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i> Profil Saya
        </a>
    </li>

    {{-- ADMIN MENU (Hanya Muncul Jika Punya Izin) --}}
    @if($user->isAdmin())
        <li class="menu-label mt-2">Admin</li>

        <li>
            <a href="{{ route('admin.komplain') }}" class="menu-item {{ request()->routeIs('admin.komplain') ? 'active' : '' }}">
                <i class="bi bi-chat-square-text-fill"></i> Komplain Masuk
            </a>
        </li>

        {{-- Kelola user disembunyikan jika tidak punya izin --}}
        @if($user->isSuperAdmin() || $user->can_manage_users)
            <li>
                <a href="{{ route('admin.users') }}" class="menu-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Kelola User
                </a>
            </li>
        @endif
    @endif

    {{-- SUPER ADMIN MENU --}}
    @if($user->isSuperAdmin())
        <li class="menu-label mt-2">Super Admin</li>
        <li>
            <a href="{{ route('super.approvals') }}" class="menu-item {{ request()->routeIs('super.approvals') ? 'active' : '' }}">
                <i class="bi bi-person-check-fill"></i> Pengajuan Akun
            </a>
        </li>
    @endif
</ul>