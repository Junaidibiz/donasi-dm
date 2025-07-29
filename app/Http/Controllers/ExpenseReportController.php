<?php
// app/Http/Controllers/ExpenseReportController.php

namespace App\Http\Controllers;

use App\Models\Campaign; // <-- Tambahkan ini
use App\Models\ExpenseReport;
use Illuminate\Http\Request;

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
    public function create() // <-- Isi method ini
    {
        // Ambil semua campaign untuk ditampilkan di dropdown
        $campaigns = Campaign::orderBy('title')->get();

        return view('pages.expense-report.create', compact('campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'campaign_id' => 'required|exists:campaigns,id',
        'description' => 'required|string', // <-- Perubahan di sini
        'amount'      => 'required|integer|min:1',
        'expense_date'=> 'required|date',
    ]);

    // Buat dan simpan data baru
    ExpenseReport::create($validated);

    // Redirect kembali ke halaman index dengan pesan sukses
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
        // Ambil semua campaign untuk dropdown
        $campaigns = Campaign::orderBy('title')->get();

        // Tampilkan view edit dengan data laporan dan data campaign
        return view('pages.expense-report.edit', compact('expenseReport', 'campaigns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseReport $expenseReport)
    {
        // Validasi input
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'description' => 'required|string',
            'amount'      => 'required|integer|min:1',
            'expense_date'=> 'required|date',
        ]);

        // Update data laporan
        $expenseReport->update($validated);

        // Redirect kembali ke halaman index dengan pesan sukses
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
}