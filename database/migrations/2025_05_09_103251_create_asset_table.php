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
        Schema::create('asset', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('type_asset_id')->nullable();
            $table->enum('asset_kind', ['physical','service'])->default('physical')
                ->comment('physical = asset fisik, service = service items / non-fisik');
            $table->enum('status', ['new','active','reclaimed','damaged','lost','disposed'])->nullable();
            $table->string('foto')->nullable();

            $table->string('asset_type')->nullable();
            $table->string('code')->nullable();
            $table->string('asset_number')->nullable();  
            $table->string('item_name')->nullable();
            $table->unsignedInteger('qty')->nullable();
            $table->string('room')->nullable();      // hanya untuk asset fisik
            $table->string('floor')->nullable();     // hanya untuk asset fisik
            $table->string('merk')->nullable();      // hanya untuk asset fisik
            $table->text('catatan')->nullable();

            // tambahan untuk maintenance
            $table->date('tanggal')->nullable();
            $table->string('serial_number')->nullable(); // hanya asset fisik
            $table->text('model')->nullable();         // hanya asset fisik
            $table->text('spek')->nullable();          // hanya asset fisik
            $table->date('warranty_expiry')->nullable(); 
            $table->string('official_store')->nullable();
            $table->string('reseller')->nullable();
            $table->decimal('harga_beli', 15, 2)->nullable(); 

            // tambahan umum
            $table->string('user')->nullable(); 
            $table->string('departemen')->nullable();
            $table->string('site')->nullable();
            $table->enum('kondisi', ['layak pakai', 'rusak', 'baik'])->nullable(); 
            $table->text('history')->nullable();
            $table->enum('owner_role', ['it','ga'])->nullable()
                ->comment('it = asset IT, ga = asset GA');

            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('type_asset_id')->references('id')->on('type_asset')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset');
    }
};