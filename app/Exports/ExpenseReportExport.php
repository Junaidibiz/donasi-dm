<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomPdfConfiguration; // Pastikan use statement ini ada

class ExpenseReportExport implements FromView, ShouldAutoSize// Pastikan implementasi ini ada
{
    protected $expenseReports;
    protected $date_from;
    protected $date_to;

    // Terima variabel tanggal di constructor
    public function __construct($expenseReports, $date_from = null, $date_to = null)
    {
        $this->expenseReports = $expenseReports;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function view(): View
    {
        // Kirim semua data ke view
        return view('pages.expense-report.pdf', [
            'expenseReports' => $this->expenseReports,
            'date_from'      => $this->date_from,
            'date_to'        => $this->date_to,
        ]);
    }
    
    // Atur orientasi menjadi landscape agar tidak terpotong
    public function getPdfConfiguration(): array
    {
        return [
            'orientation' => 'landscape'
        ];
    }
}