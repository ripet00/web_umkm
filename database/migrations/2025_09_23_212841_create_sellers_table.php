<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_koperasi');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('kecamatan');
            $table->string('desa_kelurahan');
            $table->string('jenis_usaha');
            $table->string('no_hp')->nullable();
            $table->text('alamat_toko')->nullable();
            $table->text('deskripsi_toko')->nullable();
            $table->string('foto_profil')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
