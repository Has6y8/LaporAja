@extends('layouts.app')

@section('title', 'Histori')

@section('content')

<div class="page-header">
    <div>
        <h4>Histori Laporan</h4>
        <p>Laporan yang sudah selesai atau ditolak.</p>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @forelse($laporans as $l)
            <a href="{{ route('laporan.show', $l) }}" class="laporan-item">
                <div class="laporan-thumb">
                    @if($l->foto_bukti)
                        <img src="{{ $l->foto_bukti }}" alt="{{ $l->judul }}">
                    @else
                        <i class="bi bi-image"></i>
                    @endif
                </div>
                <div class="flex-grow-1" style="min-width:0;">
                    <div class="laporan-title text-truncate">{{ $l->judul }}</div>
                    <div class="laporan-meta">
                        <span><i class="bi bi-person"></i>{{ $l->user->name }}</span>
                        <span><i class="bi bi-calendar3"></i>{{ $l->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
                <span class="status-badge status-{{ $l->status }} flex-shrink-0" style="align-self:center;">
                    {{ $l->status_badge['label'] }}
                </span>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-clock-history"></i></div>
                <div class="empty-title">Belum ada histori</div>
                <div class="empty-desc">Laporan yang selesai atau ditolak akan tampil di sini.</div>
            </div>
        @endforelse
    </div>
</div>

@endsection