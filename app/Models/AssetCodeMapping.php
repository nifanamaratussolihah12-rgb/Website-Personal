<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCodeMapping extends Model
{
    protected $fillable = [
        'asset_type',
        'type_code',
        'item_name',
        'item_code',
    ];
}
