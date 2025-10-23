<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHandoverForm extends Model
{
    use HasFactory;

    protected $table = 'asset_handover_forms'; // pastikan sama dengan tabel migration

        protected $fillable = [
        'nama_user',
        'nik_user',
        'dept',
        'section',
        'tanggal',
        'tipe_asset',
        'handover_type',
        'brand_asset',   // tambahin
        'model_asset',   // tambahin
        'nama_asset',
        'asset_name',
        'model_asset',
        'asset_tag',
        'asset_sn',
        'ref_rl_acumatica',
        'handover_by',
        'handover_by_nik',
        'handover_date',
        'tanggal_dokumen', // tanggal dokumen diterbitkan
        'tanggal_expired', // tanggal kedaluwarsa
        'status',       
        'catatan',
    ];

        protected $casts = [
        'tanggal' => 'date',
        'handover_date' => 'date',
        'tanggal_dokumen' => 'date',
        'tanggal_expired' => 'date',
    ];
}
