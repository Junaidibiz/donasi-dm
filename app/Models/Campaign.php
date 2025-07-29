<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Campaign extends Model
{
    protected $fillable = [
        'title', 'slug', 'category_id', 'target_donation', 'max_date', 'description', 'image', 'user_id',
    ];

    protected $casts = [
        'max_date' => 'date',
    ];

    /**
     * Accessor untuk mendapatkan URL gambar yang valid.
     * Ini adalah cara yang benar dan akan selalu menghasilkan URL lengkap.
     */
    public function getImageAttribute($value): string
    {
        return url('storage/campaigns/' . $value);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function sumDonation(): HasMany
    {
        return $this->hasMany(Donation::class)
            ->selectRaw('donations.campaign_id, SUM(donations.amount) as total')
            ->where('donations.status', 'success')
            ->groupBy('donations.campaign_id');
    }

    public function expenseReports(): HasMany
    {
        return $this->hasMany(ExpenseReport::class);
    }
}