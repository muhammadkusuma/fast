<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Alumni\DashboardController;
// use App\Http\Controllers\Alumni\ProfilController;
// use App\Http\Controllers\Alumni\TracerController;

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
    // Tracer Study Wizard
    // Route::get('/tracer/isi', function () {
    //     return view('alumni.tracer.wizard');
    //     // Nanti ganti jadi: [TracerController::class, 'create']
    // })->name('tracer.wizard');

    // Nanti tambahkan route POST di sini untuk simpan data
    // Tracer Study
    Route::get('/tracer/isi', [App\Http\Controllers\Alumni\TracerController::class, 'create'])->name('tracer.wizard');

    // TAMBAHKAN INI:
    Route::post('/tracer/simpan', [App\Http\Controllers\Alumni\TracerController::class, 'store'])->name('tracer.store');
});

/*
|--------------------------------------------------------------------------
| 4. AREA ADMIN (Middleware: auth:web)
|--------------------------------------------------------------------------
| Biasanya dihandle oleh Filament, tapi jika mau custom route admin:
*/
Route::middleware(['auth:web'])->prefix('custom-admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return "Halaman Dashboard Admin Custom (Non-Filament)";
    })->name('dashboard');
});
