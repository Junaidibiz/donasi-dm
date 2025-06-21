<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Campaign extends Model
{
    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'slug', 'category_id', 'target_donation', 'max_date', 'description', 'image', 'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'max_date' => 'date',
    ];

    /**
     * Mendefinisikan relasi ke model Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendefinisikan relasi ke model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi ke model Donation.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Relasi untuk menjumlahkan donasi yang sukses.
     */
    public function sumDonation(): HasMany
    {
        return $this->hasMany(Donation::class)
            ->selectRaw('donations.campaign_id, SUM(donations.amount) as total')
            ->where('donations.status', 'success')
            ->groupBy('donations.campaign_id');
    }

    /**
     * Accessor untuk mendapatkan URL gambar yang valid.
     */
    public function getImageAttribute(): string
    {
        if ($this->attributes['image'] && Storage::disk('public')->exists('campaigns/' . $this->attributes['image'])) {
            return Storage::url('campaigns/' . $this->attributes['image']);
        }
        
        return 'https://via.placeholder.com/800x400';
    }
}