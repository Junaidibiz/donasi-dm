<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrixUploadController;
use App\Http\Controllers\ExpenseReportController; // Pastikan ini di-import

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Arahkan halaman utama ke login
Route::redirect('/', 'login');

// Grup untuk semua route yang memerlukan login
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    
    // Route untuk Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Resource untuk Category
    Route::resource('category', CategoryController::class);
    
    // Route Resource untuk Campaign
    Route::resource('campaign', CampaignController::class);

    // Route untuk Donatur 
    Route::get('/donatur', [DonaturController::class, 'index'])->name('donatur.index');

    // --- Routes untuk Laporan Donasi ---
    Route::prefix('donation')->as('donation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\DonationController::class, 'index'])->name('index');
        Route::get('/filter', [\App\Http\Controllers\DonationController::class, 'filter'])->name('filter');
        Route::get('/export/excel', [\App\Http\Controllers\DonationController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [\App\Http\Controllers\DonationController::class, 'exportPdf'])->name('export.pdf');
    });

    // --- Route untuk Slider ---
    Route::resource('/slider', SliderController::class)->only([
        'index',    // GET /slider
        'create',   // GET /slider/create
        'store',    // POST /slider
        'destroy'   // DELETE /slider/{slider}
    ]);

    // Route untuk menangani upload gambar Trix (untuk Campaign)
    Route::post('/trix-upload', [TrixUploadController::class, 'store'])->name('trix.upload');
    Route::post('/trix-remove', [TrixUploadController::class, 'remove'])->name('trix.remove');

    // Route untuk Laporan Pengeluaran
    Route::resource('expense-reports', ExpenseReportController::class);

    // =============================================================
    //          INI ADALAH RUTE BARU UNTUK UPLOAD GAMBAR
    // =============================================================
    Route::post('expense-reports/upload', [ExpenseReportController::class, 'upload'])->name('expense-reports.upload');
    Route::delete('expense-reports/upload', [ExpenseReportController::class, 'removeUpload'])->name('expense-reports.removeUpload');
    
    Route::get('/prayers', [PrayerController::class, 'index'])->name('prayers.index');
    Route::put('/prayers/{donation}', [PrayerController::class, 'update'])->name('prayers.update');

    // Fallback jika route tidak ditemukan
    Route::fallback(function() {
        return view('pages.utility.404');
    });     
});