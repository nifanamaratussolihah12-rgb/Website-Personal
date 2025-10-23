<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable()->constrained('asset')->onDelete('set null');
            $table->string('action', 50); // created, updated, deleted, transferred, maintenance, dll
            $table->string('status')->nullable()->comment('Status ticket saat aksi terjadi');
            $table->text('description')->nullable();
            $table->json('changes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('set null');
            $table->string('owner_role')->nullable()->comment('it/ga/null untuk super admin');

            // Tambahan untuk opsi hapus otomatis
            $table->string('retention_option')->nullable(); // misal '3 hari', '1 minggu', '1 bulan'
            $table->dateTime('expires_at')->nullable();      // tanggal otomatis log akan dihapus

            $table->timestamps();
            $table->index(['action', 'created_at']);
            $table->index('expires_at'); // supaya pencarian log kadaluarsa lebih cepat
        });

    }

    public function down()
    {
        Schema::dropIfExists('asset_histories');
    }
}
