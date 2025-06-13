<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    /**
     * Menampilkan halaman utama laporan donasi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengarahkan ke view yang akan kita buat nanti
        return view('pages.donation.index');
    }
    
    /**
     * Menyaring data donasi berdasarkan rentang tanggal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request)
    {
        $request->validate([
            'date_from'  => 'required|date',
            'date_to'    => 'required|date|after_or_equal:date_from',
        ]);

        $date_from  = $request->date_from;
        $date_to    = $request->date_to;

        // Get data donasi berdasarkan rentang tanggal
        $donations = Donation::with('campaign', 'donatur')->where('status', 'success')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->get();

        // Get total donasi berdasarkan rentang tanggal     
        $total = Donation::where('status', 'success')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to)->sum('amount');
        
        // Kembali ke view yang sama dengan membawa data hasil filter
        return view('pages.donation.index', compact('donations', 'total', 'date_from', 'date_to'));
    }
}