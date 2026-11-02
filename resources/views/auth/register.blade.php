@extends('layouts.guest')

@section('title', 'Pengajuan Akun')

@section('content')
<div>
    <h2>Pengajuan Akun</h2>
    <p class="sub">Isi formulir, tunggu konfirmasi Super Admin.</p>

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
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label">NISN / NIP</label>
                <input type="text" name="nisn_nip" value="{{ old('nisn_nip') }}" class="form-control">
            </div>
            <div class="col-6">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" value="{{ old('kelas') }}" class="form-control" placeholder="XII RPL C">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Alasan / Perihal Pengajuan <span class="text-muted fw-normal">(opsional)</span></label>
            <textarea name="alasan_pengajuan" rows="3" class="form-control"
                      placeholder="Contoh: Butuh akun untuk melaporkan kerusakan di kelas.">{{ old('alasan_pengajuan') }}</textarea>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-6">
                <label class="form-label">Konfirmasi <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="alert-soft alert-info">
            <i class="bi bi-info-circle-fill"></i>
            <div>Akun Anda akan aktif setelah disetujui <strong>Super Admin</strong>.</div>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-semibold">
            <i class="bi bi-send-fill me-1"></i> Kirim Pengajuan
        </button>
    </form>

    <p class="text-center text-secondary small mt-3 mb-0">
        Sudah punya akun? <a href="{{ route('login') }}" class="link-primary">Login</a>
    </p>
</div>
@endsection