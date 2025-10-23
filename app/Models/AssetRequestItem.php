<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequestItem extends Model
{
    protected $fillable = ['asset_request_id', 'asset_id', 'qty'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function request()
    {
        return $this->belongsTo(AssetRequest::class, 'asset_request_id');
    }
}
