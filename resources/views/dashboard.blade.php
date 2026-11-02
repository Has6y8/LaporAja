@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php $user = auth()->user(); @endphp

<div class="page-header">
    <div>
        <h4>
            @if($user->isUser()) Halo, {{ explode(' ', $user->name)[0] }} 👋
            @elseif($user->isStaff()) Panel Staff
            @elseif($user->isSuperAdmin()) Panel Super Admin
            @else Panel Admin
            @endif
        </h4>
        <p>
            @if($user->isUser()) Pantau status laporan sarana Anda di sini.
            @elseif($user->isStaff()) Tangani laporan yang masuk dari siswa & guru.
            @else Kelola & supervisi semua laporan sarana sekolah.
            @endif
        </p>
    </div>
    @if($user->isUser())
        <a href="{{ route('laporan.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-lg"></i> Buat Laporan
        </a>
    @endif
</div>

@if(!$user->isUser())
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#f1f5f9;color:#475569;"><i class="bi bi-collection-fill"></i></div>
                    <div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total Laporan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#fffbeb;color:#d97706;"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-value">{{ $stats['pending'] }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#eff6ff;color:#2563eb;"><i class="bi bi-tools"></i></div>
                    <div>
                        <div class="stat-value">{{ $stats['diproses'] }}</div>
                        <div class="stat-label">Diproses</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#ecfdf5;color:#059669;"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="stat-value">{{ $stats['selesai'] }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">
            @if($user->isUser()) Laporan Saya
            @elseif($user->isStaff()) Laporan Aktif
            @else Semua Laporan
            @endif
        </h6>
        <span class="badge text-bg-light">{{ $laporans->count() }}</span>
    </div>

    <div class="card-body p-0">
        @forelse($laporans as $l)
            <a href="{{ route('laporan.show', $l) }}" class="laporan-item">
                <div class="laporan-thumb">
                    @if($l->foto_bukti)
                        <img src="{{ asset('storage/' . $l->foto_bukti) }}" alt="{{ $l->judul }}">
                    @else
                        <i class="bi bi-image"></i>
                    @endif
                </div>
                <div class="flex-grow-1" style="min-width:0;">
                    <div class="laporan-title text-truncate">{{ $l->judul }}</div>
                    <div class="laporan-meta">
                        <span><i class="bi bi-geo-alt"></i>{{ $l->lokasi }}</span>
                        @if(!$user->isUser())
                            <span><i class="bi bi-person"></i>{{ $l->user->name }}</span>
                        @endif
                    </div>
                    <span class="status-badge status-{{ $l->status }}">{{ $l->status_badge['label'] }}</span>
                </div>
                <i class="bi bi-chevron-right text-secondary flex-shrink-0" style="align-self:center;"></i>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                <div class="empty-title">
                    @if($user->isUser()) Belum ada laporan
                    @else Belum ada laporan masuk
                    @endif
                </div>
                <div class="empty-desc">
                    @if($user->isUser()) Yuk buat laporan pertama Anda.
                    @else Laporan baru akan muncul di sini.
                    @endif
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection