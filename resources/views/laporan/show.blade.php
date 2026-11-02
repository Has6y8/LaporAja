@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')

@php
    $user = auth()->user();
    $sudahDiprosesStaff = $laporan->status !== 'pending';
@endphp

<div class="page-header">
    <div>
        <h4>Detail Laporan</h4>
        <p>#{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }} • {{ $laporan->created_at->format('d M Y, H:i') }}</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-light d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-3">
    {{-- KIRI --}}
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-3 flex-wrap">
                    <h5 class="fw-bold mb-0" style="font-size:1.1rem;">{{ $laporan->judul }}</h5>
                    <span class="status-badge status-{{ $laporan->status }}">
                        {{ $laporan->status_badge['label'] }}
                    </span>
                </div>

                <div class="row g-3 pb-3 mb-3" style="border-bottom:1px solid var(--c-border);">
                    <div class="col-md-6">
                        <div class="text-uppercase fw-semibold" style="font-size:.68rem;letter-spacing:.06em;color:var(--c-muted);">Pelapor</div>
                        <div class="fw-semibold mt-1" style="font-size:.9rem;">{{ $laporan->user->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-uppercase fw-semibold" style="font-size:.68rem;letter-spacing:.06em;color:var(--c-muted);">Lokasi</div>
                        <div class="fw-semibold mt-1" style="font-size:.9rem;">{{ $laporan->lokasi }}</div>
                    </div>
                </div>

                <div>
                    <div class="text-uppercase fw-semibold mb-2" style="font-size:.68rem;letter-spacing:.06em;color:var(--c-muted);">Deskripsi</div>
                    <p class="mb-0" style="font-size:.9rem;line-height:1.7;color:var(--c-ink-2);">{{ $laporan->deskripsi }}</p>
                </div>

                @if($laporan->catatan_staff)
                    <div class="mt-4 p-3 rounded-3" style="background:var(--c-soft);border-left:3px solid var(--c-primary);">
                        <div class="fw-bold text-uppercase mb-1" style="font-size:.68rem;letter-spacing:.06em;color:#065f46;">
                            <i class="bi bi-chat-left-text-fill me-1"></i> Catatan Staff
                        </div>
                        <div style="font-size:.85rem;color:#065f46;">{{ $laporan->catatan_staff }}</div>
                    </div>
                @endif
            </div>
        </div>

        @if($laporan->foto_bukti)
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="font-size:.9rem;"><i class="bi bi-camera-fill text-danger me-1"></i> Foto Bukti Kerusakan</h6>
                    <img src="{{ asset('storage/' . $laporan->foto_bukti) }}" class="img-fluid rounded-3 border zoomable">
                </div>
            </div>
        @endif

        @if($laporan->foto_perbaikan)
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="font-size:.9rem;"><i class="bi bi-check-circle-fill text-success me-1"></i> Foto Bukti Perbaikan</h6>
                    <img src="{{ asset('storage/' . $laporan->foto_perbaikan) }}" class="img-fluid rounded-3 border zoomable">
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3" style="font-size:.9rem;">Riwayat Status</h6>
                @forelse($laporan->statusLogs()->latest()->get() as $log)
                    <div class="d-flex gap-3 pb-3">
                        <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle"
                             style="width:32px;height:32px;background:var(--c-soft);color:var(--c-primary);font-size:.85rem;flex-shrink:0;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1 pt-1" style="min-width:0;">
                            <div class="fw-semibold" style="font-size:.85rem;">Status: {{ ucfirst($log->status) }}</div>
                            <div style="font-size:.78rem;color:var(--c-muted);">{{ $log->keterangan }}</div>
                            <div style="font-size:.72rem;color:var(--c-muted);">
                                {{ $log->created_at->format('d M Y, H:i') }} • {{ $log->user->name ?? 'Sistem' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-3 mb-0" style="font-size:.85rem;color:var(--c-muted);">Belum ada riwayat.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- KANAN --}}
    <div class="col-lg-4">
        @if($user->isAdmin() || $user->isStaff())
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="font-size:.9rem;">Update Status</h6>
                    <form method="POST" action="{{ route($user->isStaff() ? 'staff.updateStatus' : 'admin.updateStatus', $laporan) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Status Baru</label>
                            <select name="status" class="form-select" id="statusSelect" onchange="toggleFotoPerbaikan()">
                                <option value="pending"  {{ $laporan->status == 'pending'  ? 'selected':'' }}>Pending</option>
                                <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected':'' }}>Diproses</option>
                                <option value="selesai"  {{ $laporan->status == 'selesai'  ? 'selected':'' }}>Selesai</option>
                                <option value="ditolak"  {{ $laporan->status == 'ditolak'  ? 'selected':'' }}>Ditolak</option>
                            </select>
                        </div>
                        <div id="fotoPerbaikanWrap" style="display: {{ $laporan->status == 'selesai' ? 'block' : 'none' }};">
                            @include('partials.camera-input', ['name' => 'foto_perbaikan', 'label' => 'Foto Bukti Perbaikan', 'required' => false, 'existingFoto' => $laporan->foto_perbaikan])
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" rows="4" class="form-control" placeholder="Catatan untuk pelapor...">{{ $laporan->catatan_staff }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        @endif

        @if($user->isUser() || $user->isStaff())
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-2" style="font-size:.9rem;"><i class="bi bi-exclamation-triangle text-warning me-1"></i> Ada Masalah?</h6>
                    <p class="mb-3" style="font-size:.85rem;color:var(--c-muted);">
                        @if($user->isStaff())
                            Laporkan ke admin jika laporan kurang jelas, foto tidak pantas, atau minta hapus.
                        @else
                            Laporkan ke admin jika penanganan lambat atau ada masalah lain.
                        @endif
                    </p>
                    <a href="{{ route('komplain.create', $laporan->id) }}" class="btn btn-light w-100 fw-semibold border-warning" style="color:#d97706;border-color:#fcd34d;">
                        <i class="bi bi-send me-1"></i> Buat Komplain
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    function toggleFotoPerbaikan() {
        const status = document.getElementById('statusSelect');
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
</script>
@endpush