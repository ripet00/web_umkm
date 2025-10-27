<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    protected $fillable = [
        'seller_id', 
        'category_id', 
        'nama_produk', 
        'deskripsi', 
        'harga', 
        'stok'
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

    // Relasi ke Multiple Images
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    // Relasi ke Primary Image
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    // Accessor untuk mendapatkan path primary image
    public function getPrimaryImagePathAttribute()
    {
        return $this->primaryImage ? $this->primaryImage->image_path : null;
    }

    // Accessor untuk mendapatkan semua image paths
    public function getImagePathsAttribute()
    {
        return $this->images->pluck('image_path')->toArray();
    }

    // Helper untuk mendapatkan URL primary image
    public function getPrimaryImageUrlAttribute()
    {
        if ($this->primaryImage) {
            return asset('storage/' . $this->primaryImage->image_path);
        }
        return null;
    }
    
    /**
     * Get users who have wishlisted this product
     */
    public function wishlistUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')
            ->withTimestamps();
    }

    /**
     * Relasi ke Wishlist
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Check if this product is in user's wishlist
     * 
     * @param int|null $userId
     * @return bool
     */
    public function isInWishlist($userId = null): bool
    {
        // Jika tidak ada userId, gunakan user yang sedang login
        if ($userId === null) {
            // Cek apakah user sedang login
            if (!Auth::guard('web')->check()) {
                return false;
            }
            $userId = Auth::guard('web')->id();
        }

        // Cek apakah produk ada di wishlist user
        return $this->wishlists()
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Get wishlist count for this product
     * 
     * @return int
     */
    public function getWishlistCountAttribute(): int
    {
        return $this->wishlists()->count();
    }
}