<?php

namespace App\Exports;

use App\Models\Donation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DonationsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Logika query yang sama persis dengan method filter di controller
        $query = Donation::with('campaign.category', 'donatur')->where('status', 'success');

        if (!empty($this->filters['date_from']) && !empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from'])->whereDate('created_at', '<=', $this->filters['date_to']);
        }
        if (!empty($this->filters['campaign_id'])) {
            $query->where('campaign_id', $this->filters['campaign_id']);
        }
        if (!empty($this->filters['category_id'])) {
            $query->whereHas('campaign', function ($q) {
                $q->where('category_id', $this->filters['category_id']);
            });
        }
        return $query->get();
    }

    /**
     * Mendefinisikan header untuk kolom Excel.
     */
    public function headings(): array
    {
        return [
            'INVOICE',
            'NAMA DONATUR',
            'CAMPAIGN',
            'JUMLAH',
            'TANGGAL',
        ];
    }

    /**
     * Memetakan data untuk setiap baris di Excel.
     */
    public function map($donation): array
    {
        return [
            $donation->invoice,
            $donation->donatur->name,
            $donation->campaign->title,
            $donation->amount,
            $donation->created_at->format('d-m-Y H:i'),
        ];
    }
}