@extends('layouts.app')

@section('title', 'Verifikasi Laporan')

@section('content')

<div class="page-header">
    <div>
        <h4>Verifikasi Laporan</h4>
        <p>
            Sebagai supervisor, periksa kelayakan laporan.
            <br>
            <span style="color:#92400e;font-size:.78rem;">
                <i class="bi bi-info-circle-fill"></i>
                Hanya laporan yang <strong>belum diproses staff</strong> yang bisa diverifikasi.
            </span>
        </p>
    </div>
</div>

@forelse($laporans as $l)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-2 flex-wrap">
                <div style="min-width:0;">
                    <h6 class="fw-bold mb-1">{{ $l->judul }}</h6>
                    <small style="color:var(--c-muted);font-size:.78rem;">
                        <i class="bi bi-person me-1"></i>{{ $l->user->name }} •
                        <i class="bi bi-geo-alt ms-2 me-1"></i>{{ $l->lokasi }} •
                        <i class="bi bi-clock ms-2 me-1"></i>{{ $l->created_at->diffForHumans() }}
                    </small>
                </div>
                <span class="badge text-bg-warning">Menunggu Verifikasi</span>
            </div>

            <p style="font-size:.85rem;color:var(--c-muted);">{{ $l->deskripsi }}</p>

            @if($l->foto_bukti)
                <img src="{{ $l->foto_bukti }}" class="rounded-3 border zoomable mb-3" style="max-height:200px;">
            @endif

            <div class="d-flex gap-2 flex-wrap">
                <form method="POST" action="{{ route('admin.verifikasi.proses', $l) }}" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="moderation_status" value="approved">
                    <button class="btn btn-sm btn-primary fw-semibold">
                        <i class="bi bi-check-lg"></i> Setujui
                    </button>
                </form>
                <button class="btn btn-sm btn-light fw-semibold" style="color:#dc2626;border-color:#fca5a5;"
                        data-bs-toggle="modal" data-bs-target="#reject{{ $l->id }}">
                    <i class="bi bi-x-lg"></i> Tolak
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reject{{ $l->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.verifikasi.proses', $l) }}">
                @csrf @method('PUT')
                <input type="hidden" name="moderation_status" value="rejected">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="alasan_moderasi" rows="3" class="form-control" required
                                  placeholder="Contoh: Foto blur, kata tidak pantas, laporan tidak jelas..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-danger" style="background:#dc2626;border-color:#dc2626;">Tolak Laporan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@empty
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon" style="background:#d1fae5;color:#059669;"><i class="bi bi-check-circle"></i></div>
            <div class="empty-title">Tidak ada laporan menunggu verifikasi</div>
            <div class="empty-desc">Semua laporan sudah diverifikasi.</div>
        </div>
    </div>
@endforelse

@endsection