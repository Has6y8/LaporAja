@extends('layouts.app')

@section('title', 'Tipe Staff')

@section('content')
<div class="page-header">
    <div>
        <h4>Tipe Staff</h4>
        <p>Kelola klasifikasi staff (Contoh: IT, Bangunan, Kelistrikan).</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTypeModal">
        <i class="bi bi-plus-lg"></i> Tambah Tipe
    </button>
</div>

<div class="card">
    <div class="card-body p-0">
        @forelse($staffTypes as $type)
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <div class="fw-bold text-dark"><i class="bi bi-tag-fill text-primary me-2"></i> {{ $type->name }}</div>
                <form method="POST" action="{{ route('admin.staff-types.destroy', $type->id) }}" onsubmit="return confirm('Hapus tipe ini? Staff yang menggunakan tipe ini akan kehilangan label tipenya.')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-tags"></i></div>
                <div class="empty-title">Belum ada tipe staff</div>
                <div class="empty-desc">Tambahkan tipe baru untuk mengelompokkan staff.</div>
            </div>
        @endforelse
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="addTypeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.staff-types.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tipe Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Nama Tipe (Contoh: IT Support)</label>
                    <input type="text" name="name" class="form-control" required placeholder="Masukkan nama tipe...">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection