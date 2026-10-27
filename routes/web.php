<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

// Route terproteksi (Harus Login)
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Redirection Dashboard Utama berdasarkan Role
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        return match ($role) {
            'Admin'    => redirect()->route('admin.dashboard'),
            'Petugas'  => redirect()->route('petugas.dashboard'),
            'Pimpinan' => redirect()->route('pimpinan.dashboard'),
            default    => redirect()->route('peminjam.dashboard'),
        };
    })->name('dashboard');

    // ==========================================
    // 1. AREA ADMIN SARPRAS
    // ==========================================
    Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::patch('/pengajuan/{id}/approve', [AdminController::class, 'approve'])->name('pengajuan.approve');
        Route::patch('/pengajuan/{id}/reject', [AdminController::class, 'reject'])->name('pengajuan.reject');

        // Route Master Data Aset (CRUD)
        Route::get('/aset', [AsetController::class, 'index'])->name('aset.index');
        Route::get('/aset/create', [AsetController::class, 'create'])->name('aset.create');
        Route::post('/aset', [AsetController::class, 'store'])->name('aset.store');
        Route::get('/aset/{id}/edit', [AsetController::class, 'edit'])->name('aset.edit');
        Route::put('/aset/{id}', [AsetController::class, 'update'])->name('aset.update');
        Route::patch('/aset/{id}/toggle-status', [AsetController::class, 'toggleStatus'])->name('aset.toggleStatus');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{id}/toggle-banned', [UserController::class, 'toggleBanned'])->name('users.toggleBanned');
    });
    // ==========================================
    // 2. AREA PETUGAS GUDANG
    // ==========================================
    Route::middleware(['auth', 'role:Petugas'])->prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'index'])->name('dashboard');

        // Serah Terima
        Route::get('/serah-terima/{id}', [PetugasController::class, 'serahTerimaForm'])->name('serah_terima.form');
        Route::post('/serah-terima/{id}', [PetugasController::class, 'processSerahTerima'])->name('serah_terima.process');

        // Pengembalian
        Route::get('/pengembalian/{id}', [PetugasController::class, 'pengembalianForm'])->name('pengembalian.form');
        Route::post('/pengembalian/{id}', [PetugasController::class, 'processPengembalian'])->name('pengembalian.process');
    });

    // ==========================================
    // 3. AREA PEMINJAM (Mahasiswa / Dosen / Staf)
    // ==========================================
    Route::middleware(['auth', 'role:Peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
        Route::get('/dashboard', [PeminjamController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan/create', [PeminjamController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan', [PeminjamController::class, 'store'])->name('pengajuan.store');
        Route::get('/pengajuan/{id}', [PeminjamController::class, 'show'])->name('pengajuan.show');
        Route::delete('/pengajuan/{id}/cancel', [PeminjamController::class, 'cancel'])->name('pengajuan.cancel');
        Route::get('/pelanggaran-saya', [PeminjamController::class, 'pelanggaran'])->name('pelanggaran');
    });

    // ==========================================
    // 4. AREA PIMPINAN
    // ==========================================
    Route::middleware(['auth', 'role:Pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
        Route::get('/dashboard', [PimpinanController::class, 'index'])->name('dashboard');
    });

    // ==========================================
    // ROUTE MULTI-ROLE (Bisa diakses Admin & Petugas)
    // ==========================================
    Route::middleware(['role:Admin,Petugas'])->group(function () {
        // Route yang butuh akses bersama antara Admin dan Petugas
    });
});

require __DIR__ . '/auth.php';
