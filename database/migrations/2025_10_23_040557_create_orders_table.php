<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel orders sudah ada, hanya tambahkan kolom yang missing
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                
                // Tambahkan kolom yang belum ada (jika diperlukan)
                if (!Schema::hasColumn('orders', 'alamat_pengiriman')) {
                    $table->text('alamat_pengiriman')->nullable()->after('payment_status');
                }
                
                if (!Schema::hasColumn('orders', 'notes')) {
                    $table->text('notes')->nullable()->after('alamat_pengiriman');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'alamat_pengiriman')) {
                    $table->dropColumn('alamat_pengiriman');
                }
                if (Schema::hasColumn('orders', 'notes')) {
                    $table->dropColumn('notes');
                }
            });
        }
    }
};