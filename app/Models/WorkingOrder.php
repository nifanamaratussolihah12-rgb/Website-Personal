<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingOrder extends Model
{
    use HasFactory;

    protected $table = 'working_orders';

    protected $fillable = [
    'nama', 'divisi', 'section', 'permintaan', 'jenis_pekerjaan', 
    'lokasi', 'details', 'dokumen_diterima', 'tanggal', 'target_pengerjaan',
    'task_kesiapan_listrik', 'status_kesiapan_listrik', 'reason_kesiapan_listrik', 'sign_kesiapan_listrik',
    'task_tiang', 'status_tiang', 'reason_tiang', 'sign_tiang', 'tanggal_dokumen', 'tanggal_expired',
    'task_perangkat', 'status_perangkat', 'reason_perangkat', 'sign_perangkat',
    'task_panel', 'status_panel', 'reason_panel', 'sign_panel',
    'task_keselamatan', 'status_keselamatan', 'reason_keselamatan', 'sign_keselamatan', 'status',       
    'catatan',
    ];

    protected $casts = [
    'target_pengerjaan' => 'date', // otomatis jadi Carbon
    'tanggal' => 'date', 
    'tanggal_dokumen' => 'date', 
    'tanggal_expired' => 'date', 
    'task_keselamatan' => 'array',
    'status_keselamatan' => 'array',
    'reason_keselamatan' => 'array',
    'sign_keselamatan' => 'array',
    ];

}
