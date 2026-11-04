@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="mb-5">
    <h3 class="fw-bold mb-2" style="letter-spacing:-.03em; color:var(--c-ink);">Selamat Datang Kembali 👋</h3>
    <p class="text-secondary small mb-0">Silakan masuk menggunakan akun sekolah yang sudah diberikan.</p>
</div>

@if(session('success'))
    <div class="alert-soft alert-success" style="background:#ecfdf5;color:#065f46;border-left:3px solid #059669;">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if($errors->any())
    <div class="alert-soft alert-danger">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ $errors->first() }}</div>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label class="form-label">Alamat Email</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="nama@sekolah.com" required autofocus>
        </div>
    </div>

    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label class="form-label mb-0">Password</label>
        </div>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control"
                   placeholder="Masukkan password" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-4">
        Masuk ke Dashboard <i class="bi bi-arrow-right ms-1"></i>
    </button>
</form>

<div class="text-center mt-4">
    <p class="text-secondary" style="font-size: 0.8rem;">
        Belum punya akun? Silakan hubungi <strong>Admin Sekolah</strong> untuk pendaftaran.
    </p>
</div>
@endsection