<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\ExpenseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseReports = ExpenseReport::with('campaign')->latest()->paginate(10);
        return view('pages.expense-report.index', compact('expenseReports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campaigns = Campaign::orderBy('title')->get();
        return view('pages.expense-report.create', compact('campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // =============================================
        //              PERBAIKAN DI SINI
        // =============================================
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'title'       => 'required|string|max:255', // Pastikan title divalidasi
            'description' => 'required|string',
            'amount'      => 'required|integer|min:1',
            'expense_date'=> 'required|date',
        ]);

        ExpenseReport::create($validated);

        return redirect()->route('expense-reports.index')->with('success', 'Laporan pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseReport $expenseReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseReport $expenseReport)
    {
        $campaigns = Campaign::orderBy('title')->get();
        return view('pages.expense-report.edit', compact('expenseReport', 'campaigns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseReport $expenseReport)
    {
        // =============================================
        //              PERBAIKAN DI SINI
        // =============================================
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'title'       => 'required|string|max:255', // Pastikan title divalidasi
            'description' => 'required|string',
            'amount'      => 'required|integer|min:1',
            'expense_date'=> 'required|date',
        ]);

        $expenseReport->update($validated);

        return redirect()->route('expense-reports.index')->with('success', 'Laporan pengeluaran berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseReport $expenseReport)
    {
        $expenseReport->delete();
        return redirect()->route('expense-reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
    
    /**
     * Method untuk menangani upload file dari Trix Editor.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/expense-reports');
            $url = Storage::url($path);
            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'Upload failed.'], 400);
    }

    /**
     * Method untuk menghapus file yang di-upload dari Trix Editor.
     */
    public function removeUpload(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
        ]);

        $path = str_replace('/storage', 'public', parse_url($request->url, PHP_URL_PATH));
        
        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'File not found.'], 404);
    }
}