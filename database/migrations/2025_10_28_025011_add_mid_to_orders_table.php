<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kolom mid setelah seller_id untuk menyimpan MID seller
            // saat order dibuat. Nullable untuk backward compatibility jika ada order lama.
            $table->string('mid')->nullable()->after('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'mid')) {
                $table->dropColumn('mid');
            }
        });
    }
};
