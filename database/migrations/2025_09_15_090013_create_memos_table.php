<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->id();

            // Data Lembar Disposisi
            $table->string('tgl_no_surat')->nullable();
            $table->text('perihal')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('dari_disposisi')->nullable();
            $table->text('disposisi')->nullable();  // [{tujuan:..., status:..., keterangan:...}, {...}]
            $table->date('tanggal_disposisi')->nullable();

            // Data Lembar Memo 
            $table->date('tanggal_memo')->nullable();
            $table->string('lokasi_memo')->nullable();
            $table->string('nomor')->nullable();
            $table->string('kepada')->nullable();
            $table->string('dari_memo')->nullable();
            $table->string('perihal_memo')->nullable();
            $table->longText('isi')->nullable(); // teks panjang manual

            // TTD
            $table->string('ttd_disusun_nama')->nullable();
            $table->string('ttd_disusun_jabatan')->nullable();
            $table->string('ttd_diperiksa_nama')->nullable();
            $table->string('ttd_diperiksa_jabatan')->nullable();
            $table->string('ttd_disetujui_nama')->nullable();
            $table->string('ttd_disetujui_jabatan')->nullable();

            // Tambahan
            $table->enum('status', ['pending approval', 'approval', 'done'])->default('pending approval');
            $table->text('catatan')->nullable();

            $table->timestamps();
        }); 
    }

    public function down(): void
    {
        Schema::dropIfExists('memos');
    }
};
