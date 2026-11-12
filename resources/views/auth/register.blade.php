@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')

<div class="mb-4 text-center">
    <h3 class="fw-bold mb-2" style="letter-spacing:-.03em; color:var(--c-ink);">Buat Akun Baru</h3>
    <p class="text-secondary small mb-0">Isi data diri Anda. Akun akan aktif setelah disetujui Admin.</p>
</div>

@if(session('info'))
    <div class="alert-soft alert-success" style="background:#eff6ff;color:#1e40af;border-left:3px solid #3b82f6;">
        <i class="bi bi-info-circle-fill"></i>
        <div>{{ session('info') }}</div>
    </div>
@endif

@if($errors->any())
    <div class="alert-soft alert-danger">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ $errors->first() }}</div>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-md-6">
            <label class="form-label">NISN / NIP <span class="text-danger">*</span></label>
            <input type="text" name="nisn_nip" value="{{ old('nisn_nip') }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kelas / Jabatan</label>
            <input type="text" name="kelas" value="{{ old('kelas') }}" class="form-control" placeholder="XII RPL C">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">No. Telepon</label>
        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-control">
    </div>

    <div class="row g-2 mb-3">
        <div class="col-md-6">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Konfirmasi <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">
        Kirim Pengajuan
    </button>
    
    <div class="text-center mt-3">
        <a href="{{ route('check-account') }}" class="text-secondary text-decoration-none" style="font-size:0.85rem;">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Cek Akun
        </a>
    </div>
</form>
@endsection