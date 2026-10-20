@extends('layouts.app')

@section('title', 'Buat Komplain')

{{-- KODE SAKTI: Memberitahu VS Code agar garis merah $laporan hilang --}}
@php /** @var \App\Models\Laporan $laporan */ @endphp

@section('content')

@php $user = auth()->user(); @endphp

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Buat Komplain</h4>
        <p class="text-secondary mb-0 small">
            @if($user->role === 'staff')
                Komplain ke admin terkait laporan ini (tidak jelas, tidak pantas, dll).
            @else
                Sampaikan keluhan terkait pengerjaan laporan ini ke Admin.
            @endif
        </p>
    </div>
    <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-light d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="small text-secondary mb-1">Laporan:</div>
        <div class="fw-semibold">{{ $laporan->judul }}</div>
        <div class="small text-secondary mt-1">
            Status saat ini:
            <span class="status-badge status-{{ $laporan->status }}">
                {{ $laporan->status_badge['label'] }}
            </span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('komplain.store', $laporan->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold small">
                    Tipe Komplain <span class="text-danger">*</span>
                </label>
                <select name="tipe" class="form-select" required>
                    <option value="">— Pilih Tipe —</option>

                    {{-- OPSI KHUSUS USER (Siswa/Guru) --}}
                    @if($user->role === 'user')
                        <option value="pengerjaan_tidak_sesuai">🛠️ Pengerjaan Tidak Sesuai</option>
                        <option value="lambat_respon">⏳ Respon / Pengerjaan Lambat</option>
                        <option value="lainnya">➕ Lainnya</option>
                    
                    {{-- OPSI KHUSUS STAFF (Teknisi) --}}
                    @elseif($user->role === 'staff')
                        <option value="kurang_jelas">📝 Laporan Kurang Jelas</option>
                        <option value="foto_tidak_pantas">📸 Foto Tidak Pantas</option>
                        <option value="kata_kasar">🤬 Mengandung Kata Kasar</option>
                        <option value="minta_hapus_laporan">🗑️ Minta Hapus Laporan</option>
                        <option value="lainnya">➕ Lainnya</option>
                    @endif
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold small">
                    Isi Komplain <span class="text-danger">*</span>
                </label>
                <textarea name="isi" rows="5" class="form-control" required
                          placeholder="Jelaskan keluhan Anda secara detail...">{{ old('isi') }}</textarea>
            </div>

            @if($user->role === 'staff')
                <div class="alert alert-info small d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        Jika Anda memilih <strong>"Minta Hapus Laporan"</strong>, admin akan memutuskan
                        apakah laporan ini ditolak atau dihapus permanen.
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-send-fill"></i> Kirim Komplain
            </button>
        </form>
    </div>
</div>

@endsection
