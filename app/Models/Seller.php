<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Seller extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_koperasi',
        'email',
        'password',
        'kecamatan',
        'desa_kelurahan',
        'jenis_usaha',
        'no_hp',
        'alamat_toko',
        'deskripsi_toko',
        'foto_profil',
        'merchant_id',
        'is_active',
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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Relationship dengan Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if seller is active and has merchant ID
     */
    public function isActivated(): bool
    {
        return $this->is_active && !empty($this->merchant_id);
    }

    /**
     * Check if seller can sell products
     */
    public function canSell(): bool
    {
        return $this->isActivated();
    }
}
