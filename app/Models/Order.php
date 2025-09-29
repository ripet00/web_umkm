<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    // Tambahkan 'nomor_pesanan', 'total_harga', dan 'snap_token' ke $fillable
    protected $fillable = [
        'user_id',
        'seller_id',
        'order_number',
        'total_price',
        'status',
        'payment_status',    // DITAMBAHKAN
        'payment_gateway',   // DITAMBAHKAN
        'snap_token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

