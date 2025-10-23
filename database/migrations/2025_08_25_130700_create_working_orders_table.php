<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('working_orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('divisi')->nullable();
            $table->string('section')->nullable();
            $table->text('permintaan')->nullable();
            $table->enum('jenis_pekerjaan', ['jaringan', 'cctv', 'radio'])->nullable();
            $table->string('lokasi')->nullable();
            $table->text('details')->nullable();
            $table->string('dokumen_diterima')->nullable();
            $table->date('tanggal')->nullable();
            $table->date('target_pengerjaan')->nullable();

            $table->date('tanggal_dokumen')->nullable(); // tanggal dokumen diterbitkan
            $table->date('tanggal_expired')->nullable(); // tanggal kedaluwarsa

            // Kolom kedua: task table
            $table->text('task_kesiapan_listrik')->nullable();
            $table->enum('status_kesiapan_listrik', ['ya', 'tidak'])->nullable();
            $table->text('reason_kesiapan_listrik')->nullable();
            $table->string('sign_kesiapan_listrik')->nullable();

            $table->text('task_tiang')->nullable();
            $table->enum('status_tiang', ['ya', 'tidak'])->nullable();
            $table->text('reason_tiang')->nullable();
            $table->string('sign_tiang')->nullable();

            $table->enum('task_perangkat', ['cctv', 'radio', 'jaringan'])->nullable();
            $table->enum('status_perangkat', ['ya', 'tidak'])->nullable();
            $table->text('reason_perangkat')->nullable();
            $table->string('sign_perangkat')->nullable();

            $table->text('task_panel')->nullable();
            $table->enum('status_panel', ['ya', 'tidak'])->nullable();
            $table->text('reason_panel')->nullable();
            $table->string('sign_panel')->nullable();

            $table->json('task_keselamatan')->nullable();
            $table->json('status_keselamatan')->nullable();
            $table->json('reason_keselamatan')->nullable();
            $table->json('sign_keselamatan')->nullable();

            // Tambahan
            $table->enum('status', ['pending approval', 'approval', 'done'])->default('pending approval');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('working_orders');
    }
};
