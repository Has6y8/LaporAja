@extends('layouts.app')

@section('title', 'Panduan Penggunaan')

@section('content')

@php $user = auth()->user(); @endphp

<div class="page-header">
    <div>
        <h4>Panduan Penggunaan</h4>
        <p>Ikuti langkah-langkah di bawah ini untuk menggunakan aplikasi LaporAja.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        
        {{-- PANDUAN UNTUK USER --}}
        @if($user->isUser())
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color:var(--c-primary);"><i class="bi bi-person-fill me-2"></i> Panduan untuk Siswa / Guru (User)</h5>
                    
                    <div class="d-flex gap-3 mb-3">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">1</div>
                        <div>
                            <div class="fw-bold text-dark">Cara Membuat Laporan</div>
                            <p class="text-muted small mb-0">Buka menu <b>Buat Laporan</b> di sidebar. Isi judul, lokasi, dan deskripsi kerusakan. Jangan lupa ambil foto bukti dengan mengklik tombol <b>Buka Kamera</b>, lalu klik <b>Kirim Laporan</b>.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">2</div>
                        <div>
                            <div class="fw-bold text-dark">Memantau Status Laporan</div>
                            <p class="text-muted small mb-0">Di halaman <b>Dashboard</b>, Anda bisa melihat status laporan (Pending, Diproses, Selesai). Klik pada laporan untuk melihat catatan dari Petugas beserta foto bukti perbaikannya.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">3</div>
                        <div>
                            <div class="fw-bold text-dark">Cara Komplain</div>
                            <p class="text-muted small mb-0">Jika perbaikan dirasa terlalu lambat atau tidak sesuai, buka Detail Laporan, lalu klik tombol <b>Buat Komplain</b> di panel kanan/bawah. Pilih tipe komplain, tulis keluhan, dan kirim. Balasan Admin dapat dilihat di menu <b>Komplain Saya</b>.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- PANDUAN UNTUK STAFF --}}
        @if($user->isStaff())
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color:var(--c-primary);"><i class="bi bi-tools me-2"></i> Panduan untuk Petugas Sarpras (Staff)</h5>
                    
                    <div class="d-flex gap-3 mb-3">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">1</div>
                        <div>
                            <div class="fw-bold text-dark">Melihat Tugas</div>
                            <p class="text-muted small mb-0">Buka menu <b>Tugas Laporan</b> di sidebar. Halaman ini menampilkan daftar laporan dari user yang berstatus <i>Pending</i> atau sedang <i>Diproses</i>.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">2</div>
                        <div>
                            <div class="fw-bold text-dark">Memperbarui Status Laporan</div>
                            <p class="text-muted small mb-0">Buka Detail Laporan. Pada panel <b>Update Progres</b>, ubah status menjadi <i>Diproses</i>. Wajib isi <b>Catatan Tambahan</b> agar pelapor tahu progresnya.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px;height:32px;">3</div>
                        <div>
                            <div class="fw-bold text-dark">Menyelesaikan Laporan</div>
                            <p class="text-muted small mb-0">Jika perbaikan telah selesai, ubah status menjadi <b>Selesai</b>. Sistem akan memunculkan kolom baru. Anda <b>diwajibkan</b> mengunggah foto bukti perbaikan sebelum bisa menyimpan.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- SIDEBAR BANTUAN --}}
    <div class="col-lg-4">
        <div class="card bg-light border-0">
            <div class="card-body p-4 text-center">
                <div class="mb-3" style="width:60px;height:60px;background:#e0f2fe;color:#0284c7;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:2rem;">
                    <i class="bi bi-headset"></i>
                </div>
                <h6 class="fw-bold mb-2">Butuh Bantuan Lain?</h6>
                <p class="text-muted small mb-0">Jika Anda mengalami kendala teknis pada sistem yang tidak dijelaskan di panduan ini, silakan hubungi Admin Sekolah secara langsung.</p>
            </div>
        </div>
    </div>
</div>

@endsection