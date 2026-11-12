<?php

use App\Http\Controllers\{
    AuthController,
    DashboardController,
    LaporanController,
    AdminController,
    StaffController,
    SuperAdminController,
    KomplainController,
    ProfileController,
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

// ============ LANDING PAGE ============
Route::get('/', function () {
    $recentReports = \App\Models\Laporan::with('user')->latest()->take(4)->get();
    return view('welcome', compact('recentReports'));
})->name('landing');

// ============ AUTH ============
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Fitur Cek Akun & Register
Route::get('/check-account', [AuthController::class, 'showCheckAccount'])->name('check-account');
Route::post('/check-account', [AuthController::class, 'processCheckAccount'])->name('check-account.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

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

    // ===== PANDUAN (User & Staff) =====
    Route::middleware('role:user,staff')->group(function () {
        Route::get('/panduan', function () {
            return view('panduan.index');
        })->name('panduan');
    });

    // ===== STAFF =====
    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/laporan', [StaffController::class, 'index'])->name('staff.laporan');
        Route::put('/staff/laporan/{laporan}/status', [StaffController::class, 'updateStatus'])->name('staff.updateStatus');
    });

    // ===== ADMIN & SUPER ADMIN =====
    Route::middleware('role:admin,super_admin')->group(function () {
        // Update status laporan khusus Admin sudah dihapus (hanya Staff yang bisa)
        Route::get('/admin/komplain', [AdminController::class, 'komplainIndex'])->name('admin.komplain');
        Route::put('/admin/komplain/{komplain}', [AdminController::class, 'komplainRespon'])->name('admin.komplain.respon');
        
        Route::get('/admin/export-excel', [AdminController::class, 'exportExcel'])->name('admin.export');

        Route::get('/admin/users', [AdminController::class, 'userIndex'])->name('admin.users');
        Route::post('/admin/users', [AdminController::class, 'userStore'])->name('admin.users.store');
        Route::put('/admin/users/{user}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');
        
        Route::get('/admin/approvals',      [SuperAdminController::class, 'approvals'])->name('super.approvals');
        Route::put('/admin/approve/{user}', [SuperAdminController::class, 'approve'])->name('super.approve');
        Route::put('/admin/reject/{user}',  [SuperAdminController::class, 'reject'])->name('super.reject');
    });
});

// ============ RUTE GAMBAR (Storage) ============
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!File::exists($filePath)) { abort(404); }
    return response()->file($filePath);
})->where('path', '.*')->name('storage.local');