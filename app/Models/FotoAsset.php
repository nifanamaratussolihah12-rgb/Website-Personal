<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoAsset extends Model
{
    public $timestamps = true;
    protected $table = 'foto_asset';
    protected $guarded = ['id'];
    protected $fillable = [
        'asset_id',
        'foto'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}