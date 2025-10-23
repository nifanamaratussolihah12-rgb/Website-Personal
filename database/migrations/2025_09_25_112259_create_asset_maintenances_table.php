<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id')->nullable(); // relasi ke asset
            $table->date('issue_date')->nullable(); // tanggal isu
            $table->enum('maintenance_type', ['preventive','corrective','replace'])->nullable(); // jenis
            $table->date('schedule_date')->nullable(); // penjadwalan
            $table->decimal('cost', 12, 2)->nullable(); // biaya
            $table->enum('priority', ['Top Urgent', 'Urgent','Medium', 'Low'])->nullable(); // status priority
            $table->unsignedBigInteger('handled_by')->nullable(); // ditangani oleh
            $table->enum('status', ['pending','done','cancelled'])->nullable(); // status
            $table->text('notes')->nullable(); // catatan
            $table->date('last_maintenance_date')->nullable(); // tambahan
            //$table->decimal('maintenance_cost_total', 12, 2)->nullable(); // tambahan

            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('non_asset_ticket_id')->nullable();

            $table->timestamps();

            // relasi
            $table->foreign('asset_id')->references('id')->on('asset')->onDelete('cascade');
            $table->foreign('handled_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('non_asset_ticket_id')->references('id')->on('non_asset_tickets')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('asset_maintenances');
    }
};
