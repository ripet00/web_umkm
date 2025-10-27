<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'avatar',
        'alamat',
        'no_hp',
        'wallet_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // User has many orders
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    // User has many wishlists
    public function wishlists()
    {
        return $this->hasMany(\App\Models\Wishlist::class);
    }

    // User has many products through wishlist (Many to Many)
    public function wishlistProducts(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Product::class, 'wishlists')
                    ->withTimestamps();
    }
}
