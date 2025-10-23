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
        if (Schema::hasTable('kategori') && !Schema::hasColumn('kategori', 'kategori_prefix')) {
            Schema::table('kategori', function (Blueprint $table) {
                $table->string('kategori_prefix', 10)->nullable()->unique()->after('nama_kategori');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasTable('kategori') && Schema::hasColumn('kategori', 'kategori_prefix')) {
            Schema::table('kategori', function (Blueprint $table) {
                $table->dropColumn('kategori_prefix');
            });
        }
    }
};
