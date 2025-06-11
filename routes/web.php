<?php

use Illuminate\Support\Facades\Route;
// Import controller yang akan kita gunakan
use App\Http\Controllers\Admin\DashboardController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda bisa mendaftarkan web routes untuk aplikasi Anda.
|
*/

// Jika pengguna membuka halaman utama, langsung arahkan ke halaman login
Route::redirect('/', 'login');

// Grup untuk semua route yang memerlukan login
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    
    // Langsung definisikan route dashboard di sini
    // URL Final: /dashboard
    // Nama Route Final: dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Diperbaiki: hanya satu titik koma
    
    // Anda bisa menambahkan rute-rute baru Anda di sini
    // contoh: Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');

    // Fallback jika route tidak ditemukan
    Route::fallback(function() {
        return view('pages.utility.404');
    });    
});