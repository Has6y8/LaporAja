@extends('layouts.app')

@section('title', 'Komplain Masuk')

@section('content')

<div class="page-header">
    <div>
        <h4>Komplain Masuk</h4>
        <p>Respon komplain dari user & staff. Untuk permintaan hapus laporan, pilih aksi yang sesuai.</p>
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
                    @if($k->tipe === 'minta_hapus_laporan')
                        <span class="badge text-bg-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i> Permintaan Hapus
                        </span>
                    @endif
                </div>
                <small style="font-size:.75rem;color:var(--c-muted);">{{ $k->created_at->format('d M Y H:i') }}</small>
            </div>

            <div class="mb-2" style="font-size:.82rem;">
                <strong>Dari:</strong> {{ $k->user->name }}
                <span style="color:var(--c-muted);">({{ $k->user->roleLabel() }})</span>
                <br>
                <strong>Laporan:</strong>
                @if($k->laporan)
                    <a href="{{ route('laporan.show', $k->laporan) }}" class="text-decoration-none" style="color:var(--c-primary);">
                        {{ $k->laporan->judul }}
                    </a>
                    <span class="status-badge status-{{ $k->laporan->status }} ms-1">{{ $k->laporan->status_badge['label'] }}</span>
                @else
                    <span class="fst-italic" style="color:var(--c-danger);">Laporan sudah dihapus</span>
                @endif
            </div>

            <p class="mb-3" style="font-size:.85rem;color:var(--c-muted);">{{ $k->isi }}</p>

            @if(in_array($k->status, ['direspon', 'ditolak']))
                @php $isDitolak = $k->status === 'ditolak'; @endphp
                <div class="p-3 rounded-3" style="background:{{ $isDitolak ? '#fef2f2' : '#ecfdf5' }};border-left:3px solid {{ $isDitolak ? '#dc2626' : '#059669' }};">
                    <div class="fw-bold mb-1" style="font-size:.78rem;color:{{ $isDitolak ? '#991b1b' : '#065f46' }};">
                        <i class="bi bi-{{ $isDitolak ? 'x-circle-fill' : 'reply-fill' }} me-1"></i>
                        {{ $isDitolak ? 'Komplain Ditolak' : 'Respon Anda' }}
                    </div>
                    <div style="font-size:.85rem;color:{{ $isDitolak ? '#991b1b' : '#065f46' }};">{{ $k->respon_admin }}</div>
                    @if($k->respon_at)
                        <div class="mt-1" style="font-size:.72rem;opacity:.7;color:{{ $isDitolak ? '#991b1b' : '#065f46' }};">
                            {{ $k->respon_at->format('d M Y H:i') }}
                        </div>
                    @endif
                </div>
            @else
                <form method="POST" action="{{ route('admin.komplain.respon', $k) }}" id="formKomplain{{ $k->id }}">
                    @csrf @method('PUT')

                    <textarea name="respon_admin" rows="3" class="form-control mb-3" required
                              placeholder="Tulis respon Anda..."></textarea>

                    <div class="mb-3">
                        <label class="form-label">Aksi <span class="text-danger">*</span></label>
                        <div class="d-flex flex-column gap-2">

                            <div class="form-check p-3 rounded-3" style="background:#f8fafc;border:1px solid var(--c-border);">
                                <input class="form-check-input" type="radio" name="aksi"
                                       value="respon_saja" id="aksi_respon_{{ $k->id }}"
                                       {{ $k->tipe !== 'minta_hapus_laporan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="aksi_respon_{{ $k->id }}" style="font-size:.85rem;">
                                    <strong>💬 Hanya Respon</strong> — Kirim respon saja, tanpa aksi ke laporan.
                                </label>
                            </div>

                            @if($k->laporan && $k->laporan->status !== 'ditolak')
                                <div class="form-check p-3 rounded-3" style="background:#fffbeb;border:1px solid #fcd34d;">
                                    <input class="form-check-input" type="radio" name="aksi"
                                           value="tolak_laporan" id="aksi_tolak_{{ $k->id }}">
                                    <label class="form-check-label" for="aksi_tolak_{{ $k->id }}" style="font-size:.85rem;">
                                        <strong>🚫 Tolak Komplain</strong> — Komplain ditandai "Ditolak".
                                        Status laporan <strong>tidak berubah</strong>.
                                    </label>
                                </div>
                            @endif

                            @if($k->tipe === 'minta_hapus_laporan' && $k->laporan)
                                <div class="form-check p-3 rounded-3" style="background:#fef2f2;border:1px solid #fca5a5;">
                                    <input class="form-check-input" type="radio" name="aksi"
                                           value="hapus_laporan" id="aksi_hapus_{{ $k->id }}">
                                    <label class="form-check-label" for="aksi_hapus_{{ $k->id }}" style="font-size:.85rem;">
                                        <strong class="text-danger">🗑️ Hapus Permanen</strong> — Laporan dihapus dari database.
                                        Tidak bisa dikembalikan!
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm fw-semibold"
                            onclick="return konfirmasiHapus(event, {{ $k->id }})">
                        <i class="bi bi-send-fill"></i> Kirim Respon
                    </button>
                </form>
            @endif
        </div>
    </div>
@empty
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-chat-square-text"></i></div>
            <div class="empty-title">Belum ada komplain masuk</div>
            <div class="empty-desc">Komplain dari user/staff akan tampil di sini.</div>
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