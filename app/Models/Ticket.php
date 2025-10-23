<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number', 'reporter_name', 'department', 'contact', 'email',
        'category', 'subject', 'description', 'asset_id', 'attachment',
        'priority', 'affected_users', 'location',
        'handled_at', 'handled_by', 'initial_analysis', 'troubleshooting_steps', 'solution',
        'status', 'resolved_at', 'response_time_minutes', 'user_feedback', 'notes'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            // Tambahkan tanggal hari ini
            $today = now()->format('d-m-y');

            // Hitung jumlah tiket hari ini (pakai transaksi biar unik di paralel request)
            $countToday = self::whereDate('created_at', now()->toDateString())->count() + 1;

            // Format nomor tiket -> 07-10-25-001
            $ticket->ticket_number = sprintf('%s-%03d', $today, $countToday);

            // Isi otomatis reported_at kalau belum diisi
            if (!$ticket->reported_at) {
                $ticket->reported_at = now();
            }

            // Set default status jika belum dipilih
            if (!$ticket->status) {
                $ticket->status = 'Open';
            }
        });
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
