<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\TypeAsset;
use Illuminate\Database\Eloquent\Model;

class Fixed extends Model
{
    protected $table = 'fixed';

    protected $fillable = [
        'kategori_id',
        'type_asset_id',
        'status',           // status aset: new/reclaim/dll
        'asset_type',       // furniture / electronic
        'code',
        'asset_number',
        'item_name',        // nama barang (pengganti nama_produk)
        'qty',              // pengganti stok
        'room',
        'floor',
        'merk',       
        'catatan',
        'foto',  
        'tanggal_masuk', 
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi ke model TypeAsset
    public function typeAsset()
    {
        return $this->belongsTo(TypeAsset::class, 'type_asset_id');
    }
}
