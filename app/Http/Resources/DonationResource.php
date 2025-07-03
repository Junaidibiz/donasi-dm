<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount'       => $this->amount,
            'pray'         => $this->pray,
            'created_at'   => $this->created_at->format('Y-m-d H:i:s'),
            // Di sini kita menggunakan DonaturResource untuk memuat relasi donatur
            'donatur'      => new DonaturResource($this->whenLoaded('donatur')),
        ];
    }
}