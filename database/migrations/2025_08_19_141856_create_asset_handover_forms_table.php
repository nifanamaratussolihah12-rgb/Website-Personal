<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_handover_forms', function (Blueprint $table) {
            $table->id();

            // Bagian User
            $table->string('nama_user')->nullable();
            $table->string('nik_user')->nullable();
            $table->string('dept')->nullable();
            $table->string('section')->nullable();
            $table->date('tanggal')->nullable();

            // Bagian IT Staff
            $table->string('tipe_asset')->nullable(); 
            $table->string('handover_type')->nullable(); 
            $table->string('brand_asset',)->nullable(); 
            $table->string('model_asset',)->nullable(); 
            $table->string('nama_asset',)->nullable();
            $table->string('asset_tag')->nullable();
            $table->string('asset_sn')->nullable();
            $table->string('ref_rl_acumatica')->nullable();
            $table->string('handover_by')->nullable();
            $table->string('handover_by_nik')->nullable();
            $table->date('handover_date')->nullable();
            $table->date('tanggal_dokumen')->nullable(); // tanggal dokumen diterbitkan
            $table->date('tanggal_expired')->nullable(); // tanggal kedaluwarsa

            // Tambahan
            $table->enum('status', ['pending approval', 'approval', 'done'])->default('pending approval');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_handover_forms');
    }
};