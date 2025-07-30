<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'invoice', 'campaign_id', 'donatur_id', 'amount', 'pray', 'status', 'snap_token', 'is_pray_visible'
    ];

    /**
     * campaign
     *
     * @return void
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * donatur
     *
     * @return void
     */
    public function donatur()
    {
        return $this->belongsTo(Donatur::class);
    }
}