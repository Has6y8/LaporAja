@extends('layouts.app')

@section('title', 'Histori')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Histori Laporan</h4>
    <p class="text-secondary mb-0 small">Laporan yang sudah selesai atau ditolak.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @forelse($laporans as $l)
            <a href="{{ route('laporan.show', $l) }}" class="laporan-item">
                <div class="laporan-thumb">
                    @if($l->foto_bukti)
                        <img src="{{ asset('storage/' . $l->foto_bukti) }}"
                             style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                    @else
                        <i class="bi bi-image"></i>
                    @endif
                </div>
                <div class="flex-grow-1 min-width-0">
                    <div class="fw-semibold text-truncate mb-1">{{ $l->judul }}</div>
                    <div class="small text-secondary d-flex flex-wrap gap-3">
                        <span><i class="bi bi-person me-1"></i>{{ $l->user->name }}</span>
                        <span><i class="bi bi-calendar3 me-1"></i>{{ $l->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
                <span class="status-badge status-{{ $l->status }} flex-shrink-0">
                    {{ $l->status_badge['label'] }}
                </span>
            </a>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-clock-history display-4 text-secondary opacity-50"></i>
                <p class="text-secondary mt-3 mb-0 small">Belum ada histori.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection