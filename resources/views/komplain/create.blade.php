@extends('layouts.app')

@section('title', 'Buat Komplain')

@section('content')

{{-- KODE SAKTI: Memberitahu VS Code agar tidak error garis merah pada variabel $laporan --}}
@php 
    /** @var \App\Models\Laporan $laporan */ 
    $user = auth()->user(); 
@endphp

<div class="page-header">
    <div>
        <h4>Buat Komplain</h4>
        <p>
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

<div class="card mb-3">
    <div class="card-body">
        <div style="font-size:.78rem;color:var(--c-muted);margin-bottom:.25rem;">Laporan:</div>
        <div class="fw-semibold">{{ $laporan->judul }}</div>
        <div style="font-size:.78rem;color:var(--c-muted);margin-top:.35rem;">
            Status saat ini:
            <span class="status-badge status-{{ $laporan->status }} ms-1">
                {{ $laporan->status_badge['label'] }}
            </span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div style="padding:.85rem 1rem;border-radius:10px;background:#fef2f2;color:#991b1b;border-left:3px solid #dc2626;font-size:.85rem;margin-bottom:1rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('komplain.store', $laporan->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tipe Komplain <span class="text-danger">*</span></label>
                <select name="tipe" class="form-select" required>
                    <option value="">— Pilih Tipe —</option>

                    @if($user->role === 'user')
                        <option value="pengerjaan_tidak_sesuai">🛠️ Pengerjaan Tidak Sesuai</option>
                        <option value="lambat_respon">⏳ Respon / Pengerjaan Lambat</option>
                        <option value="lainnya">➕ Lainnya</option>
                    @elseif($user->role === 'staff')
                        <option value="kurang_jelas">📝 Laporan Kurang Jelas</option>
                        <option value="foto_tidak_pantas">📸 Foto Tidak Pantas</option>
                        <option value="kata_kasar">🤬 Mengandung Kata Kasar</option>
                        <option value="minta_hapus_laporan">🗑️ Minta Hapus Laporan</option>
                        <option value="lainnya">➕ Lainnya</option>
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Komplain <span class="text-danger">*</span></label>
                <textarea name="isi" rows="5" class="form-control" required
                          placeholder="Jelaskan keluhan Anda secara detail...">{{ old('isi') }}</textarea>
            </div>

            @if($user->role === 'staff')
                <div class="alert-soft alert-info mb-3" style="padding:.85rem 1rem;border-radius:10px;background:#eff6ff;color:#1e40af;border-left:3px solid #2563eb;font-size:.82rem;display:flex;gap:.55rem;">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        Jika Anda memilih <strong>"Minta Hapus Laporan"</strong>, admin akan memutuskan apakah laporan ini ditolak atau dihapus permanen.
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