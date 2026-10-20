@extends('layouts.app')

@section('title', 'Pengajuan Akun')

@section('content')

<div class="mb-4">
    <h4 class="fw-bold mb-1">Pengajuan Akun</h4>
    <p class="text-secondary mb-0 small">
        Setujui atau tolak pengajuan akun baru. Hanya Super Admin yang bisa akses halaman ini.
    </p>
</div>

{{-- ============================================
     PENGAJUAN MENUNGGU KONFIRMASI
     ============================================ --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="fw-bold mb-0">⏳ Menunggu Konfirmasi</h6>
        <span class="badge text-bg-warning">{{ $pendingUsers->count() }} pengajuan</span>
    </div>

    <div class="card-body p-0">
        @forelse($pendingUsers as $u)
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                 style="width:38px;height:38px;background:#fef3c7;color:#92400e;font-size:.9rem;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $u->name }}</div>
                                <div class="small text-secondary">{{ $u->email }}</div>
                            </div>
                        </div>

                        <div class="small text-secondary mt-2 ms-1">
                            @if($u->nisn_nip)
                                <i class="bi bi-card-text me-1"></i> NISN/NIP: {{ $u->nisn_nip }}
                            @endif
                            @if($u->kelas)
                                <span class="ms-3"><i class="bi bi-mortarboard me-1"></i> Kelas: {{ $u->kelas }}</span>
                            @endif
                            @if($u->no_telepon)
                                <span class="ms-3"><i class="bi bi-telephone me-1"></i> {{ $u->no_telepon }}</span>
                            @endif
                        </div>

                        @if($u->alasan_pengajuan)
                            <div class="small mt-2 p-2 rounded" style="background:#f8fafc;border-left:3px solid #94a3b8;">
                                <strong class="text-secondary">Alasan/Perihal:</strong>
                                <div class="text-dark mt-1">{{ $u->alasan_pengajuan }}</div>
                            </div>
                        @endif

                        <div class="small text-secondary mt-2">
                            <i class="bi bi-clock me-1"></i>
                            Diajukan {{ $u->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <form method="POST" action="{{ route('super.approve', $u) }}" class="d-inline">
                        @csrf @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success fw-semibold">
                            <i class="bi bi-check-lg"></i> Setujui
                        </button>
                    </form>
                    <button type="button" class="btn btn-sm btn-outline-danger fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#rejectUser{{ $u->id }}">
                        <i class="bi bi-x-lg"></i> Tolak
                    </button>
                </div>
            </div>

            {{-- MODAL REJECT --}}
            <div class="modal fade" id="rejectUser{{ $u->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('super.reject', $u) }}">
                        @csrf @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tolak Pengajuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="small mb-3">
                                    Tolak pengajuan akun <strong>{{ $u->name }}</strong>?
                                </p>
                                <label class="form-label small fw-semibold">
                                    Catatan Penolakan (opsional)
                                </label>
                                <textarea name="catatan" rows="3" class="form-control"
                                          placeholder="Contoh: Data tidak lengkap, bukan warga sekolah, dll."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-check-circle display-4 text-success opacity-50"></i>
                <p class="text-secondary mt-3 mb-0 small">Tidak ada pengajuan baru.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ============================================
     DAFTAR SEMUA USER
     ============================================ --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="fw-bold mb-0">📋 Daftar Semua User</h6>
        <span class="badge text-bg-light">{{ $allUsers->count() }} akun</span>
    </div>

    <div class="card-body p-0">
        @forelse($allUsers as $u)
            <div class="d-flex justify-content-between align-items-center gap-3 p-3 border-bottom flex-wrap">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                         style="width:38px;height:38px;background:#ecfdf5;color:#059669;font-size:.9rem;flex-shrink:0;">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-semibold small">{{ $u->name }}</div>
                        <div class="small text-secondary">{{ $u->email }}</div>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-center flex-wrap">
                    {{-- ROLE BADGE --}}
                    @if($u->role === 'super_admin')
                        <span class="badge" style="background:#fef3c7;color:#92400e;">SUPER ADMIN</span>
                    @elseif($u->role === 'admin')
                        <span class="badge" style="background:#dbeafe;color:#1e40af;">ADMIN</span>
                    @elseif($u->role === 'staff')
                        <span class="badge" style="background:#e0e7ff;color:#3730a3;">STAFF</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#475569;">USER</span>
                    @endif

                    {{-- STATUS AKUN --}}
                    @if($u->status_akun === 'approved')
                        <span class="badge" style="background:#d1fae5;color:#065f46;">
                            <i class="bi bi-check-circle-fill"></i> Approved
                        </span>
                    @elseif($u->status_akun === 'pending')
                        <span class="badge" style="background:#fef3c7;color:#92400e;">
                            <i class="bi bi-clock-fill"></i> Pending
                        </span>
                    @else
                        <span class="badge" style="background:#fee2e2;color:#991b1b;">
                            <i class="bi bi-x-circle-fill"></i> Rejected
                        </span>
                    @endif
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

@endsection