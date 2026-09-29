@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Selamat Datang 👋</h2>
    <p class="text-secondary mb-0">Login untuk melanjutkan ke LaporAja</p>
</div>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-start gap-2 small">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger d-flex align-items-start gap-2 small">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ $errors->first() }}</div>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label fw-semibold small text-dark">Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="nama@email.com" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold small text-dark">Password</label>
        <input type="password" name="password" class="form-control"
               placeholder="Masukkan password" required>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
        <i class="bi bi-box-arrow-in-right me-1"></i> Login
    </button>
</form>

<p class="text-center text-secondary small mt-3 mb-0">
    Belum punya akun?
    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#059669;">
        Daftar sekarang
    </a>
</p>

<div class="mt-4 p-3 rounded-3" style="background:#f0fdf4;border-left:3px solid #059669;">
    <div class="small fw-bold mb-2" style="color:#059669;">
        <i class="bi bi-key-fill me-1"></i> Akun Demo
    </div>
    <div class="row g-2 small" style="font-size:.78rem;">
        <div class="col-6"><b>User:</b> user@laporaja.id</div>
        <div class="col-6"><b>Pass:</b> user123</div>
        <div class="col-6"><b>Staff:</b> staff@laporaja.id</div>
        <div class="col-6"><b>Pass:</b> staff123</div>
        <div class="col-6"><b>Admin:</b> admin@laporaja.id</div>
        <div class="col-6"><b>Pass:</b> admin123</div>
        <div class="col-6"><b>Super:</b> super@laporaja.id</div>
        <div class="col-6"><b>Pass:</b> super123</div>
    </div>
</div>
@endsection