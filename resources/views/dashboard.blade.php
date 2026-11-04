@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php $user = auth()->user(); @endphp

<div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
    <div>
        <h4>
            @if($user->isUser()) Halo, {{ explode(' ', $user->name)[0] }} 👋
            @elseif($user->isStaff()) Panel Staff
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
    
    <div class="d-flex gap-2 flex-wrap">
        {{-- TOMBOL EXPORT CSV --}}
        @if($user->isAdmin() || $user->isStaff())
            <a href="{{ route('admin.export') }}" class="btn btn-light fw-bold" style="color:#059669; border-color:#059669;">
                <i class="bi bi-filetype-csv me-1"></i> Export CSV
            </a>
        @endif

        {{-- TOMBOL BUAT LAPORAN (Khusus User) --}}
        @if($user->isUser())
            <a href="{{ route('laporan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Buat Laporan
            </a>
        @endif
    </div>
</div>

@if(!$user->isUser())
    <div class="row g-3 mb-4">
        <!-- Total -->
        <div class="col-6 col-md-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0;">
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div class="mb-2">
                        <i class="bi bi-collection-fill" style="font-size: 1.25rem; color:#64748b;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.35rem;font-weight:800;line-height:1;color:#1e293b;">{{ $stats['total'] }}</div>
                        <div style="font-size:.75rem;color:#64748b;font-weight:600;margin-top:4px;">Total</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending -->
        <div class="col-6 col-md-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a;">
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div class="mb-2">
                        <i class="bi bi-hourglass-split" style="font-size: 1.25rem; color:#d97706;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.35rem;font-weight:800;line-height:1;color:#92400e;">{{ $stats['pending'] }}</div>
                        <div style="font-size:.75rem;color:#b45309;font-weight:600;margin-top:4px;">Pending</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Diproses -->
        <div class="col-6 col-md-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe;">
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div class="mb-2">
                        <i class="bi bi-tools" style="font-size: 1.25rem; color:#2563eb;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.35rem;font-weight:800;line-height:1;color:#1e40af;">{{ $stats['diproses'] }}</div>
                        <div style="font-size:.75rem;color:#1d4ed8;font-weight:600;margin-top:4px;">Diproses</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Selesai -->
        <div class="col-6 col-md-3">
            <div class="card h-100" style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1px solid #a7f3d0;">
                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div class="mb-2">
                        <i class="bi bi-check-circle-fill" style="font-size: 1.25rem; color:#059669;"></i>
                    </div>
                    <div>
                        <div style="font-size:1.35rem;font-weight:800;line-height:1;color:#065f46;">{{ $stats['selesai'] }}</div>
                        <div style="font-size:.75rem;color:#047857;font-weight:600;margin-top:4px;">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card border-0">
    <div class="card-header d-flex justify-content-between align-items-center" style="border-bottom:none;padding-bottom:0;">
        <h5 class="fw-bold mb-0" style="letter-spacing:-.02em;color:var(--c-deep);">
            @if($user->isUser()) Laporan Saya
            @elseif($user->isStaff()) Laporan Aktif
            @else Semua Laporan Masuk
            @endif
        </h5>
        <span class="badge bg-light text-dark border">{{ $laporans->count() }} Data</span>
    </div>

    <div class="card-body p-0 mt-3">
        @forelse($laporans as $l)
            <a href="{{ route('laporan.show', $l) }}" class="text-decoration-none d-block p-3 border-bottom" style="transition: background .2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <div class="d-flex gap-3 align-items-center">
                    <div style="width:70px;height:70px;border-radius:14px;overflow:hidden;flex-shrink:0;background:#f1f5f9;border:1px solid var(--c-border);">
                        @if($l->foto_bukti)
                            <img src="{{ $l->foto_bukti }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted"><i class="bi bi-image fs-4"></i></div>
                        @endif
                    </div>
                    <div class="flex-grow-1" style="min-width:0;">
                        <div class="fw-bold text-dark text-truncate mb-1" style="font-size:1rem;">{{ $l->judul }}</div>
                        <div class="d-flex flex-wrap gap-3 text-muted mb-2" style="font-size:.8rem;">
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $l->lokasi }}</span>
                            @if(!$user->isUser())
                                <span><i class="bi bi-person me-1"></i>{{ $l->user->name }}</span>
                            @endif
                        </div>
                        <span class="status-badge status-{{ $l->status }}">{{ $l->status_badge['label'] }}</span>
                    </div>
                    <div class="text-muted d-none d-sm-block pe-2">
                        <i class="bi bi-chevron-right fs-5"></i>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-5">
                <div style="width:80px;height:80px;background:var(--c-soft);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:var(--c-primary);font-size:2rem;margin-bottom:1rem;">
                    <i class="bi bi-inbox"></i>
                </div>
                <h6 class="fw-bold">Belum ada laporan</h6>
                <p class="text-muted small mb-0">Laporan baru akan muncul di sini.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection