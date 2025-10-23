<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_type')->nullable();      // request baru / replacement
            $table->string('request_type_extra')->nullable();
            $table->string('tipe_penyerahan')->nullable(); 
            $table->string('new_asset_number')->nullable();
            $table->string('request_ref_num')->nullable();
            $table->string('nik')->nullable();
            $table->string('dept')->nullable();
            $table->string('section')->nullable();
            $table->string('asset_type')->nullable();        // alat komunikasi / aksesoris / pc-laptop
            $table->json('details')->nullable();             // Menyimpan banyak detail: brand, model, qty, user/pic
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
        Schema::dropIfExists('asset_requests');
    }
};
