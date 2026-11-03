@extends('layouts.app')

@section('title', 'Pengajuan Akun')

@section('content')

<div class="page-header">
    <div>
        <h4>Pengajuan Akun</h4>
        <p>Setujui atau tolak pengajuan akun baru.</p>
    </div>
</div>

{{-- PENGAJUAN --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0" style="font-size:.9rem;">⏳ Menunggu Konfirmasi</h6>
        <span class="badge" style="background:#fef3c7;color:#92400e;">{{ $pendingUsers->count() }} pengajuan</span>
    </div>

    <div class="card-body p-0">
        @forelse($pendingUsers as $u)
            <div class="p-3" style="border-bottom:1px solid var(--c-border);">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                 style="width:38px;height:38px;background:#fef3c7;color:#92400e;font-size:.9rem;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:.9rem;">{{ $u->name }}</div>
                                <div style="font-size:.78rem;color:var(--c-muted);">{{ $u->email }}</div>
                            </div>
                        </div>

                        <div class="mt-2" style="font-size:.78rem;color:var(--c-muted);">
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
                            <div class="mt-2 p-2 rounded" style="background:#f8fafc;border-left:3px solid #94a3b8;font-size:.78rem;">
                                <strong style="color:var(--c-muted);">Alasan/Perihal:</strong>
                                <div class="mt-1">{{ $u->alasan_pengajuan }}</div>
                            </div>
                        @endif

                        <div class="mt-2" style="font-size:.78rem;color:var(--c-muted);">
                            <i class="bi bi-clock me-1"></i> Diajukan {{ $u->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <form method="POST" action="{{ route('super.approve', $u) }}" class="d-inline">
                        @csrf @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary fw-semibold">
                            <i class="bi bi-check-lg"></i> Setujui
                        </button>
                    </form>
                    <button type="button" class="btn btn-sm btn-light fw-semibold" style="color:#dc2626;border-color:#fca5a5;"
                            data-bs-toggle="modal" data-bs-target="#rejectUser{{ $u->id }}">
                        <i class="bi bi-x-lg"></i> Tolak
                    </button>
                </div>
            </div>

            <div class="modal fade" id="rejectUser{{ $u->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form method="POST" action="{{ route('super.reject', $u) }}">
                        @csrf @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tolak Pengajuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p style="font-size:.85rem;">Tolak pengajuan akun <strong>{{ $u->name }}</strong>?</p>
                                <label class="form-label">Catatan Penolakan (opsional)</label>
                                <textarea name="catatan" rows="3" class="form-control"
                                          placeholder="Contoh: Data tidak lengkap, bukan warga sekolah, dll."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger" style="background:#dc2626;border-color:#dc2626;">Tolak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon" style="background:#d1fae5;color:#059669;"><i class="bi bi-check-circle"></i></div>
                <div class="empty-title">Tidak ada pengajuan baru</div>
                <div class="empty-desc">Pengajuan akun akan tampil di sini.</div>
            </div>
        @endforelse
    </div>
</div>

{{-- SEMUA USER --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0" style="font-size:.9rem;">📋 Daftar Semua User</h6>
        <span class="badge text-bg-light">{{ $allUsers->count() }} akun</span>
    </div>

    <div class="card-body p-0">
        @forelse($allUsers as $u)
            <div class="d-flex justify-content-between align-items-center gap-3 p-3 flex-wrap" style="border-bottom:1px solid var(--c-border);">
                <div class="d-flex align-items-center gap-3" style="min-width:0;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                         style="width:38px;height:38px;background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-size:.9rem;">
                        {{ strtoupper(substr($u->name, 0, 1)) }}
                    </div>
                    <div style="min-width:0;">
                        <div class="fw-semibold" style="font-size:.85rem;">{{ $u->name }}</div>
                        <div style="font-size:.75rem;color:var(--c-muted);">{{ $u->email }}</div>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-center flex-wrap">
                    @if($u->role === 'admin')
                        <span class="badge" style="background:#dbeafe;color:#1e40af;">ADMIN</span>
                    @elseif($u->role === 'staff')
                        <span class="badge" style="background:#e0e7ff;color:#3730a3;">STAFF</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#475569;">USER</span>
                    @endif

                    @if($u->status_akun === 'approved')
                        <span class="badge" style="background:#d1fae5;color:#065f46;"><i class="bi bi-check-circle-fill"></i> Approved</span>
                    @elseif($u->status_akun === 'pending')
                        <span class="badge" style="background:#fef3c7;color:#92400e;"><i class="bi bi-clock-fill"></i> Pending</span>
                    @else
                        <span class="badge" style="background:#fee2e2;color:#991b1b;"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-people"></i></div>
                <div class="empty-title">Belum ada user</div>
                <div class="empty-desc">User yang terdaftar akan tampil di sini.</div>
            </div>
        @endforelse
    </div>
</div>

@endsection