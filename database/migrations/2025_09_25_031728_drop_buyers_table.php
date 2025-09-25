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
        // Perintah untuk menghapus tabel 'buyers'
        Schema::dropIfExists('buyers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // (Opsional tapi praktik yang baik) Buat kembali tabel jika migrasi di-rollback
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_hp');
            $table->timestamps();
        });
    }
};
