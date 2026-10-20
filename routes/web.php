<?php

use App\Http\Controllers\{
    AuthController,
    DashboardController,
    LaporanController,
    AdminController,
    StaffController,
    SuperAdminController,
    KomplainController,
    ProfileController, // <-- Tambahan Profile
};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

// ============ AUTH ============
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// ============ LOGIN REQUIRED ============
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/histori',   [DashboardController::class, 'histori'])->name('histori');

    // ===== PROFIL =====
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ===== USER =====
    Route::middleware('role:user')->group(function () {
        Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/laporan',       [LaporanController::class, 'store'])->name('laporan.store');
    });

    // ===== KOMPLAIN =====
    Route::middleware('role:user,staff')->group(function () {
        Route::get('/laporan/{laporan}/komplain',  [KomplainController::class, 'create'])->name('komplain.create');
        Route::post('/laporan/{laporan}/komplain', [KomplainController::class, 'store'])->name('komplain.store');
        Route::get('/komplain-saya',               [KomplainController::class, 'index'])->name('komplain.index');
    });

    // Detail laporan (semua role)
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');

    // ===== STAFF =====
    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/laporan', [StaffController::class, 'index'])->name('staff.laporan');
        Route::put('/staff/laporan/{laporan}/status', [StaffController::class, 'updateStatus'])->name('staff.updateStatus');
    });

    // ===== ADMIN & SUPER ADMIN =====
    Route::middleware('role:admin,super_admin')->group(function () {
        Route::get('/admin/verifikasi', [AdminController::class, 'verifikasiIndex'])->name('admin.verifikasi');
        Route::put('/admin/verifikasi/{laporan}', [AdminController::class, 'verifikasi'])->name('admin.verifikasi.proses');
        Route::put('/admin/laporan/{laporan}/status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
        Route::get('/admin/komplain', [AdminController::class, 'komplainIndex'])->name('admin.komplain');
        Route::put('/admin/komplain/{komplain}', [AdminController::class, 'komplainRespon'])->name('admin.komplain.respon');
        Route::get('/admin/users', [AdminController::class, 'userIndex'])->name('admin.users');
        Route::post('/admin/users', [AdminController::class, 'userStore'])->name('admin.users.store');
        Route::delete('/admin/users/{user}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');
    });

    // ===== SUPER ADMIN =====
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/super/approvals',      [SuperAdminController::class, 'approvals'])->name('super.approvals');
        Route::put('/super/approve/{user}', [SuperAdminController::class, 'approve'])->name('super.approve');
        Route::put('/super/reject/{user}',  [SuperAdminController::class, 'reject'])->name('super.reject');
    });
});