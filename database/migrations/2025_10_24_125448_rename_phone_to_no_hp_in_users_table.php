<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename kolom phone menjadi no_hp
            if (Schema::hasColumn('users', 'phone') && !Schema::hasColumn('users', 'no_hp')) {
                $table->renameColumn('phone', 'no_hp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan ke phone jika rollback
            if (Schema::hasColumn('users', 'no_hp') && !Schema::hasColumn('users', 'phone')) {
                $table->renameColumn('no_hp', 'phone');
            }
        });
    }
};