@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kelola User</h4>
        <p class="text-secondary mb-0 small">
            Tambah & kelola akun User, Staff, dan Admin.
        </p>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-circle-fill"></i>
        {{ session('error') }}
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
                            @if($u->nisn_nip) • NISN/NIP: {{ $u->nisn_nip }} @endif
                            @if($u->kelas) • {{ $u->kelas }} @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-center flex-wrap">
                    {{-- ROLE BADGE --}}
                    @if($u->role === 'admin')
                        <span class="badge" style="background:#dbeafe;color:#1e40af;">ADMIN</span>
                    @elseif($u->role === 'staff')
                        <span class="badge" style="background:#e0e7ff;color:#3730a3;">STAFF</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#475569;">USER</span>
                    @endif

                    {{-- STATUS AKUN --}}
                    @if($u->status_akun === 'approved')
                        <span class="badge" style="background:#d1fae5;color:#065f46;">
                            <i class="bi bi-check-circle-fill"></i> Aktif
                        </span>
                    @elseif($u->status_akun === 'pending')
                        <span class="badge" style="background:#fef3c7;color:#92400e;">
                            <i class="bi bi-clock-fill"></i> Pending
                        </span>
                    @else
                        <span class="badge" style="background:#fee2e2;color:#991b1b;">
                            <i class="bi bi-x-circle-fill"></i> Ditolak
                        </span>
                    @endif

                    {{-- DELETE BUTTON --}}
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                          onsubmit="return confirm('Hapus user {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
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

{{-- ============================================
     MODAL TAMBAH USER
     ============================================ --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah User Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control" required
                               placeholder="Nama lengkap user">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control" required
                               placeholder="email@laporaja.id">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Password <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="password" class="form-control" required
                               value="password123">
                        <div class="form-text">Default: password123 (bisa diubah nanti oleh user)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Role <span class="text-danger">*</span>
                        </label>
                        <select name="role" class="form-select" id="roleSelect" required>
                            <option value="">— Pilih Role —</option>
                            <option value="user">🧑‍🎓 User (Siswa/Guru)</option>
                            <option value="staff">🔧 Staff (Teknisi Sarpras)</option>
                            <option value="admin">🛡️ Admin (Supervisor)</option>
                        </select>

                        {{-- Warning khusus admin --}}
                        <div id="adminWarning" class="alert alert-warning small mt-2 mb-0 d-none">
                            <i class="bi bi-info-circle-fill"></i>
                            <strong>Perhatian:</strong> Akun Admin baru akan <strong>menunggu approval Super Admin</strong>
                            sebelum bisa login.
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">NISN / NIP</label>
                            <input type="text" name="nisn_nip" class="form-control"
                                   placeholder="Opsional">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kelas</label>
                            <input type="text" name="kelas" class="form-control"
                                   placeholder="XII RPL C">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Tampilkan warning saat admin dipilih
    document.getElementById('roleSelect')?.addEventListener('change', function () {
        const warning = document.getElementById('adminWarning');
        if (this.value === 'admin') {
            warning.classList.remove('d-none');
        } else {
            warning.classList.add('d-none');
        }
    });
</script>
@endpush