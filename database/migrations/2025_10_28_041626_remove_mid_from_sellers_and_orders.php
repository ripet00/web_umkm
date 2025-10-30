<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus kolom mid dari orders jika ada
        if (Schema::hasColumn('orders', 'mid')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('mid');
            });
        }

        // Hapus kolom mid dari sellers jika ada
        if (Schema::hasColumn('sellers', 'mid')) {
            Schema::table('sellers', function (Blueprint $table) {
                // Jika kolom memiliki unique index, laravel akan drop index otomatis saat dropColumn di beberapa driver,
                // tapi untuk aman kita bisa drop index dulu — namun Schema::hasColumn tidak memberi info index.
                // Simpel: coba drop column langsung, jika DB menolak karena index, buat pengecekan manual via DB tool.
                $table->dropColumn('mid');
            });
        }
    }

    public function down(): void
    {
        // Kembalikan kolom mid sebagai nullable string (tanpa unique) — jika Anda ingin rollback migration revert
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'mid')) {
                $table->string('mid')->nullable()->after('seller_id');
            }
        });

        Schema::table('sellers', function (Blueprint $table) {
            if (!Schema::hasColumn('sellers', 'mid')) {
                $table->string('mid')->nullable()->after('email');
            }
        });
    }
};