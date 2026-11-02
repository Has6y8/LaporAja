@extends('layouts.app')

@section('title', 'Komplain Saya')

@section('content')

<div class="page-header">
    <div>
        <h4>Komplain Saya</h4>
        <p>Daftar komplain yang Anda kirim.</p>
    </div>
</div>

@forelse($komplains as $k)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-2 mb-2 flex-wrap">
                <div class="d-flex gap-1 flex-wrap">
                    <span class="badge text-bg-light">{{ $k->tipe_label }}</span>
                    <span class="badge text-bg-{{ $k->status === 'direspon' ? 'success' : ($k->status === 'ditolak' ? 'danger' : 'warning') }}">
                        {{ $k->status === 'direspon' ? 'Direspon' : ($k->status === 'ditolak' ? 'Ditolak' : 'Pending') }}
                    </span>
                </div>
                <small style="font-size:.75rem;color:var(--c-muted);">{{ $k->created_at->format('d M Y H:i') }}</small>
            </div>
            <div class="fw-semibold mb-1" style="font-size:.85rem;">Laporan: {{ $k->laporan->judul }}</div>
            <p class="mb-2" style="font-size:.85rem;color:var(--c-muted);">{{ $k->isi }}</p>

            @if($k->respon_admin)
                @php $isDitolak = $k->status === 'ditolak'; @endphp
                <div class="p-3 rounded-3" style="background:{{ $isDitolak ? '#fef2f2' : '#ecfdf5' }};border-left:3px solid {{ $isDitolak ? '#dc2626' : '#059669' }};">
                    <div class="fw-bold mb-1" style="font-size:.78rem;color:{{ $isDitolak ? '#991b1b' : '#065f46' }};">
                        <i class="bi bi-{{ $isDitolak ? 'x-circle-fill' : 'reply-fill' }} me-1"></i>
                        {{ $isDitolak ? 'Komplain Ditolak' : 'Respon Admin' }}
                    </div>
                    <div style="font-size:.85rem;color:{{ $isDitolak ? '#991b1b' : '#065f46' }};">{{ $k->respon_admin }}</div>
                    <div class="mt-1" style="font-size:.72rem;opacity:.7;color:{{ $isDitolak ? '#991b1b' : '#065f46' }};">
                        {{ $k->respon_at->format('d M Y H:i') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@empty
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-chat-dots"></i></div>
            <div class="empty-title">Belum ada komplain</div>
            <div class="empty-desc">Komplain yang Anda kirim akan tampil di sini.</div>
        </div>
    </div>
@endforelse

@endsection