<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Alumni\TracerController;

// use App\Http\Controllers\Alumni\DashboardController;
// use App\Http\Controllers\Alumni\ProfilController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK (Landing Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. AREA ALUMNI (Middleware: auth:alumni)
|--------------------------------------------------------------------------
| Hanya bisa diakses jika login menggunakan Guard 'alumni'
*/
Route::middleware(['auth:alumni'])->prefix('alumni')->name('alumni.')->group(function () {

    // Dashboard Alumni
    Route::get('/dashboard', [App\Http\Controllers\Alumni\DashboardController::class, 'index'])->name('dashboard');

    // Profil Alumni
    Route::get('/profil', [App\Http\Controllers\Alumni\ProfileController::class, 'index'])->name('profil');
    Route::put('/profil', [App\Http\Controllers\Alumni\ProfileController::class, 'update'])->name('profil.update');

    // === PERBAIKAN DI SINI ===
    // Ubah nama dari 'tracer.wizard' menjadi 'tracer.create'
    Route::get('/tracer/isi', [TracerController::class, 'create'])->name('tracer.create');

    // Route untuk simpan (Store)
    Route::post('/tracer/simpan', [TracerController::class, 'store'])->name('tracer.store');
});

/*
|--------------------------------------------------------------------------
| 4. AREA ADMIN (Middleware: auth:web)
|--------------------------------------------------------------------------
| Biasanya dihandle oleh Filament, tapi jika mau custom route admin:
*/
// Route::middleware(['auth:web'])->prefix('custom-admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', function () {
//         return "Halaman Dashboard Admin Custom (Non-Filament)";
//     })->name('dashboard');
// });

/*
|--------------------------------------------------------------------------
| 4. AREA ADMIN (Middleware: auth:web)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:web'])->prefix('custom-admin')->name('admin.')->group(function () {

    // Dashboard Admin (Lihat Grafik & Pengumuman)
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Simpan Pengumuman
    Route::post('/announcement', [AdminDashboard::class, 'storeAnnouncement'])->name('announcement.store');

    // Hapus Pengumuman
    Route::delete('/announcement/{id}', [AdminDashboard::class, 'deleteAnnouncement'])->name('announcement.delete');
});
