<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_handovers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_formulir')->unique(); // contoh: Serah Terima Asset
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_handovers');
    }
};
