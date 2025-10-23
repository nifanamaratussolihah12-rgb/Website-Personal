<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAsset extends Model
{
    use HasFactory;
    protected $table = 'type_asset'; // karena nama tabel bukan jamak

    protected $fillable = ['nama_type', 'type_prefix', 'owner_role'];

    // Relasi ke Asset
    public function asset()
    {
        return $this->hasMany(Asset::class, 'type_asset_id');
    }

    public function itemCodes()
    {
        return $this->hasMany(AssetItemCode::class, 'type_asset_id');
    }

}
