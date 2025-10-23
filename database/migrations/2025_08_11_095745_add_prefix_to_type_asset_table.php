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
        if (Schema::hasTable('type_asset') && !Schema::hasColumn('type_asset', 'type_prefix')) {
            Schema::table('type_asset', function (Blueprint $table) {
                $table->string('type_prefix', 10)->nullable()->unique()->after('nama_type');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('type_asset') && Schema::hasColumn('type_asset', 'type_prefix')) {
            Schema::table('type_asset', function (Blueprint $table) {
                $table->dropColumn('type_prefix');
            });
        }
    }
};
