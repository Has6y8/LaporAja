@extends('layouts.guest')

@section('title', 'Cek Akun')

@section('content')
<div class="mobile-brand-logo">
    <span class="logo-mark"><i class="bi bi-megaphone-fill"></i></span>
    LaporAja
</div>

<div class="mb-4 text-center">
    <h3 class="fw-bold mb-2" style="letter-spacing:-.03em; color:var(--c-ink);">Cek Status Akun</h3>
    <p class="text-secondary small mb-0">Masukkan NISN/NIP atau Nama Anda untuk melihat apakah akun sudah terdaftar.</p>
</div>

{{-- KOTAK JIKA AKUN DITEMUKAN --}}
@if(session('found_user'))
    @php $found = session('found_user'); @endphp
    <div class="card mb-4" style="background:#f8fafc; border:1px solid var(--c-border); box-shadow:none;">
        <div class="card-body text-center p-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-3"
                 style="width:60px;height:60px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-size:1.5rem;">
                {{ strtoupper(substr($found->name, 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $found->name }}</h5>
            <div class="text-muted small mb-3">NISN/NIP: {{ $found->nisn_nip }}</div>
            
            @if($found->status_akun === 'approved')
                <div class="badge" style="background:#d1fae5;color:#065f46;font-size:.8rem;padding:.5rem 1rem;">
                    <i class="bi bi-check-circle-fill me-1"></i> Akun Aktif
                </div>
                <p class="text-muted small mt-3 mb-0">Akun Anda sudah aktif dan bisa digunakan.</p>
            @elseif($found->status_akun === 'pending')
                <div class="badge" style="background:#fef3c7;color:#92400e;font-size:.8rem;padding:.5rem 1rem;">
                    <i class="bi bi-clock-fill me-1"></i> Menunggu Persetujuan
                </div>
                <p class="text-muted small mt-3 mb-0">Akun Anda sedang ditinjau oleh Admin.</p>
            @else
                <div class="badge" style="background:#fee2e2;color:#991b1b;font-size:.8rem;padding:.5rem 1rem;">
                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                </div>
                <p class="text-muted small mt-3 mb-0">Pengajuan akun Anda ditolak oleh Admin.</p>
            @endif
        </div>
    </div>
@endif

{{-- KOTAK JIKA AKUN TIDAK DITEMUKAN (TOMBOL REGISTER MUNCUL DI SINI) --}}
@if(session('not_found'))
    <div class="card mb-4" style="background:#fffbeb; border:1px solid #fde68a; box-shadow:none;">
        <div class="card-body text-center p-4">
            <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" 
                 style="width:60px;height:60px;background:#fef3c7;color:#d97706;font-size:1.8rem;">
                <i class="bi bi-person-x-fill"></i>
            </div>
            <h5 class="fw-bold mb-1" style="color:#92400e;">Akun Tidak Ditemukan</h5>
            <p class="text-muted small mb-3">NISN/NIP atau Nama yang Anda cari belum terdaftar di sistem LaporAja.</p>
            <a href="{{ route('register') }}" class="btn btn-primary w-100">
                Buat Akun Baru <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('check-account.process') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">NISN, NIP, atau Nama Lengkap</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" value="{{ old('search') }}" class="form-control" placeholder="Contoh: 12345678 atau Budi" required autofocus>
        </div>
        @error('search')
            <div class="text-danger mt-1" style="font-size:.75rem;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">
        Cek Akun
    </button>
    
    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-secondary text-decoration-none" style="font-size:0.85rem;">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
        </a>
    </div>
</form>
@endsection