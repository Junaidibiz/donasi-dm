<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class Donatur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Accessor untuk mendapatkan URL avatar.
     * Akan otomatis dipanggil saat mengakses $donatur->avatar.
     * @param string|null $value
     * @return string|null // <-- UBAH return type menjadi string|null
     */
    public function getAvatarAttribute($value): ?string // <-- UBAH return type menjadi ?string
    {
        // JIKA KOLOM AVATAR DI DB KOSONG ATAU NULL, KEMBALIKAN NULL SAJA
        if (empty($value)) {
            return null; // <-- KOREKSI UTAMA DI SINI
        }

        // Jika nilai di database sudah berupa URL lengkap, langsung kembalikan
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Jika nilai di database adalah path relatif (nama file),
        // ubah menjadi URL lengkap menggunakan helper asset()
        // Ini akan otomatis menggunakan APP_URL dari .env Anda
        return asset('storage/donaturs/' . $value); // <-- Sesuaikan path storage jika perlu
    }
}