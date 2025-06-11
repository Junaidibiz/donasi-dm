<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'image'
    ];

    /**
     * campaigns
     *
     * @return void
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}