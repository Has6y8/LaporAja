@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

@php $user = auth()->user(); @endphp

<div class="mb-4">
    <h4 class="fw-bold mb-1">Profil Saya</h4>
    <p class="text-secondary mb-0 small">Kelola informasi akun dan keamanan Anda.</p>
</div>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}
    </div>
@endif

<div class="row g-3">
    {{-- KIRI: INFO PROFIL --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">Informasi Pribadi</h6>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ old('email', $user->email) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">NISN / NIP</label>
                            <input type="text" name="nisn_nip" class="form-control" 
                                   value="{{ old('nisn_nip', $user->nisn_nip) }}" placeholder="Opsional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kelas</label>
                            <input type="text" name="kelas" class="form-control" 
                                   value="{{ old('kelas', $user->kelas) }}" placeholder="Contoh: XII RPL C">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" 
                                   value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Opsional">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        {{-- FORM UBAH PASSWORD --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">Ubah Password</h6>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning mt-4 text-white fw-semibold">
                        <i class="bi bi-key me-1"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- KANAN: INFO AKUN --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-3"
                     style="width:80px;height:80px;background:#ecfdf5;color:#059669;font-size:2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <div class="badge text-bg-light mb-3">{{ $user->roleLabel() }}</div>
                
                <hr class="text-secondary opacity-25">
                
                <div class="text-start small">
                    <div class="mb-2">
                        <span class="text-secondary">Status Akun:</span> <br>
                        @if($user->status_akun === 'approved')
                            <span class="text-success fw-bold"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                        @elseif($user->status_akun === 'pending')
                            <span class="text-warning fw-bold"><i class="bi bi-clock-fill"></i> Pending</span>
                        @else
                            <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-secondary">Bergabung:</span> <br>
                        <span class="fw-semibold">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection