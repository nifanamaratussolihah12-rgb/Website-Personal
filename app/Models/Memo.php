<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $fillable = [
        'tgl_no_surat',
        'perihal',
        'lampiran',
        'dari_disposisi',
        'disposisi',
        'tanggal_disposisi',
        'tanggal_memo',
        'lokasi_memo',
        'nomor',
        'kepada',
        'dari_memo',
        'perihal_memo',
        'isi',
        'status',       
        'catatan',

        // TTD
        'ttd_disusun_nama',
        'ttd_disusun_jabatan',
        'ttd_diperiksa_nama',
        'ttd_diperiksa_jabatan',
        'ttd_disetujui_nama',
        'ttd_disetujui_jabatan',
    ];

    protected $casts = [
        'tanggal_disposisi' => 'date',
        'tanggal_memo' => 'date',
        'disposisi' => 'array',
        'perihal' => 'array',
    ];

    // Di Model Memo
    public function getDisposisiAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function setDisposisiAttribute($value)
    {
        $this->attributes['disposisi'] = json_encode($value);
    }

}
