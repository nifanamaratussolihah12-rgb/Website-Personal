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
        Schema::create('asset_code_mappings', function (Blueprint $table) {
          $table->id();
          $table->string('asset_type'); // Furniture, Electronics, dll.
          $table->string('type_code');  // F01, F02, F03...
          $table->string('item_name');  // Kursi, TV LED, dll.
          $table->string('item_code');  // 01, 02...
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_code_mappings');
    }
};
