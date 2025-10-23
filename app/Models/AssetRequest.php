<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_type',
        'request_type_extra',
        'tipe_penyerahan',
        'new_asset_number', 
        'request_ref_num',
        'nik',
        'dept',
        'section',
        'asset_type',
        'details',
        'tanggal_dokumen', 
        'tanggal_expired',
        'status',       
        'catatan',
    ];

    protected $casts = [
        'details' => 'array', // otomatis ubah JSON ke array saat diambil
        'tanggal_dokumen' => 'date', 
        'tanggal_expired' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(AssetRequestItem::class);
    }

}