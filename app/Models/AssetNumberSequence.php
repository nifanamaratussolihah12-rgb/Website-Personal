<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetNumberSequence extends Model
{
    use HasFactory;

    protected $table = 'asset_number_sequences';

    protected $fillable = [
        'dept',
        'section',
        'year_month',
        'last_number',
    ];
}
