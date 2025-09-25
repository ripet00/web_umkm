<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; // Ganti Model dengan Authenticatable
use Illuminate\Notifications\Notifiable; // Tambahkan Notifiable

class Seller extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_koperasi',
        'kecamatan',
        'desa_kelurahan',
        'jenis_usaha',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
