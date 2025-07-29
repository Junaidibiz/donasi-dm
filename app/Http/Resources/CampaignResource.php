<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'slug'            => $this->slug,
            'description'     => $this->description,
            'image'           => $this->image, // Accessor dari Model akan bekerja di sini
            'target_donation' => (int) $this->target_donation,
            'max_date'        => $this->max_date->format('Y-m-d'),
            'total_donation'  => (int) ($this->sumDonation->first()->total ?? 0),
            'user'            => new UserResource($this->whenLoaded('user')),
            'donations'       => DonationResource::collection($this->whenLoaded('donations')),
            'expense_reports' => ExpenseReportResource::collection($this->whenLoaded('expenseReports')),
        ];
    }
}