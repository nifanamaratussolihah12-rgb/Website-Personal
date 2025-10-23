<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('asset_item_code', function (Blueprint $table) {
        $table->id();
        $table->foreignId('type_asset_id')
              ->constrained('type_asset') // pastikan nama tabelnya memang type_asset
              ->onDelete('cascade');
        $table->string('item_name'); // nama item, misal Sofa 2 Seater
        $table->string('item_code', 5); // misal 03
        $table->unique(['type_asset_id', 'item_name']);
        $table->timestamps();
    });
    }

    public function down()
    {
    Schema::dropIfExists('asset_item_code');
    }
};
