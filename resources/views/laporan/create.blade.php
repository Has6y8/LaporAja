@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')

<div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
    <div>
        <h4>Buat Laporan Baru</h4>
        <p>Laporkan kerusakan sarana & prasarana dengan detail.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-light">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body p-4">

        {{-- Kotak Peringatan Error (Jika Ada Validasi Gagal) --}}
        @if($errors->any())
            <div class="alert-soft alert-danger mb-4">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" 
                       class="form-control @error('judul') is-invalid @enderror"
                       placeholder="Contoh: AC Rusak di Lab RPL 1" required>
                @error('judul')
                    <div class="text-danger mt-1" style="font-size:.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" 
                       class="form-control @error('lokasi') is-invalid @enderror"
                       placeholder="Contoh: Gedung B, Ruang 204" required>
                @error('lokasi')
                    <div class="text-danger mt-1" style="font-size:.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                <textarea name="deskripsi" rows="5" 
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Jelaskan detail kerusakan yang terjadi..." required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="text-danger mt-1" style="font-size:.75rem;">{{ $message }}</div>
                @enderror
            </div>

            {{-- Komponen Kamera dengan Validasi --}}
            <div class="@error('foto_bukti') border border-danger rounded-3 p-2 @enderror mb-3">
                @include('partials.camera-input', [
                    'name'         => 'foto_bukti',
                    'label'        => 'Foto Bukti Kerusakan',
                    'required'     => true,
                    'existingFoto' => null,
                ])
                @error('foto_bukti')
                    <div class="text-danger mt-2" style="font-size:.75rem;">{{ $message }}</div>
                @enderror
            </div>

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