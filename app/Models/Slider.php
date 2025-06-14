<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    protected $fillable = [
        'image', 'link'
    ];

    public function getImageAttribute(): string
    {
        if ($this->attributes['image'] && Storage::disk('public')->exists('sliders/' . $this->attributes['image'])) {
            return Storage::url('sliders/' . $this->attributes['image']);
        }
        return 'https://via.placeholder.com/1080x400';
    }
}