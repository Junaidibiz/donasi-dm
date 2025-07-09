<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Exports\DonationsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DonationController extends Controller
{
    /**
     * Menampilkan halaman utama laporan donasi.
     * Jika ada request filter, akan menampilkan juga hasilnya.
     */
    public function index(Request $request)
    {
        $campaigns = Campaign::latest()->get();
        $categories = Category::latest()->get();

        $donations = null;
        $total = 0;

        // Cek jika ada request filter yang dikirim
        if ($request->has('date_from') || $request->has('campaign_id') || $request->has('category_id')) {
            $donations = $this->getFilteredDonations($request);
            $total = $donations->sum('amount');
        }

        return view('pages.donation.index', compact('donations', 'total', 'campaigns', 'categories'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new DonationsExport($request->all()), 'laporan_donasi.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $donations = $this->getFilteredDonations($request);
        $total = $donations->sum('amount');
        
        // Ambil tanggal dari request untuk dikirim ke view
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        // Muat view dengan semua data yang diperlukan
        $pdf = Pdf::loadView('pages.donation.pdf', compact('donations', 'total', 'date_from', 'date_to'));
        
        return $pdf->download('laporan_donasi.pdf');
    }


    private function getFilteredDonations(Request $request)
    {
        // Validasi input
        $request->validate([
            'date_from'  => 'nullable|date',
            'date_to'    => 'nullable|date|after_or_equal:date_from',
        ]);
        
        $query = Donation::with('campaign.category', 'donatur')->where('status', 'success');

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        }
        if ($request->filled('category_id')) {
            $query->whereHas('campaign', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }
        return $query->get();
    }
}