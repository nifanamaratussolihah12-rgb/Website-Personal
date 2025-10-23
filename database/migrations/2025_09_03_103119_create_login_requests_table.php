<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_requests', function (Blueprint $table) {
            $table->id();

            // General Info
            $table->date('tanggal')->nullable();
            $table->string('cabang')->nullable();

            // Company
            $table->boolean('is_abm_group')->default(false);
            $table->string('company_name')->nullable();

            // Jenis Permintaan
            $table->enum('jenis_permintaan', ['email', 'internet'])->nullable();
            $table->string('sub_jenis')->nullable(); // email:new/change/delete, internet:manual input

            // User Info
            $table->string('nama_depan')->nullable();
            $table->string('nama_tengah')->nullable();
            $table->string('nama_belakang')->nullable();
            $table->string('nik')->nullable();
            $table->string('alamat_email')->nullable();
            $table->string('divisi')->nullable();
            $table->string('departemen')->nullable();

            // Additional
            $table->string('mengetahui')->nullable();
            $table->date('tanggal_diterima')->nullable();
            $table->string('alamat_email_login')->nullable();
            $table->longText('password')->nullable(); // disimpan hashed
            $table->date('tanggal_efektif')->nullable();
            $table->string('dibuat_oleh')->nullable();
            $table->date('tanggal_dibuat')->nullable();

            // Note max 500 chars
            $table->string('note', 500)->nullable();
            $table->string('catatan', 500)->nullable();

            $table->date('tanggal_dokumen')->nullable(); // tanggal dokumen diterbitkan
            $table->date('tanggal_expired')->nullable(); // tanggal kedaluwarsa

            // Tambahan
            $table->enum('status', ['pending approval', 'approval', 'done'])->default('pending approval');
            $table->text('memo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_requests');
    }
};
