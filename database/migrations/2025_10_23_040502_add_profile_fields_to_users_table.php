<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan kolom hanya jika belum ada
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'wallet_address')) {
                $table->string('wallet_address')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'wallet_connected_at')) {
                $table->timestamp('wallet_connected_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToCheck = ['avatar', 'no_hp', 'alamat', 'wallet_address', 'wallet_connected_at'];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};