@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')

@php
    $user = auth()->user();
    // Cek apakah butuh kolom kanan (Staff untuk update, User untuk buat komplain)
    $butuhSidebarKanan = $user->isStaff() || $user->isUser();
@endphp

<div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
    <div>
        <h4>Detail Laporan</h4>
        <p>#{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }} • Dibuat pada {{ $laporan->created_at->format('d M Y, H:i') }}</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-light">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    {{-- KIRI: KONTEN UTAMA (Lebar menyesuaikan role) --}}
    <div class="{{ $butuhSidebarKanan ? 'col-lg-8' : 'col-lg-12' }}">
        <!-- Kartu Info -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-4 flex-wrap">
                    <h4 class="fw-bold mb-0" style="letter-spacing:-.02em;">{{ $laporan->judul }}</h4>
                    <span class="status-badge status-{{ $laporan->status }} px-3 py-2">
                        {{ $laporan->status_badge['label'] }}
                    </span>
                </div>

                {{-- Kotak Pelapor & Lokasi --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 h-100" style="background:#f8fafc;border:1px solid var(--c-border);">
                            <div class="text-muted fw-bold text-uppercase mb-2" style="font-size:.65rem;letter-spacing:.05em;">Pelapor</div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px;height:36px;background:var(--c-primary);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;flex-shrink:0;">
                                    {{ strtoupper(substr($laporan->user->name,0,1)) }}
                                </div>
                                <div class="fw-bold text-dark" style="font-size:.95rem;">{{ $laporan->user->name }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 h-100" style="background:#f8fafc;border:1px solid var(--c-border);">
                            <div class="text-muted fw-bold text-uppercase mb-2" style="font-size:.65rem;letter-spacing:.05em;">Lokasi</div>
                            <div class="fw-bold text-dark d-flex align-items-center gap-2" style="font-size:.95rem;">
                                <i class="bi bi-geo-alt-fill text-danger fs-5"></i> {{ $laporan->lokasi }}
                            </div>
                        </div>
                    </div>
                    
                    {{-- Kotak Ditangani Oleh --}}
                    @if($laporan->staff)
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:#ecfdf5;border:1px solid #a7f3d0;">
                            <div class="text-success fw-bold text-uppercase mb-2" style="font-size:.65rem;letter-spacing:.05em;">Ditangani Oleh</div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px;height:36px;background:#10b981;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;flex-shrink:0;">
                                    {{ strtoupper(substr($laporan->staff->name,0,1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size:.95rem;">{{ $laporan->staff->name }}</div>
                                    <div class="text-muted" style="font-size:.78rem;">
                                        {{ $laporan->staff->jabatan ?? $laporan->staff->roleLabel() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div>
                    <div class="text-muted fw-bold text-uppercase mb-2" style="font-size:.7rem;letter-spacing:.05em;">Deskripsi Kerusakan</div>
                    <p class="text-dark mb-0" style="font-size:.95rem;line-height:1.8;">{{ $laporan->deskripsi }}</p>
                </div>

                @if($laporan->catatan_staff)
                    <div class="mt-4 p-4 rounded-4" style="background:#ecfdf5;border:1px solid #a7f3d0;">
                        <div class="fw-bold text-uppercase mb-2" style="font-size:.7rem;letter-spacing:.05em;color:#047857;">
                            <i class="bi bi-chat-left-text-fill me-1"></i> Catatan Petugas
                        </div>
                        <div style="font-size:.9rem;color:#065f46;line-height:1.6;">{{ $laporan->catatan_staff }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Foto Bukti -->
        @if($laporan->foto_bukti)
            <div class="card mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-camera-fill text-danger me-2"></i> Bukti Kerusakan</h6>
                </div>
                <div class="card-body p-4">
                    <div class="rounded-4 overflow-hidden border" style="background:#f8fafc;">
                        <img src="{{ $laporan->foto_bukti }}" class="w-100 zoomable" style="max-height:500px;object-fit:contain;">
                    </div>
                </div>
            </div>
        @endif

        <!-- Foto Perbaikan -->
        @if($laporan->foto_perbaikan)
            <div class="card mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-check-circle-fill text-success me-2"></i> Bukti Perbaikan</h6>
                </div>
                <div class="card-body p-4">
                    <div class="rounded-4 overflow-hidden border" style="background:#f8fafc;">
                        <img src="{{ $laporan->foto_perbaikan }}" class="w-100 zoomable" style="max-height:500px;object-fit:contain;">
                    </div>
                </div>
            </div>
        @endif

        <!-- TIMELINE MINIMALIS -->
        <div class="card">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0">Riwayat Status</h6>
            </div>
            <div class="card-body p-4 pb-2">
                
                <div style="position: relative;">
                    {{-- Garis Vertikal Dirender Manual --}}
                    <div style="position: absolute; top: 10px; bottom: 0; left: 6px; width: 2px; background: #e2e8f0; z-index: 0;"></div>

                    @forelse($laporan->statusLogs()->latest()->get() as $log)
                        <div style="position: relative; padding-left: 30px; margin-bottom: 25px;">
                            
                            {{-- Titik Bulat (Dot) ditaruh persis di atas garis --}}
                            <div style="position: absolute; left: 1px; top: 4px; width: 12px; height: 12px; background-color: var(--c-primary); border: 2px solid #fff; border-radius: 50%; z-index: 1;"></div>
                            
                            {{-- Konten --}}
                            <div>
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-1">
                                    <span class="fw-bold text-dark" style="font-size:.85rem;">
                                        Status: <span class="text-primary text-capitalize">{{ $log->status }}</span>
                                    </span>
                                    <span class="text-muted" style="font-size:.72rem;">
                                        <i class="bi bi-clock me-1"></i>{{ $log->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                                
                                <div class="text-muted mb-1" style="font-size:.8rem; line-height:1.5;">
                                    {{ $log->keterangan }}
                                </div>
                                
                                <div class="text-muted" style="font-size:.72rem;">
                                    <i class="bi bi-person-fill me-1"></i>{{ $log->user->name ?? 'Sistem' }}
                                    @if($log->user && $log->user->jabatan)
                                        <span class="text-secondary">• {{ $log->user->jabatan }}</span>
                                    @elseif($log->user)
                                        <span class="text-secondary">• {{ $log->user->roleLabel() }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @empty
                        <p class="text-muted small py-3 mb-0" style="margin-left: 30px;">Belum ada riwayat.</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    {{-- KANAN: PANEL AKSI (Hanya dirender jika Staff / User) --}}
    @if($butuhSidebarKanan)
    <div class="col-lg-4">
        @if($user->isStaff())
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">Update Progres</h6>
                    <form method="POST" action="{{ route('staff.updateStatus', $laporan) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size:.75rem;">Status Laporan</label>
                            <select name="status" class="form-select fw-bold" id="statusSelect" onchange="toggleFotoPerbaikan()">
                                <option value="pending"  {{ $laporan->status == 'pending'  ? 'selected':'' }}>🟡 Pending</option>
                                <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected':'' }}>🔵 Diproses</option>
                                <option value="selesai"  {{ $laporan->status == 'selesai'  ? 'selected':'' }}>🟢 Selesai</option>
                                <option value="ditolak"  {{ $laporan->status == 'ditolak'  ? 'selected':'' }}>🔴 Ditolak</option>
                            </select>
                        </div>
                        
                        <div id="fotoPerbaikanWrap" style="display: {{ $laporan->status == 'selesai' ? 'block' : 'none' }};" class="mb-3">
                            @include('partials.camera-input', ['name' => 'foto_perbaikan', 'label' => 'Unggah Bukti Perbaikan', 'required' => false, 'existingFoto' => $laporan->foto_perbaikan])
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size:.75rem;">
                                Catatan Tambahan <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan" rows="3" class="form-control" placeholder="Berikan info update ke pelapor..." required>{{ $laporan->catatan_staff }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        @endif

        @if($user->isUser() || $user->isStaff())
            <div class="card bg-light border-0">
                <div class="card-body p-4 text-center">
                    <div class="mb-3" style="width:50px;height:50px;background:#fef3c7;color:#d97706;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Ada Kendala?</h6>
                    <p class="text-muted small mb-4">Laporkan jika ada masalah atau pengerjaan yang tidak sesuai.</p>
                    <a href="{{ route('komplain.create', $laporan->id) }}" class="btn btn-light w-100 fw-bold text-warning border-warning">
                        <i class="bi bi-send-fill me-1"></i> Buat Komplain
                    </a>
                </div>
            </div>
        @endif
    </div>
    @endif
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