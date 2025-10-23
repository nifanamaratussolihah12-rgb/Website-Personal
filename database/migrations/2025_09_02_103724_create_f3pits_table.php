<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('f3pits', function (Blueprint $table) {
            $table->id();
            $table->string('departement')->nullable();
            $table->string('pic')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('kode_inventaris')->nullable();
            $table->date('tahun_perolehan')->nullable();
            $table->string('jenis_inventaris')->nullable();
            $table->string('brand')->nullable();
            $table->string('tipe')->nullable();
            $table->string('sn')->nullable();

            $table->date('sejarah_tanggal')->nullable();
            $table->text('sejarah_keterangan')->nullable();

            $table->text('deskripsi_permasalahan')->nullable();

            $table->json('penyebab_kerusakan')->nullable();
            $table->json('langkah_dilakukan')->nullable();

            $table->text('kondisi_fisik')->nullable();
            $table->enum('prioritas_pengerjaan', ['normal', 'urgent', 'top_urgent'])->nullable();

            $table->string('pemohon')->nullable();
            $table->string('dep_head')->nullable();
            $table->boolean('kelengkapan_dokumen')->nullable();
            $table->boolean('lampiran_formulir')->nullable();

            $table->string('diterima_oleh')->nullable();
            $table->date('tanggal')->nullable();
            $table->date('garansi_sebelumnya')->nullable();

            $table->string('pemeriksaan_teknis_oleh')->nullable();
            $table->json('diputuskan_internal_it')->nullable();
            $table->json('diputuskan_vendor')->nullable();

            $table->string('hasil_diperiksa_oleh')->nullable();
            $table->date('hasil_diperiksa_tgl')->nullable();
            $table->boolean('sn_sesuai')->nullable();
            $table->boolean('bukti_penggantian')->nullable();

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
        Schema::dropIfExists('f3pits');
    }
};
