@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kelola User</h4>
        <p class="text-secondary mb-0 small">Tambah & kelola akun.</p>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="fw-bold mb-0">Daftar User</h6>
        <span class="badge text-bg-light">{{ $users->count() }} akun</span>
    </div>

    <div class="card-body p-0">
        @forelse($users as $u)
            <div class="d-flex justify-content-between align-items-center gap-3 p-3 border-bottom flex-wrap">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                         style="width:42px;height:42px;background:#ecfdf5;color:#059669;">
                        {{ strtoupper(substr($u->name,0,1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold small">{{ $u->name }}</div>
                        <div class="text-secondary" style="font-size:.78rem;">
                            {{ $u->email }}
                            @if($u->nisn_nip) • NIP/NISN: {{ $u->nisn_nip }} @endif
                            @if($u->kelas) • {{ $u->kelas }} @endif
                            @if($u->jabatan) • {{ $u->jabatan }} @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-center flex-wrap">
                    @if($u->role === 'admin')
                        <span class="badge" style="background:#dbeafe;color:#1e40af;">ADMIN</span>
                    @elseif($u->role === 'staff')
                        <span class="badge" style="background:#e0e7ff;color:#3730a3;">STAFF</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#475569;">{{ strtoupper($u->tipe_user ?? 'USER') }}</span>
                    @endif

                    @if($u->status_akun === 'approved')
                        <span class="badge" style="background:#d1fae5;color:#065f46;"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                    @elseif($u->status_akun === 'pending')
                        <span class="badge" style="background:#fef3c7;color:#92400e;"><i class="bi bi-clock-fill"></i> Pending</span>
                    @else
                        <span class="badge" style="background:#fee2e2;color:#991b1b;"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                    @endif

                    {{-- TOMBOL TOGGLE IZIN (KHUSUS SUPER ADMIN & ROLE ADMIN) --}}
                    @if(auth()->user()->isSuperAdmin() && $u->role === 'admin')
                        <form method="POST" action="{{ route('admin.users.toggle_manage', $u->id) }}" class="d-inline">
                            @csrf @method('PUT')
                            @if($u->can_manage_users)
                                <button type="submit" class="btn btn-sm btn-success" title="Cabut Izin Kelola User">
                                    <i class="bi bi-shield-check"></i> Izin Aktif
                                </button>
                            @else
                                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Beri Izin Kelola User">
                                    <i class="bi bi-shield-slash"></i> Beri Izin
                                </button>
                            @endif
                        </form>
                    @endif

                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUser{{ $u->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus user {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>

            {{-- MODAL EDIT USER --}}
            <div class="modal fade" id="editUser{{ $u->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form method="POST" action="{{ route('admin.users.update', $u->id) }}">
                        @csrf @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User: {{ $u->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ $u->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ $u->email }}" required>
                                    </div>
                                </div>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                                        <select name="role" class="form-select role-select" id="role-{{ $u->id }}" onchange="updateForm('{{ $u->id }}')" required>
                                            <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User</option>
                                            <option value="staff" {{ $u->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                            <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6" id="wrap-status-{{ $u->id }}">
                                        <label class="form-label small fw-semibold">Status <span class="text-danger">*</span></label>
                                        <select name="status_akun" class="form-select" required>
                                            <option value="approved" {{ $u->status_akun === 'approved' ? 'selected' : '' }}>Aktif / Approved</option>
                                            <option value="pending" {{ $u->status_akun === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="rejected" {{ $u->status_akun === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="text-secondary opacity-25 mb-4">

                                <div class="row g-3 mb-3" id="wrap-tipe-{{ $u->id }}">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">Tipe User <span class="text-danger">*</span></label>
                                        <select name="tipe_user" class="form-select" id="tipe-{{ $u->id }}" onchange="updateForm('{{ $u->id }}')">
                                            <option value="siswa" {{ $u->tipe_user === 'siswa' ? 'selected' : '' }}>Siswa</option>
                                            <option value="guru" {{ $u->tipe_user === 'guru' ? 'selected' : '' }}>Guru</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- FORM SISWA --}}
                                <div id="form-siswa-{{ $u->id }}" class="dynamic-form">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">NISN</label>
                                            <input type="text" name="nisn_nip" class="form-control input-siswa" value="{{ $u->nisn_nip }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Kelas</label>
                                            <input type="text" name="kelas" class="form-control input-siswa" value="{{ $u->kelas }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- FORM GURU --}}
                                <div id="form-guru-{{ $u->id }}" class="dynamic-form">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">NIP</label>
                                            <input type="text" name="nisn_nip" class="form-control input-guru" value="{{ $u->nisn_nip }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control input-guru" value="{{ $u->jabatan }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- FORM PEGAWAI (STAFF & ADMIN) --}}
                                <div id="form-pegawai-{{ $u->id }}" class="dynamic-form">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">NIP Pegawai</label>
                                            <input type="text" name="nisn_nip" class="form-control input-pegawai" value="{{ $u->nisn_nip }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-semibold">Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control input-pegawai" value="{{ $u->jabatan }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-semibold">No. Telepon</label>
                                        <input type="text" name="no_telepon" class="form-control" value="{{ $u->no_telepon }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary fw-semibold">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-people display-4 text-secondary opacity-50"></i>
                <p class="text-secondary mt-3 mb-0 small">Belum ada user.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-plus-fill me-1"></i> Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="text" name="password" class="form-control" required value="password123">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select role-select" id="role-add" onchange="updateForm('add')" required>
                                <option value="">— Pilih Role —</option>
                                <option value="user">User</option>
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <hr class="text-secondary opacity-25 mb-4">

                    <div class="row g-3 mb-3" id="wrap-tipe-add">
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">Tipe User <span class="text-danger">*</span></label>
                            <select name="tipe_user" class="form-select" id="tipe-add" onchange="updateForm('add')">
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                            </select>
                        </div>
                    </div>

                    {{-- FORM SISWA ADD --}}
                    <div id="form-siswa-add" class="dynamic-form">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">NISN</label>
                                <input type="text" name="nisn_nip" class="form-control input-siswa">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Kelas</label>
                                <input type="text" name="kelas" class="form-control input-siswa">
                            </div>
                        </div>
                    </div>

                    {{-- FORM GURU ADD --}}
                    <div id="form-guru-add" class="dynamic-form">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">NIP</label>
                                <input type="text" name="nisn_nip" class="form-control input-guru">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control input-guru">
                            </div>
                        </div>
                    </div>

                    {{-- FORM PEGAWAI ADD --}}
                    <div id="form-pegawai-add" class="dynamic-form">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">NIP Pegawai</label>
                                <input type="text" name="nisn_nip" class="form-control input-pegawai">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control input-pegawai">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control">
                        </div>
                    </div>
                    
                    <div id="adminWarning" class="alert alert-warning small mt-3 mb-0 d-none">
                        <i class="bi bi-info-circle-fill"></i> Akun Admin baru menunggu approval Super Admin.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateForm(prefix) {
        const roleEl = document.getElementById('role-' + prefix);
        if (!roleEl) return;
        
        const role = roleEl.value;
        const wrapTipe = document.getElementById('wrap-tipe-' + prefix);
        const wrapStatus = document.getElementById('wrap-status-' + prefix);
        
        document.querySelectorAll(`#form-siswa-${prefix}, #form-guru-${prefix}, #form-pegawai-${prefix}`).forEach(el => el.style.display = 'none');
        document.querySelectorAll(`#form-siswa-${prefix} input, #form-guru-${prefix} input, #form-pegawai-${prefix} input`).forEach(i => i.disabled = true);

        if (role === 'user') {
            if(wrapTipe) wrapTipe.style.display = 'block';
            if(wrapStatus) wrapStatus.style.display = 'block';
            
            const tipe = document.getElementById('tipe-' + prefix).value;
            if (tipe === 'siswa') {
                document.getElementById(`form-siswa-${prefix}`).style.display = 'block';
                document.querySelectorAll(`#form-siswa-${prefix} input`).forEach(i => i.disabled = false);
            } else {
                document.getElementById(`form-guru-${prefix}`).style.display = 'block';
                document.querySelectorAll(`#form-guru-${prefix} input`).forEach(i => i.disabled = false);
            }
        } else if (role === 'staff') {
            if(wrapTipe) wrapTipe.style.display = 'none';
            if(wrapStatus) wrapStatus.style.display = 'none'; 
            document.getElementById(`form-pegawai-${prefix}`).style.display = 'block';
            document.querySelectorAll(`#form-pegawai-${prefix} input`).forEach(i => i.disabled = false);
        } else if (role === 'admin') {
            if(wrapTipe) wrapTipe.style.display = 'none';
            if(wrapStatus) wrapStatus.style.display = 'block';
            document.getElementById(`form-pegawai-${prefix}`).style.display = 'block';
            document.querySelectorAll(`#form-pegawai-${prefix} input`).forEach(i => i.disabled = false);
        } else {
            if(wrapTipe) wrapTipe.style.display = 'none';
            if(wrapStatus) wrapStatus.style.display = 'block';
        }

        if (prefix === 'add') {
            const warning = document.getElementById('adminWarning');
            if (warning) {
                if (role === 'admin') warning.classList.remove('d-none');
                else warning.classList.add('d-none');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateForm('add');
        @foreach($users as $u)
            updateForm('{{ $u->id }}');
        @endforeach
    });
</script>
@endpush
