<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    use HasFactory;

    protected $table = 'asset_transfers';

    protected $fillable = [
        'asset_tag', 'asset_name', 'category', 'asset_brand', 'asset_model', 'serial_number',
        'purchase_date', 'purchase_price', 'warranty_status', 'warranty_end_date',
        'prev_department', 'prev_user', 'transfer_reason', 'tanggal_dokumen', 'tanggal_expired',
        'new_department', 'new_user', 'transfer_date', 'placement_location', 'asset_condition', 'status',       
        'catatan',
    ];


    protected $casts = [
        'purchase_date' => 'date',
        'warranty_end_date' => 'date',
        'transfer_date' => 'date',
        'tanggal_dokumen' => 'date', 
        'tanggal_expired' => 'date',
    ];
}
