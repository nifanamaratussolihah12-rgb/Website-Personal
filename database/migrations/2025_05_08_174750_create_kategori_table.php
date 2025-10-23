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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); 
            $table->string('kategori_prefix', 10);
            $table->enum('owner_role', ['it', 'ga'])->nullable();
            $table->enum('asset_kind', ['physical', 'service'])->default('physical');
            $table->timestamps();

            // kombinasi unik = nama + role
            $table->unique(['nama_kategori', 'owner_role']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
