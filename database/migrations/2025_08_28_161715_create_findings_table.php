<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('findings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_departemen')->nullable();
            $table->string('lokasi_temuan')->nullable();
            $table->date('tanggal_penemuan')->nullable();
            $table->string('judul_temuan')->nullable();
            $table->text('deskripsi_temuan')->nullable();
            $table->string('form_readiness_terkait')->nullable();
            $table->date('tanggal_form_readiness')->nullable();
            $table->string('bukti_temuan_foto')->nullable();
            $table->string('bukti_temuan_text')->nullable();
            $table->text('analisis_penyebab')->nullable();
            $table->text('analisis_dampak')->nullable();
            $table->text('tindakan_sementara')->nullable();
            $table->text('tindakan_perbaikan')->nullable();
            $table->string('penanggung_jawab_tindakan')->nullable();
            $table->date('target_waktu_penyelesaian')->nullable();
            $table->enum('status_follow_up', ['PJO','MANAJEMEN','DIREKSI'])->nullable();
            $table->date('tanggal_verifikasi')->nullable();
            $table->text('hasil_verifikasi')->nullable();

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
        Schema::dropIfExists('findings');
    }
};
