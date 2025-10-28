<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Tambahkan kolom mid setelah kolom email, buat nullable dan unik
            // Nullable karena seller mungkin mendaftar tanpa langsung mengisi MID
            // Unique (jika diperlukan) untuk memastikan tidak ada MID yang sama,
            // tapi perlu diperhatikan jika nullable, database mungkin mengizinkan banyak NULL.
            // Pertimbangkan validasi di level aplikasi jika perlu.
            $table->string('mid')->nullable()->unique()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Hapus unique index terlebih dahulu jika ada
            // Nama index default: sellers_mid_unique
             if (Schema::hasColumn('sellers', 'mid')) {
                 try {
                    // Cek dulu apakah index ada sebelum drop
                    $connection = Schema::getConnection();
                    $doctrineSchemaManager = $connection->getDoctrineSchemaManager();
                    $indexes = $doctrineSchemaManager->listTableIndexes('sellers');

                    if (isset($indexes['sellers_mid_unique'])) {
                        $table->dropUnique('sellers_mid_unique');
                    }
                 } catch (\Exception $e) {
                    // Handle jika index tidak ditemukan atau error lainnya
                    Log::warning("Could not drop unique index for 'mid' column on 'sellers' table: " . $e->getMessage());
                 }
                $table->dropColumn('mid');
             }
        });
    }
};
