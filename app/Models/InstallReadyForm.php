<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallReadyForm extends Model
{
    use HasFactory;

    protected $table = 'install_ready_forms';

    protected $fillable = [
        'project',
        'lokasi',
        'tanggal',
        'tim_pelaksana',
        'persiapan_awal',
        'k3',
        'aspek_teknis',
        'manajemen',
        'pasca',
        'catatan',
        'tanggal_dokumen', 
        'tanggal_expired',
        'status',       
        'note',
    ];

    // Agar Laravel otomatis cast json ke array
    protected $casts = [
        'tanggal' => 'date',
        'persiapan_awal' => 'array',
        'k3' => 'array',
        'aspek_teknis' => 'array',
        'manajemen' => 'array',
        'pasca' => 'array',
        'tanggal_dokumen' => 'date', 
        'tanggal_expired' => 'date',
    ];
}
