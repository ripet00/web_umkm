<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Ubah sesuai kolom database
    protected $fillable = ['name', 'slug'];

    // Tambahkan accessor untuk backward compatibility
    public function getNamaKategoriAttribute()
    {
        return $this->name;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}