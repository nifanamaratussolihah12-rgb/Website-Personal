<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetItemCode extends Model
{
    use HasFactory;

    protected $table = 'asset_item_code';

    protected $fillable = [
        'type_asset_id',
        'item_name',
        'item_code',
    ];

    public function typeAsset()
    {
        return $this->belongsTo(TypeAsset::class, 'type_asset_id');
    }

    /**
     * Cari data berdasarkan nama asset (ambil kata pertama saja)
     */
    public static function findByFirstWord($fullName, $typeAssetId)
    {
        $firstWord = strtoupper(trim(strtok($fullName, ' ')));
        return self::where('type_asset_id', $typeAssetId)
          ->whereRaw('UPPER(item_name) LIKE ?', ["{$firstWord}%"])
          ->first();
    }

}
