<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // <-- TAMBAHKAN INI

class Slider extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'image', 'link'
    ];

    /**
     * Accessor untuk mendapatkan URL gambar yang valid.
     *
     * @return string
     */
    public function getImageAttribute(): string
    {
        // Cek apakah nilai 'image' ada dan file-nya benar-benar ada di storage
        if ($this->attributes['image'] && Storage::disk('public')->exists('sliders/' . $this->attributes['image'])) {
            // Kembalikan URL lengkap ke gambar
            return Storage::url('sliders/' . $this->attributes['image']);
        }
        
        // Jika tidak ada gambar, kembalikan URL ke gambar placeholder
        return 'https://via.placeholder.com/1080x400';
    }
}