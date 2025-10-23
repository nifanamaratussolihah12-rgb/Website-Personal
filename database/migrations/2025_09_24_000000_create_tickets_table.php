<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Nomor Ticket Otomatis (contoh: 07-10-25-001)
            $table->string('ticket_number')->unique();

            // Informasi Umum
            $table->string('reporter_name')->nullable();
            $table->string('department')->nullable();
            $table->string('contact', 13)->nullable();
            $table->string('email')->nullable();
            $table->timestamp('reported_at')->useCurrent();

            // Detail Masalah
            $table->string('category')->nullable(); // Hardware, Software, Network, dll
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('asset_id')->nullable()->constrained('asset')->onDelete('set null');
            $table->string('attachment')->nullable();

            // Prioritas & Dampak
            $table->enum('priority', ['Critical', 'High', 'Medium', 'Low'])->nullable();
            $table->string('affected_users')->nullable();
            $table->string('location')->nullable();

            // Analisa & Tindakan
            $table->timestamp('handled_at')->nullable();
            $table->string('handled_by')->nullable();
            $table->text('initial_analysis')->nullable();
            $table->text('troubleshooting_steps')->nullable();
            $table->text('solution')->nullable();

            // Status Ticket (termasuk Troubleshoot dan Under Maintenance)
            $table->enum('status', [
                'Open',
                'In Progress',
                'Troubleshoot',
                'Under Maintenance',
                'Escalated',
                'Resolved',
                'Closed'
            ])->default('Open');

            // SLA & Penutupan
            $table->timestamp('resolved_at')->nullable();
            $table->integer('response_time_minutes')->nullable();
            $table->enum('user_feedback', ['Puas', 'Cukup', 'Tidak Puas'])->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

