<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalGoods extends Model
{
    protected $table = 'additional_goods';

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
}
