<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Di sinilah kita mendefinisikan semua kategori yang kita inginkan
        $categories = [
            'Makanan',
            'Minuman',
            'Kerajinan Tangan',
            'Pakaian',
            'Jasa',
            'Pertanian',
            'Elektronik',
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName, // Menggunakan kolom 'name' yang benar
                'slug' => Str::slug($categoryName)
            ]);
        }
    }
}

