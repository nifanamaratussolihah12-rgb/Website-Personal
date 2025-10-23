<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('install_ready_forms', function (Blueprint $table) {
            $table->id();
            $table->string('project')->nullable(); // nama project
            $table->string('lokasi')->nullable(); // lokasi instalasi
            $table->date('tanggal')->nullable(); // tanggal instalasi
            $table->string('tim_pelaksana')->nullable(); // nama tim pelaksana
            $table->string('catatan')->nullable(); // catatan

            $table->json('persiapan_awal')->nullable(); // checkbox persiapan awal
            $table->json('k3')->nullable(); // checkbox K3
            $table->json('aspek_teknis')->nullable(); // checkbox aspek teknis
            $table->json('manajemen')->nullable(); // checkbox manajemen project
            $table->json('pasca')->nullable(); // checkbox pasca project
            
            $table->date('tanggal_dokumen')->nullable(); // tanggal dokumen diterbitkan
            $table->date('tanggal_expired')->nullable(); // tanggal kedaluwarsa

            // Tambahan
            $table->enum('status', ['pending approval', 'approval', 'done'])->default('pending approval');
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('install_ready_forms');
    }
};
