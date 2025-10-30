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
            // Blockchain fields
            $table->string('blockchain_hash')->nullable()->after('snap_token');
            $table->string('blockchain_transaction_id')->nullable()->after('blockchain_hash');
            $table->bigInteger('block_number')->nullable()->after('blockchain_transaction_id');
            $table->text('transaction_data_hash')->nullable()->after('block_number');
            $table->json('blockchain_metadata')->nullable()->after('transaction_data_hash');
            $table->timestamp('blockchain_created_at')->nullable()->after('blockchain_metadata');
            $table->enum('blockchain_status', ['pending', 'confirmed', 'failed'])->default('pending')->after('blockchain_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'blockchain_hash',
                'blockchain_transaction_id', 
                'block_number',
                'transaction_data_hash',
                'blockchain_metadata',
                'blockchain_created_at',
                'blockchain_status'
            ]);
        });
    }
};