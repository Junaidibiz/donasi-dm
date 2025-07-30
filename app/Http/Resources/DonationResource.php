<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount'       => $this->amount,
            'pray'         => $this->when($this->is_pray_visible, $this->pray),
            'created_at'   => $this->created_at->format('Y-m-d H:i:s'),
            'donatur'      => new DonaturResource($this->whenLoaded('donatur')),
        ];
    }
}