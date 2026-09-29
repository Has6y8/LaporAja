@extends('layouts.app')

@section('title', 'Komplain Masuk')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Komplain Masuk</h4>
    <p class="text-secondary mb-0 small">
        Respon komplain dari user & staff. Untuk permintaan hapus laporan, pilih aksi yang sesuai.
    </p>
</div>

@forelse($komplains as $k)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-4">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-start gap-2 mb-2 flex-wrap">
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge text-bg-light">{{ $k->tipe_label }}</span>
                    <span class="badge text-bg-{{ $k->status === 'direspon' ? 'success' : 'warning' }}">
                        {{ $k->status === 'direspon' ? 'Direspon' : 'Pending' }}
                    </span>
                    @if($k->tipe === 'minta_hapus_laporan')
                        <span class="badge text-bg-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i> Permintaan Hapus
                        </span>
                    @endif
                </div>
                <small class="text-secondary">{{ $k->created_at->format('d M Y H:i') }}</small>
            </div>

            {{-- INFO --}}
            <div class="small mb-2">
                <strong>Dari:</strong> {{ $k->user->name }}
                <span class="text-secondary">({{ $k->user->roleLabel() }})</span>
                <br>
                <strong>Laporan:</strong>
                @if($k->laporan)
                    <a href="{{ route('laporan.show', $k->laporan) }}" class="text-decoration-none">
                        {{ $k->laporan->judul }}
                    </a>
                    <span class="status-badge status-{{ $k->laporan->status }} ms-1">
                        {{ $k->laporan->status_badge['label'] }}
                    </span>
                @else
                    <span class="text-danger fst-italic">Laporan sudah dihapus</span>
                @endif
            </div>

            {{-- ISI KOMPLAIN --}}
            <p class="small text-secondary mb-3">{{ $k->isi }}</p>

            {{-- SUDAH DIRESPON --}}
            @if($k->status === 'direspon')
                <div class="p-3 rounded-3" style="background:#ecfdf5;border-left:3px solid #059669;">
                    <div class="small fw-bold mb-1" style="color:#065f46;">
                        <i class="bi bi-reply-fill me-1"></i> Respon Anda
                    </div>
                    <div class="small" style="color:#065f46;">{{ $k->respon_admin }}</div>
                    @if($k->respon_at)
                        <div class="small mt-1" style="color:#065f46;opacity:.7;font-size:.72rem;">
                            {{ $k->respon_at->format('d M Y H:i') }}
                        </div>
                    @endif
                </div>
            @else
                {{-- FORM RESPON --}}
                <form method="POST" action="{{ route('admin.komplain.respon', $k) }}" id="formKomplain{{ $k->id }}">
                    @csrf @method('PUT')

                    <textarea name="respon_admin" rows="3" class="form-control mb-3" required
                              placeholder="Tulis respon Anda..."></textarea>

                    {{-- PILIHAN AKSI --}}
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Aksi <span class="text-danger">*</span>
                        </label>

                        <div class="d-flex flex-column gap-2">

                            {{-- Opsi 1: Respon Saja --}}
                            <div class="form-check p-3 rounded-3 border" style="background:#f8fafc;">
                                <input class="form-check-input" type="radio" name="aksi"
                                       value="respon_saja" id="aksi_respon_{{ $k->id }}"
                                       {{ $k->tipe !== 'minta_hapus_laporan' ? 'checked' : '' }}>
                                <label class="form-check-label small" for="aksi_respon_{{ $k->id }}">
                                    <strong>💬 Hanya Respon</strong> — Kirim respon saja, tanpa aksi ke laporan.
                                </label>
                            </div>

                            {{-- Opsi 2: Tolak Laporan --}}
                            @if($k->laporan && $k->laporan->status !== 'ditolak')
                                <div class="form-check p-3 rounded-3 border" style="background:#fffbeb;">
                                    <input class="form-check-input" type="radio" name="aksi"
                                           value="tolak_laporan" id="aksi_tolak_{{ $k->id }}">
                                    <label class="form-check-label small" for="aksi_tolak_{{ $k->id }}">
                                        <strong>🚫 Tolak Laporan</strong> — Set status jadi "Ditolak".
                                        Laporan masih tersimpan di histori user.
                                    </label>
                                </div>
                            @endif

                            {{-- Opsi 3: Hapus Permanen (khusus minta_hapus_laporan) --}}
                            @if($k->tipe === 'minta_hapus_laporan' && $k->laporan)
                                <div class="form-check p-3 rounded-3 border" style="background:#fef2f2;border-color:#ef4444 !important;">
                                    <input class="form-check-input" type="radio" name="aksi"
                                           value="hapus_laporan" id="aksi_hapus_{{ $k->id }}">
                                    <label class="form-check-label small" for="aksi_hapus_{{ $k->id }}">
                                        <strong class="text-danger">🗑️ Hapus Permanen</strong> — Laporan dihapus dari database.
                                        Tidak bisa dikembalikan!
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary fw-semibold"
                            onclick="return konfirmasiHapus(event, {{ $k->id }})">
                        <i class="bi bi-send-fill"></i> Kirim Respon
                    </button>
                </form>
            @endif
        </div>
    </div>
@empty
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-chat-square-text display-4 text-secondary opacity-50"></i>
            <p class="text-secondary mt-3 mb-0 small">Belum ada komplain masuk.</p>
        </div>
    </div>
@endforelse

@endsection

@push('scripts')
<script>
    function konfirmasiHapus(e, id) {
        const form = document.getElementById('formKomplain' + id);
        const aksi = form.querySelector('input[name="aksi"]:checked');

        if (aksi && aksi.value === 'hapus_laporan') {
            if (!confirm('⚠️ YAKIN ingin MENGHAPUS PERMANEN laporan ini?\n\nLaporan + foto bukti + riwayat akan hilang selamanya.\n\nTindakan ini tidak bisa dibatalkan!')) {
                e.preventDefault();
                return false;
            }
        }
        return true;
    }
</script>
@endpush