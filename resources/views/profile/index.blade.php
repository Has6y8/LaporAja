@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

@php $user = auth()->user(); @endphp

<div class="page-header">
    <div>
        <h4>Profil Saya</h4>
        <p>Kelola informasi akun dan keamanan Anda.</p>
    </div>
</div>

@if($errors->any())
    <div style="padding:.85rem 1rem;border-radius:10px;background:#fef2f2;color:#991b1b;border-left:3px solid #dc2626;font-size:.85rem;margin-bottom:1rem;">
        {{ $errors->first() }}
    </div>
@endif

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-4" style="font-size:.9rem;">Informasi Pribadi</h6>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly style="background:#f8fafc;">
                            <div class="form-text" style="color:#dc2626;">Hubungi Admin untuk mengubah Nama.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        @if($user->role === 'user')
                            @if($user->tipe_user === 'siswa')
                                <div class="col-md-6">
                                    <label class="form-label">NISN</label>
                                    <input type="text" class="form-control" value="{{ $user->nisn_nip }}" readonly style="background:#f8fafc;">
                                    <div class="form-text" style="color:#dc2626;">Hubungi Admin untuk mengubah NISN.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kelas</label>
                                    <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $user->kelas) }}">
                                </div>
                            @else
                                <div class="col-md-6">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control" value="{{ $user->nisn_nip }}" readonly style="background:#f8fafc;">
                                    <div class="form-text" style="color:#dc2626;">Hubungi Admin untuk mengubah NIP.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $user->jabatan) }}">
                                </div>
                            @endif
                        @endif

                        @if(in_array($user->role, ['staff', 'admin', 'super_admin']))
                            <div class="col-md-12">
                                <label class="form-label">NIP Pegawai</label>
                                <input type="text" class="form-control" value="{{ $user->nisn_nip ?? '-' }}" readonly style="background:#f8fafc;">
                                <div class="form-text" style="color:#dc2626;">Hubungi Admin untuk mengubah NIP.</div>
                            </div>
                        @endif

                        <div class="col-md-12">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-4" style="font-size:.9rem;">Ubah Password</h6>
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning mt-4 text-white fw-semibold" style="background:#d97706;border-color:#d97706;">
                        <i class="bi bi-key me-1"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-3"
                     style="width:80px;height:80px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-size:2rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <div class="badge text-bg-light mb-3">{{ $user->roleLabel() }}</div>
                <hr style="opacity:.15;">
                <div class="text-start" style="font-size:.85rem;">
                    <div class="mb-2">
                        <span style="color:var(--c-muted);">Status Akun:</span><br>
                        @if($user->status_akun === 'approved')
                            <span class="fw-bold" style="color:#059669;"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                        @elseif($user->status_akun === 'pending')
                            <span class="fw-bold" style="color:#d97706;"><i class="bi bi-clock-fill"></i> Pending</span>
                        @else
                            <span class="fw-bold" style="color:#dc2626;"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                        @endif
                    </div>
                    <div>
                        <span style="color:var(--c-muted);">Bergabung:</span><br>
                        <span class="fw-semibold">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection