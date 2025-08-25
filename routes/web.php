<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TrixUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Arahkan halaman utama ke halaman login
Route::get('/', function () {
    return view('auth.login');
});

// Grup untuk semua route yang memerlukan login
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    
    // --- UTAMA ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- MASTER DATA ---
    Route::resource('category', CategoryController::class);
    Route::resource('campaign', CampaignController::class);
    Route::resource('slider', SliderController::class)->except(['show']);
    Route::get('donatur', [DonaturController::class, 'index'])->name('donatur.index');
    Route::get('prayers', [PrayerController::class, 'index'])->name('prayers.index');
    Route::put('prayers/{donation}', [PrayerController::class, 'update'])->name('prayers.update');

    // --- LAPORAN ---

    // Laporan Donasi
    Route::prefix('donation')->as('donation.')->group(function () {
        Route::get('/', [DonationController::class, 'index'])->name('index');
        Route::get('export/excel', [DonationController::class, 'exportExcel'])->name('export.excel');
        Route::get('export/pdf', [DonationController::class, 'exportPdf'])->name('export.pdf');
    });

    // Laporan Pengeluaran
    Route::prefix('expense-reports')->as('expense-reports.')->group(function () {
        Route::get('/', [ExpenseReportController::class, 'index'])->name('index');
        Route::get('/create', [ExpenseReportController::class, 'create'])->name('create');
        Route::post('/', [ExpenseReportController::class, 'store'])->name('store');
        Route::get('/{expenseReport}/edit', [ExpenseReportController::class, 'edit'])->name('edit');
        Route::put('/{expenseReport}', [ExpenseReportController::class, 'update'])->name('update');
        Route::delete('/{expenseReport}', [ExpenseReportController::class, 'destroy'])->name('destroy');
        
        // Rute untuk Export
        Route::get('export/excel', [ExpenseReportController::class, 'exportExcel'])->name('excel');
        Route::get('export/pdf', [ExpenseReportController::class, 'exportPdf'])->name('pdf');
    });

    // --- UTILITAS ---

    // Route umum untuk menangani upload gambar dari Trix Editor
    Route::post('/trix-upload', [TrixUploadController::class, 'store'])->name('trix.upload');
    Route::post('/trix-remove', [TrixUploadController::class, 'remove'])->name('trix.remove');

    // Fallback jika route tidak ditemukan
    Route::fallback(function() {
        return view('pages.utility.404');
    });     
});