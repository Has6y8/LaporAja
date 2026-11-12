<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#059669">
    <title>LaporAja — Sistem Pelaporan Sarana Sekolah</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --c-primary: #059669;
            --c-primary-dark: #047857;
            --c-deep: #064e3b;
            --c-soft: #ecfdf5;
            --c-ink: #0f172a;
            --c-muted: #64748b;
            --c-bg: #f4f6f8;
        }
        * { font-family: 'Inter', system-ui, sans-serif; -webkit-tap-highlight-color: transparent; }
        
        body { 
            background-color: var(--c-bg); 
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 24px 24px;
            color: var(--c-ink); 
            overflow-x: hidden; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid #e2e8f0; padding: 1rem 0; transition: all 0.3s; }
        .navbar-brand { font-weight: 800; font-size: 1.35rem; color: var(--c-deep); display: flex; align-items: center; gap: 0.5rem; letter-spacing: -0.03em; }
        .navbar-brand i { color: var(--c-primary); }
        
        .btn-primary { background: var(--c-primary); border-color: var(--c-primary); font-weight: 600; padding: 0.6rem 1.5rem; border-radius: 10px; transition: all 0.2s; color:#fff; text-decoration:none; }
        .btn-primary:hover { background: var(--c-primary-dark); border-color: var(--c-primary-dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(5,150,105,.25); color:#fff; }
        .btn-outline { border: 2px solid #cbd5e1; color: var(--c-ink); font-weight: 600; padding: 0.6rem 1.5rem; border-radius: 10px; transition: all 0.2s; background: #fff; text-decoration:none; }
        .btn-outline:hover { border-color: var(--c-primary); color: var(--c-primary); background: var(--c-soft); }

        /* HERO SECTION */
        .hero { padding: 3.5rem 0 4rem; position: relative; flex: 1; }
        .hero h1 { font-size: 3.2rem; font-weight: 800; line-height: 1.15; letter-spacing: -0.04em; margin-bottom: 1.5rem; color: var(--c-deep); }
        .hero h1 span { color: var(--c-primary); }
        .hero p { font-size: 1.1rem; color: var(--c-muted); max-width: 90%; margin-bottom: 2rem; line-height: 1.7; }
        
        /* Gambar Hero + Efek Melayang */
        .hero-image-wrapper { position: relative; padding: 10px; margin-left: 1rem; }
        .hero-img { border-radius: 24px; box-shadow: 0 20px 40px rgba(6, 78, 59, 0.15); width: 100%; object-fit: cover; border: 4px solid #fff; }
        
        /* Kartu Melayang */
        .floating-card {
            position: absolute; bottom: 30px; left: -30px;
            background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);
            padding: 1.25rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 1rem; z-index: 2;
        }
        
        @media (max-width: 991px) { 
            .hero { padding: 2.5rem 0 3rem; text-align: center; }
            .hero h1 { font-size: 2.5rem; }
            .hero p { margin: 0 auto 2rem; max-width: 100%; }
            .hero-image-wrapper { margin-left: 0; margin-top: 2rem; }
            .floating-card { left: 10px; bottom: 10px; padding: 1rem; } 
        }

        /* SECTION TITLE */
        .section-title { font-weight: 800; font-size: 2.2rem; letter-spacing: -0.03em; color: var(--c-deep); margin-bottom: 0.5rem; }
        .section-desc { color: var(--c-muted); font-size: 1rem; margin-bottom: 3rem; }

        /* KARTU FITUR */
        .feature-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 2rem; height: 100%; transition: all 0.3s; position: relative; overflow: hidden; z-index: 1; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(15,23,42,.06); border-color: #a7f3d0; }
        .feature-icon { width: 56px; height: 56px; background: var(--c-soft); color: var(--c-primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 1.5rem; }
        
        /* LAPORAN TERBARU */
        .report-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 1.25rem; transition: all 0.2s; display: flex; align-items: flex-start; gap: 1rem; text-decoration: none; color: inherit; }
        .report-card:hover { border-color: var(--c-primary); background: #f8fafc; transform: translateX(4px); }
        .report-icon { width: 45px; height: 45px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: var(--c-primary); flex-shrink: 0; }
        
        /* BADGE STATUS */
        .status-pending  { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .status-diproses { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .status-selesai  { background: #d1fae5; color: #047857; border: 1px solid #a7f3d0; }
        .status-ditolak  { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        /* ========== FOOTER ========== */
        .footer-new { background: #064e3b; color: #fff; padding: 4rem 0 1.5rem; margin-top: auto; }
        .footer-title { font-weight: 800; font-size: 1.35rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
        .footer-title i { color: #10b981; }
        .footer-desc { font-size: 0.9rem; color: rgba(255,255,255,0.7); line-height: 1.6; margin-bottom: 1.5rem; }
        .footer-heading { font-weight: 700; font-size: 1rem; margin-bottom: 1.25rem; color: #10b981; text-transform: uppercase; letter-spacing: 0.05em; }
        .footer-info { display: flex; gap: 0.75rem; margin-bottom: 1rem; font-size: 0.9rem; color: rgba(255,255,255,0.8); }
        .footer-info i { color: #10b981; font-size: 1.1rem; margin-top: 2px; }
        .footer-link { display: block; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.9rem; margin-bottom: 0.75rem; transition: color 0.2s; }
        .footer-link:hover { color: #10b981; padding-left: 5px; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem; margin-top: 3rem; text-align: center; font-size: 0.85rem; color: rgba(255,255,255,0.5); }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <i class="bi bi-megaphone-fill"></i> LaporAja
            </a>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Masuk <i class="bi bi-box-arrow-in-right ms-1"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <div class="badge bg-white text-success border px-3 py-2 rounded-pill mb-3 fw-bold shadow-sm">
                        <i class="bi bi-stars text-warning me-1"></i> Platform Sarana Sekolah
                    </div>
                    <h1>Laporkan Kerusakan <br><span>Sekolah</span> dengan Mudah</h1>
                    <p>Sistem pengaduan sarana & prasarana modern. Sampaikan keluhan Anda, pantau status perbaikan secara <i>real-time</i>, dan lihat riwayat penanganannya.</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">
                            Mulai Melapor <i class="bi bi-arrow-up-right ms-1"></i>
                        </a>
                        <a href="#laporan-terbaru" class="btn btn-outline btn-lg px-4">Laporan Terbaru</a>
                    </div>
                </div>
                
                <div class="col-lg-5">
                    <div class="hero-image-wrapper">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReSw_vM67L7OxWZt3L59-G27v-_L0i_7IhHkwaFDeK7w&s=10" alt="Sekolah" class="hero-img">
                        
                        <div class="floating-card">
                            <div style="width:48px;height:48px;background:#ecfdf5;color:#059669;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <div class="fw-bold fs-5" style="line-height:1;">100%</div>
                                <div class="text-muted" style="font-size:0.8rem;">Laporan Terpantau</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LAPORAN TERBARU -->
    <section id="laporan-terbaru" class="py-5 bg-white border-top border-bottom">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="section-title">Laporan Terbaru</h2>
                    <p class="section-desc mb-0">Pantau kerusakan apa saja yang baru saja dilaporkan.</p>
                </div>
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm d-none d-md-block">Lihat Semua</a>
            </div>
            
            <div class="row g-3">
                @forelse($recentReports as $report)
                    <div class="col-md-6">
                        <div class="report-card">
                            <div class="report-icon">
                                @if($report->status == 'selesai')
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @elseif($report->status == 'diproses')
                                    <i class="bi bi-tools text-primary"></i>
                                @else
                                    <i class="bi bi-hourglass-split text-warning"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="fw-bold text-dark text-truncate mb-1" style="font-size:1rem;">{{ $report->judul }}</div>
                                <div class="text-muted mb-2" style="font-size:0.8rem;">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $report->lokasi }}
                                </div>
                                <span class="badge status-{{ $report->status }} px-2 py-1" style="font-size:0.7rem;">
                                    {{ $report->status_badge['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-1 mb-2 d-block opacity-50"></i>
                        Belum ada laporan terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FITUR SECTION -->
    <section class="py-5">
        <div class="container py-4">
            <div class="text-center">
                <h2 class="section-title">Kenapa Harus LaporAja?</h2>
                <p class="section-desc">Dirancang untuk mempermudah komunikasi antara siswa, guru, dan petugas sarana sekolah.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-camera-fill"></i></div>
                        <h5 class="fw-bold">Lapor & Lampirkan Bukti</h5>
                        <p class="text-muted small">Ambil foto kerusakan langsung dari kamera perangkat Anda. Data tersimpan dengan aman dan cepat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <h5 class="fw-bold">Pantau Progres</h5>
                        <p class="text-muted small">Lihat status laporan Anda (Pending, Diproses, Selesai) dan baca catatan penanganan secara transparan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-clock-history"></i></div>
                        <h5 class="fw-bold">Riwayat Rapi</h5>
                        <p class="text-muted small">Semua laporan yang sudah selesai atau ditolak tersimpan dalam halaman histori yang mudah diakses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer-new">
        <div class="container">
            <div class="row g-4">
                <!-- Kolom 1: Brand & Deskripsi -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-title">
                        <i class="bi bi-megaphone-fill"></i> LaporAja
                    </div>
                    <p class="footer-desc">
                        Sistem Pelaporan Sarana & Prasarana Sekolah. Membantu siswa dan guru melaporkan kerusakan fasilitas secara cepat, transparan, dan terpantau.
                    </p>
                </div>

                <!-- Kolom 2: Info Sekolah -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-heading">Informasi Sekolah</h5>
                    <div class="footer-info">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <strong>SMK Negeri 5 Surakarta</strong><br>
                            Jl. Mayjen Sutoyo No. 76, Kec. Banjarsari,<br>
                            Kota Surakarta, Jawa Tengah 57135
                        </div>
                    </div>
                    <div class="footer-info">
                        <i class="bi bi-telephone-fill"></i>
                        <div>(0271) 852547</div>
                    </div>
                    <div class="footer-info">
                        <i class="bi bi-envelope-fill"></i>
                        <div>info@smkn5surakarta.sch.id</div>
                    </div>
                </div>

                <!-- Kolom 3: Tautan Penting -->
                <div class="col-lg-4 col-md-12">
                    <h5 class="footer-heading">Tautan Penting</h5>
                    <a href="{{ route('landing') }}" class="footer-link"><i class="bi bi-chevron-right small me-2"></i> Beranda</a>
                    <a href="{{ route('login') }}" class="footer-link"><i class="bi bi-chevron-right small me-2"></i> Masuk Aplikasi</a>
                    <a href="{{ route('check-account') }}" class="footer-link"><i class="bi bi-chevron-right small me-2"></i> Cek Status Akun</a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-bottom">
                &copy; {{ date('Y') }} LaporAja. Hak Cipta Dilindungi. Dibuat sebagai Proyek Akhir Pembelajaran SMK Negeri 5 Surakarta.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>