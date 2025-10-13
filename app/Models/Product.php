<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'seller_id', 
        'category_id', 
        'nama_produk', 
        'deskripsi', 
        'harga', 
        'stok'
        // 'gambar_produk' sudah dihapus
    ];

    // Relasi ke Seller
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    // Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Multiple Images (BARU)
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    // Relasi ke Primary Image (BARU)
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    // Accessor untuk mendapatkan path primary image (BARU)
    public function getPrimaryImagePathAttribute()
    {
        return $this->primaryImage ? $this->primaryImage->image_path : null;
    }

    // Accessor untuk mendapatkan semua image paths (BARU)
    public function getImagePathsAttribute()
    {
        return $this->images->pluck('image_path')->toArray();
    }

    // Helper untuk mendapatkan URL primary image (BARU)
    public function getPrimaryImageUrlAttribute()
    {
        if ($this->primaryImage) {
            return asset('storage/' . $this->primaryImage->image_path);
        }
        return null;
    }
}