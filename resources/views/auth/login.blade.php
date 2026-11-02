@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div>
    <h2>Selamat Datang 👋</h2>
    <p class="sub">Login untuk melanjutkan ke LaporAja</p>

    @if(session('success'))
        <div class="alert-soft alert-success">
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
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="nama@email.com" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control"
                   placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </button>
    </form>

    <p class="text-center text-secondary small mt-3 mb-0">
        Belum punya akun?
        <a href="{{ route('register') }}" class="link-primary">Daftar sekarang</a>
    </p>

    <div class="demo-box">
        <div class="title"><i class="bi bi-key-fill"></i> Akun Demo</div>
        <div class="row-demo">
            <div><b>User:</b> user@laporaja.id</div>
            <div><b>Pass:</b> user123</div>
            <div><b>Staff:</b> staff@laporaja.id</div>
            <div><b>Pass:</b> staff123</div>
            <div><b>Admin:</b> admin@laporaja.id</div>
            <div><b>Pass:</b> admin123</div>
            <div><b>Super:</b> super@laporaja.id</div>
            <div><b>Pass:</b> super123</div>
        </div>
    </div>
</div>
@endsection