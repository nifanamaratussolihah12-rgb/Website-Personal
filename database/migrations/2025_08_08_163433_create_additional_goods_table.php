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
        Schema::create('additional_goods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('type_asset_id');
            $table->string('item_name');
            $table->string('asset_type')->nullable();
            $table->string('code')->nullable();
            $table->string('asset_number')->nullable();
            $table->integer('qty')->default(0);
            $table->string('room')->nullable();
            $table->string('floor')->nullable();
            $table->string('merk')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->string('catatan')->nullable();
            $table->enum('status', ['new', 'reclaim'])->default('new');
            $table->string('foto')->nullable();
            $table->timestamps();

            // foreign key constraints
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('type_asset_id')->references('id')->on('type_asset')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_goods');
    }
};
