<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'slug'            => $this->slug,
            'description'     => $this->description,
            
            // --- INI PERUBAHANNYA ---
            // Secara eksplisit membuat URL lengkap untuk gambar.
            'image'           => $this->when($this->getRawOriginal('image'), asset('storage/campaigns/' . $this->getRawOriginal('image'))),
            
            'target_donation' => $this->target_donation,
            'max_date'        => $this->max_date->format('Y-m-d'),
            
            // Memuat total donasi dari relasi sumDonation
            'total_donation'  => $this->sumDonation->sum('total'),
            
            // Menggunakan UserResource yang sudah kita buat
            'user'            => new UserResource($this->whenLoaded('user')),
        ];
    }
}