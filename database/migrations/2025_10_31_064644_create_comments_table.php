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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('gmail');
            $table->enum('role', ['guest', 'user', 'seller']);
            $table->text('pesan');
            $table->string('file_path')->nullable(); // Path file upload (foto/video)
            $table->string('file_type')->nullable(); // Type file (image/video)
            $table->string('file_name')->nullable(); // Original file name
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
