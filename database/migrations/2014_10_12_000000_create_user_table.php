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
        Schema::create('user', function (Blueprint $table) { 
            $table->id(); 
            $table->string('nama'); 
            $table->string('email')->unique(); 
            $table->tinyInteger('role')->default(0)
                ->comment('
                    0 = super_admin,
                    1 = admin_it,
                    2 = admin_ga,
                    3 = staff
                ');
            $table->string('password'); 
            $table->string('hp', 13); 
            $table->string('foto')->nullable(); 

            // Kolom baru
            $table->string('nik', 16)->nullable();
            $table->string('divisi')->nullable();
            $table->string('site')->nullable();
            $table->date('date_of_receive')->nullable();

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
