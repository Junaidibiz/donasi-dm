<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\ExpenseReport;
use Illuminate\Http\Request;
use App\Exports\ExpenseReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseReportController extends Controller
{
    /**
     * Menampilkan daftar resource dengan filter.
     */
    public function index(Request $request)
    {
        // Query dasar untuk laporan pengeluaran
        $query = ExpenseReport::with('campaign.category')->latest();

        // Terapkan filter campaign jika ada
        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        } 
        // Jika tidak ada campaign, filter berdasarkan kategori
        elseif ($request->filled('category_id')) {
            $query->whereHas('campaign', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // Terapkan filter tanggal
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('expense_date', [$request->date_from, $request->date_to]);
        }

        $expenseReports = $query->paginate(10)->withQueryString();

        // Ambil data untuk dropdown filter
        $categories = Category::orderBy('name')->get();
        
        // Ambil campaign berdasarkan kategori yang dipilih, atau semua campaign jika tidak ada
        $campaigns = $request->filled('category_id')
            ? Campaign::where('category_id', $request->category_id)->orderBy('title')->get()
            : Campaign::orderBy('title')->get();

        return view('pages.expense-report.index', compact('expenseReports', 'categories', 'campaigns'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create()
    {
        $campaigns = Campaign::orderBy('title')->get();
        return view('pages.expense-report.create', compact('campaigns'));
    }

    /**
     * Menyimpan resource baru ke storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'description' => 'required|string',
            'amount'      => 'required|integer|min:1',
            'expense_date'=> 'required|date',
        ]);

        ExpenseReport::create($validated);

        return redirect()->route('expense-reports.index')->with('success', 'Laporan pengeluaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit resource.
     */
    public function edit(ExpenseReport $expenseReport)
    {
        $campaigns = Campaign::orderBy('title')->get();
        return view('pages.expense-report.edit', compact('expenseReport', 'campaigns'));
    }

    /**
     * Memperbarui resource di storage.
     */
    public function update(Request $request, ExpenseReport $expenseReport)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'description' => 'required|string',
            'amount'      => 'required|integer|min:1',
            'expense_date'=> 'required|date',
        ]);

        $expenseReport->update($validated);

        return redirect()->route('expense-reports.index')->with('success', 'Laporan pengeluaran berhasil diupdate.');
    }

    /**
     * Menghapus resource dari storage.
     */
    public function destroy(ExpenseReport $expenseReport)
    {
        $expenseReport->delete();
        return redirect()->route('expense-reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
    
    /**
     * Mengekspor data laporan ke file Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = ExpenseReport::with('campaign.category')->latest();

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        } elseif ($request->filled('category_id')) {
            $query->whereHas('campaign', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('expense_date', [$request->date_from, $request->date_to]);
        }

        $expenseReports = $query->get();
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $export = new ExpenseReportExport($expenseReports, $date_from, $date_to);

        return Excel::download($export, 'laporan-pengeluaran.xlsx');
    }

    /**
     * Mengekspor data laporan ke file PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = ExpenseReport::with('campaign.category')->latest();

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->campaign_id);
        } elseif ($request->filled('category_id')) {
            $query->whereHas('campaign', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('expense_date', [$request->date_from, $request->date_to]);
        }

        $expenseReports = $query->get();
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $export = new ExpenseReportExport($expenseReports, $date_from, $date_to);

        return Excel::download($export, 'laporan-pengeluaran.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}