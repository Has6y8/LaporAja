@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')

<div class="page-header">
    <div>
        <h4>Buat Laporan Baru</h4>
        <p>Laporkan kerusakan sarana & prasarana dengan detail.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-light d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">

        @if($errors->any())
            <div style="padding:.85rem 1rem;border-radius:10px;background:#fef2f2;color:#991b1b;border-left:3px solid #dc2626;font-size:.85rem;margin-bottom:1rem;display:flex;gap:.5rem;align-items:flex-start;">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control"
                       placeholder="Contoh: AC Rusak di Lab RPL 1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="form-control"
                       placeholder="Contoh: Gedung B, Ruang 204" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                <textarea name="deskripsi" rows="5" class="form-control"
                          placeholder="Jelaskan detail kerusakan yang terjadi..." required>{{ old('deskripsi') }}</textarea>
            </div>

            {{-- Komponen Kamera / Upload Foto --}}
            @include('partials.camera-input', [
                'name'         => 'foto_bukti',
                'label'        => 'Foto Bukti Kerusakan',
                'required'     => true,
                'existingFoto' => null,
            ])

            <div class="d-flex gap-2 mt-4 flex-wrap">
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bi bi-send-fill"></i> Kirim Laporan
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection