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
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->id();
            
            // Informasi Asset
            $table->string('asset_tag')->nullable();
            $table->string('asset_name')->nullable();
            $table->string('category')->nullable();
            $table->string('asset_brand')->nullable();
            $table->string('asset_model')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->string('warranty_status')->nullable();
            $table->date('warranty_end_date')->nullable();
            $table->date('tanggal_dokumen')->nullable(); // tanggal dokumen diterbitkan
            $table->date('tanggal_expired')->nullable(); // tanggal kedaluwarsa

            // Sebelum Pengalihan
            $table->string('prev_department')->nullable();
            $table->string('prev_user')->nullable();
            $table->text('transfer_reason')->nullable();

            // Sesudah Pengalihan
            $table->string('new_department')->nullable();
            $table->string('new_user')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('placement_location')->nullable();
            $table->string('asset_condition')->nullable();

            // Tambahan
            $table->enum('status', ['pending approval', 'approval', 'done'])->default('pending approval');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_transfers');
    }
};
