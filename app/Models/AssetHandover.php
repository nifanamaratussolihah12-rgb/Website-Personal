<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHandover extends Model
{
    use HasFactory;

    protected $table = 'asset_handovers';
    protected $fillable = ['nama_formulir'];
}
