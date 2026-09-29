@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Buat Laporan Baru</h4>
        <p class="text-secondary mb-0 small">Laporkan kerusakan sarana & prasarana dengan detail.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-light d-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger d-flex align-items-start gap-2 small">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold small">
                    Judul Laporan <span class="text-danger">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                       class="form-control" placeholder="Contoh: AC Rusak di Lab RPL 1" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">
                    Lokasi <span class="text-danger">*</span>
                </label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                       class="form-control" placeholder="Contoh: Gedung B, Ruang 204" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">
                    Deskripsi Kerusakan <span class="text-danger">*</span>
                </label>
                <textarea name="deskripsi" rows="5" class="form-control"
                          placeholder="Jelaskan detail kerusakan yang terjadi..." required>{{ old('deskripsi') }}</textarea>
            </div>

            {{-- KOMPONEN KAMERA --}}
            @include('partials.camera-input', [
                'name'         => 'foto_bukti',
                'label'        => 'Foto Bukti Kerusakan',
                'required'     => true,
                'existingFoto' => null,
            ])

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bi bi-send-fill"></i> Kirim Laporan
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection