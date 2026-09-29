@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')

@php
    $user = auth()->user();
    $sudahDiprosesStaff = $laporan->status !== 'pending';
    $sudahDiverifikasiAdmin = $laporan->moderation_status !== 'pending';
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Detail Laporan</h4>
        <p class="text-secondary mb-0 small">
            Laporan #{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }} •
            {{ $laporan->created_at->format('d M Y, H:i') }}
        </p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-light d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-3">
    {{-- ============================================
         KIRI: DETAIL LAPORAN
         ============================================ --}}
    <div class="col-lg-8">

        {{-- CARD DETAIL --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                    <h5 class="fw-bold mb-0">{{ $laporan->judul }}</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="status-badge status-{{ $laporan->status }}">
                            {{ $laporan->status_badge['label'] }}
                        </span>
                        @if($laporan->moderation_status !== 'approved')
                            <span class="status-badge status-{{ $laporan->moderation_status === 'pending' ? 'pending' : 'rejected' }}">
                                {{ $laporan->moderation_badge['label'] }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row g-3 pb-3 mb-3 border-bottom">
                    <div class="col-md-6">
                        <div class="text-secondary text-uppercase fw-semibold" style="font-size:.7rem;letter-spacing:.5px;">
                            Pelapor
                        </div>
                        <div class="fw-semibold small mt-1">{{ $laporan->user->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-secondary text-uppercase fw-semibold" style="font-size:.7rem;letter-spacing:.5px;">
                            Lokasi
                        </div>
                        <div class="fw-semibold small mt-1">{{ $laporan->lokasi }}</div>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="text-secondary text-uppercase fw-semibold mb-2" style="font-size:.7rem;letter-spacing:.5px;">
                        Deskripsi
                    </div>
                    <p class="text-dark small mb-0" style="line-height:1.7;">{{ $laporan->deskripsi }}</p>
                </div>

                {{-- ALASAN MODERASI (kalau ditolak admin) --}}
                @if($laporan->moderation_status === 'rejected' && $laporan->alasan_moderasi)
                    <div class="mt-4 p-3 rounded-3"
                         style="background:#fef2f2;border-left:3px solid #ef4444;">
                        <div class="fw-bold text-uppercase mb-1"
                             style="font-size:.7rem;letter-spacing:.5px;color:#991b1b;">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Ditolak Admin
                        </div>
                        <div class="small" style="color:#991b1b;">{{ $laporan->alasan_moderasi }}</div>
                        @if($laporan->verifier)
                            <div class="small mt-1" style="color:#991b1b;opacity:.7;font-size:.72rem;">
                                oleh {{ $laporan->verifier->name }} • {{ $laporan->verified_at?->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>
                @endif

                {{-- CATATAN STAFF --}}
                @if($laporan->catatan_staff)
                    <div class="mt-4 p-3 rounded-3"
                         style="background:#ecfdf5;border-left:3px solid #059669;">
                        <div class="fw-bold text-uppercase mb-1"
                             style="font-size:.7rem;letter-spacing:.5px;color:#065f46;">
                            <i class="bi bi-chat-left-text-fill me-1"></i> Catatan Staff
                        </div>
                        <div class="small" style="color:#065f46;">{{ $laporan->catatan_staff }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- FOTO BUKTI KERUSAKAN --}}
        @if($laporan->foto_bukti)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-camera-fill text-danger me-1"></i>
                        Foto Bukti Kerusakan
                    </h6>
                    <img src="{{ asset('storage/' . $laporan->foto_bukti) }}"
                         alt="Foto Bukti"
                         class="img-fluid rounded-3 border zoomable">
                </div>
            </div>
        @endif

        {{-- FOTO BUKTI PERBAIKAN --}}
        @if($laporan->foto_perbaikan)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-check-circle-fill text-success me-1"></i>
                        Foto Bukti Perbaikan
                    </h6>
                    <img src="{{ asset('storage/' . $laporan->foto_perbaikan) }}"
                         alt="Foto Perbaikan"
                         class="img-fluid rounded-3 border zoomable">
                </div>
            </div>
        @endif

        {{-- TIMELINE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Riwayat Status</h6>

                @forelse($laporan->statusLogs()->latest()->get() as $log)
                    <div class="d-flex gap-3 pb-3 position-relative">
                        <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                             style="width:32px;height:32px;background:#ecfdf5;color:#059669;font-size:.85rem;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1 pt-1">
                            <div class="fw-semibold small">Status: {{ ucfirst($log->status) }}</div>
                            <div class="text-secondary" style="font-size:.78rem;">{{ $log->keterangan }}</div>
                            <div class="text-secondary" style="font-size:.72rem;">
                                {{ $log->created_at->format('d M Y, H:i') }} •
                                {{ $log->user->name ?? 'Sistem' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary small text-center py-3 mb-0">Belum ada riwayat.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ============================================
         KANAN: PANEL AKSI
         ============================================ --}}
    <div class="col-lg-4">

        {{-- ============================================
             PANEL VERIFIKASI (ADMIN)
             Muncul hanya kalau:
             - User adalah admin
             - Belum diverifikasi
             - Belum diproses staff
             ============================================ --}}
        @if($user->isAdmin() && !$sudahDiverifikasiAdmin && !$sudahDiprosesStaff)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-shield-check text-warning me-1"></i>
                        Verifikasi Laporan
                    </h6>
                    <p class="small text-secondary mb-3">
                        Periksa laporan ini sebelum diteruskan ke Staff.
                    </p>

                    <form method="POST" action="{{ route('admin.verifikasi.proses', $laporan) }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="moderation_status" value="approved">
                        <button type="submit" class="btn btn-success w-100 mb-2 fw-semibold">
                            <i class="bi bi-check-lg"></i> Setujui Laporan
                        </button>
                    </form>

                    <button type="button" class="btn btn-outline-danger w-100 fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#rejectLaporanModal">
                        <i class="bi bi-x-lg"></i> Tolak Laporan
                    </button>
                </div>
            </div>

            {{-- MODAL REJECT --}}
            <div class="modal fade" id="rejectLaporanModal" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.verifikasi.proses', $laporan) }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="moderation_status" value="rejected">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tolak Laporan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label class="form-label small fw-semibold">
                                    Alasan Penolakan <span class="text-danger">*</span>
                                </label>
                                <textarea name="alasan_moderasi" rows="4" class="form-control" required
                                          placeholder="Contoh: Foto blur, kata tidak pantas, laporan tidak jelas..."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak Laporan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- INFO KALAU SUDAH DIPROSES STAFF --}}
        @if($user->isAdmin() && $sudahDiprosesStaff && !$sudahDiverifikasiAdmin)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-info-circle-fill text-info fs-5"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Sudah Diproses Staff</h6>
                            <p class="small text-secondary mb-0">
                                Laporan ini sudah ditangani staff, jadi tidak bisa diverifikasi lagi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ============================================
             PANEL UPDATE STATUS (ADMIN & STAFF)
             ============================================ --}}
        @if($user->isAdmin() || $user->isStaff())
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Update Status</h6>

                    @if($errors->any())
                        <div class="alert alert-danger small">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST"
                          action="{{ route($user->isStaff() ? 'staff.updateStatus' : 'admin.updateStatus', $laporan) }}"
                          enctype="multipart/form-data"
                          id="formUpdate">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Status Baru</label>
                            <select name="status" class="form-select" id="statusSelect" onchange="toggleFotoPerbaikan()">
                                <option value="pending"  {{ $laporan->status == 'pending'  ? 'selected':'' }}>Pending</option>
                                <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected':'' }}>Diproses</option>
                                <option value="selesai"  {{ $laporan->status == 'selesai'  ? 'selected':'' }}>Selesai</option>
                                <option value="ditolak"  {{ $laporan->status == 'ditolak'  ? 'selected':'' }}>Ditolak</option>
                            </select>

                            @if($user->isStaff() && $laporan->status === 'pending')
                                <div class="form-text text-warning-emphasis">
                                    <i class="bi bi-info-circle"></i>
                                    Mengubah ke <strong>Diproses</strong> akan menutup akses verifikasi admin.
                                </div>
                            @endif
                        </div>

                        {{-- FOTO PERBAIKAN: hanya wajib saat status "selesai" --}}
                        <div id="fotoPerbaikanWrap" style="display: {{ $laporan->status == 'selesai' ? 'block' : 'none' }};">
                            @include('partials.camera-input', [
                                'name'         => 'foto_perbaikan',
                                'label'        => 'Foto Bukti Perbaikan',
                                'required'     => false,
                                'existingFoto' => $laporan->foto_perbaikan,
                            ])
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Catatan (Opsional)</label>
                            <textarea name="catatan" rows="4" class="form-control"
                                      placeholder="Catatan untuk pelapor...">{{ $laporan->catatan_staff }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- ============================================
             TOMBOL KOMPLAIN (USER & STAFF)
             ============================================ --}}
        @if($user->isUser() || $user->isStaff())
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                        Ada Masalah?
                    </h6>
                    <p class="small text-secondary mb-3">
                        @if($user->isStaff())
                            Laporkan ke admin jika laporan kurang jelas, foto tidak pantas, atau minta hapus.
                        @else
                            Laporkan ke admin jika penanganan lambat atau ada masalah lain.
                        @endif
                    </p>
                    <a href="{{ route('komplain.create', $laporan) }}"
                       class="btn btn-outline-warning w-100 fw-semibold">
                        <i class="bi bi-send me-1"></i> Buat Komplain
                    </a>
                </div>
            </div>
        @endif

        {{-- ============================================
             INFO BOX UNTUK USER
             ============================================ --}}
        @if($user->isUser())
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-info-circle text-primary me-1"></i>
                        Status Laporan
                    </h6>
                    <p class="text-secondary small mb-0" style="line-height:1.6;">
                        @if($laporan->moderation_status === 'rejected')
                            Laporan Anda ditolak admin.
                            @if($laporan->alasan_moderasi)
                                Alasan: <strong>{{ $laporan->alasan_moderasi }}</strong>
                            @endif
                        @elseif($laporan->status === 'pending')
                            Laporan sudah masuk. Menunggu staff menindaklanjuti.
                        @elseif($laporan->status === 'diproses')
                            Laporan Anda sedang dikerjakan oleh staff.
                        @elseif($laporan->status === 'selesai')
                            Perbaikan sudah selesai! Terima kasih sudah melapor.
                        @elseif($laporan->status === 'ditolak')
                            Laporan Anda ditolak. Hubungi admin untuk info lebih lanjut.
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle foto perbaikan (wajib kalau status = selesai)
    function toggleFotoPerbaikan() {
        const status = document.getElementById('statusSelect');
        if (!status) return;

        const wrap = document.getElementById('fotoPerbaikanWrap');
        const input = wrap ? wrap.querySelector('input[type=file]') : null;

        if (status.value === 'selesai') {
            wrap.style.display = 'block';
            if (input) input.required = true;
        } else {
            wrap.style.display = 'none';
            if (input) input.required = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('statusSelect')) {
            toggleFotoPerbaikan();
        }
    });
</script>
@endpush