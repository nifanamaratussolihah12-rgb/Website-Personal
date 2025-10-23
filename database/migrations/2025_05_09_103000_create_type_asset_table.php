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
        Schema::create('type_asset', function (Blueprint $table) {
           $table->id();
           $table->string('nama_type')->unique(); // contoh: Elektronik, Furniture
           $table->string('type_prefix', 10)->unique()->nullable(); // contoh: IT01, GA01,  (kode prefix unik tiap type asset)
           $table->enum('owner_role', ['it','ga'])->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_asset');
    }
};
