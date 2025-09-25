<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['seller_id', 'nama_produk', 'deskripsi', 'harga', 'stok'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
