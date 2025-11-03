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
     * Check if seller is active and has complete Midtrans configuration
     */
    public function isActivated(): bool
    {
        return $this->is_active && 
               !empty($this->merchant_id) && 
               !empty($this->client_key) && 
               !empty($this->server_key);
    }

    /**
     * Check if seller can manage products (CRUD) - only needs basic activation
     */
    public function canManageProducts(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if seller can receive payments - needs full Midtrans setup
     */
    public function canReceivePayments(): bool
    {
        return $this->isActivated();
    }

    /**
     * Check if seller can sell products (for backward compatibility)
     */
    public function canSell(): bool
    {
        return $this->canReceivePayments();
    }

    /**
     * Check if seller has complete payment configuration
     */
    public function hasCompletePaymentConfig(): bool
    {
        return !empty($this->merchant_id) && 
               !empty($this->client_key) && 
               !empty($this->server_key);
    }

    /**
     * Get activation status with details
     */
    public function getActivationStatus(): array
    {
        $status = [
            'is_active' => $this->is_active,
            'has_merchant_id' => !empty($this->merchant_id),
            'has_client_key' => !empty($this->client_key),
            'has_server_key' => !empty($this->server_key),
        ];

        $status['can_manage_products'] = $status['is_active'];
        $status['can_receive_payments'] = $status['is_active'] && 
                                         $status['has_merchant_id'] && 
                                         $status['has_client_key'] && 
                                         $status['has_server_key'];

        return $status;
    }
}
