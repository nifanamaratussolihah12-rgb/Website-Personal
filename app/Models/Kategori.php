<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; // nama tabel tidak jamak

    protected $fillable = ['nama_kategori', 'kategori_prefix', 'owner_role', 'asset_kind'];

    // Relasi ke Asset
    public function asset()
    {
        return $this->hasMany(Asset::class, 'kategori_id', 'id'); // pastikan foreign key-nya sama di tabel asset
    }

     public function fixed()
    {
        return $this->hasMany(Fixed::class);
    }

    public function additionalGoods()
    {
        return $this->hasMany(AdditionalGoods::class);
    }

    public function consumableGoods()
    {
        return $this->hasMany(ConsumableGoods::class);
    }
}