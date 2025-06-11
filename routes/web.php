<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda bisa mendaftarkan web routes untuk aplikasi Anda.
|
*/

Route::redirect('/', 'login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Mengarahkan ke halaman dashboard utama setelah login
    Route::get('/dashboard', function () {
        return view('pages.dashboard.dashboard'); // File view yang sudah kita bersihkan
    })->name('dashboard');

    // Anda bisa menambahkan rute-rute baru Anda di sini
    // contoh: Route::get('/pengguna', [UserController::class, 'index'])->name('users.index');

    Route::fallback(function() {
        return view('pages/utility/404');
    });    
});