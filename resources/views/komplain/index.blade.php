@extends('layouts.app')

@section('title', 'Komplain Saya')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Komplain Saya</h4>
    <p class="text-secondary mb-0 small">Daftar komplain yang Anda kirim.</p>
</div>

@forelse($komplains as $k)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                <div>
                    <span class="badge text-bg-light">{{ $k->tipe_label }}</span>
                    <span class="badge text-bg-{{ $k->status === 'direspon' ? 'success' : 'warning' }} ms-1">
                        {{ $k->status === 'direspon' ? 'Direspon' : 'Pending' }}
                    </span>
                </div>
                <small class="text-secondary">{{ $k->created_at->format('d M Y H:i') }}</small>
            </div>
            <div class="small fw-semibold mb-1">Laporan: {{ $k->laporan->judul }}</div>
            <p class="small text-secondary mb-2">{{ $k->isi }}</p>

            @if($k->respon_admin)
                <div class="p-3 rounded-3" style="background:#ecfdf5;border-left:3px solid #059669;">
                    <div class="small fw-bold mb-1" style="color:#065f46;">
                        <i class="bi bi-reply-fill me-1"></i> Respon Admin
                    </div>
                    <div class="small" style="color:#065f46;">{{ $k->respon_admin }}</div>
                    <div class="small mt-1" style="color:#065f46;opacity:.7;font-size:.72rem;">
                        {{ $k->respon_at->format('d M Y H:i') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@empty
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-chat-dots display-4 text-secondary opacity-50"></i>
            <p class="text-secondary mt-3 mb-0 small">Belum ada komplain.</p>
        </div>
    </div>
@endforelse

@endsection
