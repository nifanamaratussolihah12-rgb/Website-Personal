<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'user_id',     // admin penerima notifikasi
        'message',     // pesan notifikasi
        'link',
        'is_read',     // status sudah dibaca atau belum
    ];

    // Relasi ke user (admin) yang menerima notifikasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Mutator untuk menandai notifikasi sudah dibaca
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
