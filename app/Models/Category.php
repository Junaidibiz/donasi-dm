<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'slug', 'image'
    ];

    /**
     * Mendefinisikan relasi "has many" ke model Campaign.
     * Satu kategori bisa memiliki banyak campaign.
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * Accessor untuk mendapatkan URL gambar yang valid.
     * Secara otomatis akan terpanggil saat Anda mengakses atribut 'image'.
     *
     * @return string
     */
    public function getImageAttribute(): string
    {
        // Cek apakah nilai 'image' ada dan file-nya benar-benar ada di storage
        if ($this->attributes['image'] && Storage::disk('public')->exists('categories/' . $this->attributes['image'])) {
            // Kembalikan URL lengkap ke gambar
            return Storage::url('categories/' . $this->attributes['image']);
        }
        
        // Jika tidak ada gambar, kembalikan URL ke gambar placeholder
        return 'https://via.placeholder.com/150';
    }
}