<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_data_details', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // pastikan engine InnoDB
            $table->id();
            
            // relasi ke asset_handovers
            $table->unsignedBigInteger('asset_handover_id');
            
            $table->string('item_name');
            $table->integer('quantity')->default(1);
            $table->string('condition')->nullable(); // kondisi barang
            $table->timestamps();

            // foreign key
            $table->foreign('asset_handover_id')
                  ->references('id')
                  ->on('asset_handovers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_data_details');
    }
};
