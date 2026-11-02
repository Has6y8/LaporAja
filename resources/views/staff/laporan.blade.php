@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('content')

<div class="page-header">
    <div>
        <h4>Tugas Saya</h4>
        <p>Laporan yang sudah diverifikasi admin & menunggu ditangani.</p>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0" style="font-size:.9rem;">Laporan Aktif</h6>
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
                        <span><i class="bi bi-person"></i>{{ $l->user->name }}</span>
                        <span><i class="bi bi-calendar3"></i>{{ $l->created_at->format('d M Y') }}</span>
                    </div>
                    <span class="status-badge status-{{ $l->status }}">{{ $l->status_badge['label'] }}</span>
                </div>
                <i class="bi bi-chevron-right text-secondary flex-shrink-0" style="align-self:center;"></i>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-icon" style="background:#d1fae5;color:#059669;"><i class="bi bi-check2-circle"></i></div>
                <div class="empty-title">Tidak ada tugas aktif</div>
                <div class="empty-desc">Kerja bagus! 🎉</div>
            </div>
        @endforelse
    </div>
</div>

@endsection