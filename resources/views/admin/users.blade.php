@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kelola User</h4>
        <p class="text-secondary mb-0 small">Tambah & kelola akun user/staff.</p>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @forelse($users as $u)
            <div class="d-flex justify-content-between align-items-center gap-3 p-3 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                         style="width:42px;height:42px;background:#ecfdf5;color:#059669;">
                        {{ strtoupper(substr($u->name,0,1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold small">{{ $u->name }}</div>
                        <div class="text-secondary" style="font-size:.78rem;">
                            {{ $u->email }} • <span class="badge text-bg-secondary">{{ $u->roleLabel() }}</span>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                      onsubmit="return confirm('Hapus user {{ $u->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        @empty
            <div class="text-center py-5 text-secondary small">Belum ada user.</div>
        @endforelse
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="text" name="password" class="form-control" required value="password123">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="user">User (Siswa/Guru)</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">NIS/NIP</label>
                            <input type="text" name="nis_nip" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kelas</label>
                            <input type="text" name="kelas" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection