<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    use HasFactory;

    protected $table = 'findings';

    protected $fillable = [
        'nama_departemen',
        'lokasi_temuan',
        'tanggal_penemuan',
        'judul_temuan',
        'deskripsi_temuan',
        'form_readiness_terkait',
        'tanggal_form_readiness',
        'bukti_temuan_foto',
        'bukti_temuan_text',
        'analisis_penyebab',
        'analisis_dampak',
        'tindakan_sementara',
        'tindakan_perbaikan',
        'penanggung_jawab_tindakan',
        'target_waktu_penyelesaian',
        'status_follow_up',
        'tanggal_verifikasi',
        'hasil_verifikasi',
        'tanggal_dokumen', 
        'tanggal_expired',
        'status',       
        'catatan',
    ];

     protected $casts = [
        'tanggal_penemuan' => 'date',
        'tanggal_form_readiness' => 'date',
        'target_waktu_penyelesaian' => 'date',
        'tanggal_verifikasi' => 'date',
        'tanggal_dokumen' => 'date', 
        'tanggal_expired' => 'date',
    ];
}
