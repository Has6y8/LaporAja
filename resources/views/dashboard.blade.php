@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php $user = auth()->user(); @endphp

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            @if($user->isUser()) Halo, {{ explode(' ', $user->name)[0] }} 👋
            @elseif($user->isStaff()) Panel Staff
            @elseif($user->isSuperAdmin()) Panel Super Admin
            @else Panel Admin
            @endif
        </h4>
        <p class="text-secondary mb-0 small">
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
            <div class="card stat-card border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#f1f5f9;color:#475569;"><i class="bi bi-collection-fill"></i></div>
                    <div>
                        <div class="fs-4 fw-bold lh-1">{{ $stats['total'] }}</div>
                        <div class="small text-secondary mt-1">Total Laporan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#fffbeb;color:#d97706;"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="fs-4 fw-bold lh-1">{{ $stats['pending'] }}</div>
                        <div class="small text-secondary mt-1">Pending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#eff6ff;color:#2563eb;"><i class="bi bi-tools"></i></div>
                    <div>
                        <div class="fs-4 fw-bold lh-1">{{ $stats['diproses'] }}</div>
                        <div class="small text-secondary mt-1">Diproses</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon" style="background:#ecfdf5;color:#059669;"><i class="bi bi-check-circle-fill"></i></div>
                    <div>
                        <div class="fs-4 fw-bold lh-1">{{ $stats['selesai'] }}</div>
                        <div class="small text-secondary mt-1">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
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
                        <img src="{{ asset('storage/' . $l->foto_bukti) }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                    @else
                        <i class="bi bi-image"></i>
                    @endif
                </div>
                <div class="flex-grow-1 min-width-0">
                    <div class="fw-semibold text-truncate mb-1" style="font-size:.95rem;">{{ $l->judul }}</div>
                    <div class="small text-secondary d-flex flex-wrap gap-3 mb-1">
                        <span><i class="bi bi-geo-alt me-1"></i>{{ $l->lokasi }}</span>
                        @if(!$user->isUser())
                            <span><i class="bi bi-person me-1"></i>{{ $l->user->name }}</span>
                        @endif
                    </div>
                    <div class="d-flex gap-1 flex-wrap">
                        <span class="status-badge status-{{ $l->status }}">{{ $l->status_badge['label'] }}</span>
                    </div>
                </div>
                <i class="bi bi-chevron-right text-secondary flex-shrink-0"></i>
            </a>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox display-4 text-secondary opacity-50"></i>
                <p class="text-secondary mt-3 mb-0 small">
                    @if($user->isUser()) Belum ada laporan.
                    @else Belum ada laporan masuk.
                    @endif
                </p>
            </div>
        @endforelse
    </div>
</div>

@endsection