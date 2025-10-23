<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_number_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('dept')->nullable();      // Dept bisa null
            $table->string('section')->nullable();   // Section bisa null
            $table->string('year_month');            // YYYYMM
            $table->integer('last_number')->default(0); // Nomor urut terakhir
            $table->timestamps();

            // Index gabungan supaya cepat query per dept/section/bulan
            $table->unique(['dept', 'section', 'year_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_number_sequences');
    }
};
