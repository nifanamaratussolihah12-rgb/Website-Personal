<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetMaintenance extends Model
{
    protected $fillable = [
        'ticket_id',
        'non_asset_ticket_id',
        'asset_id',
        'issue_date',
        'maintenance_type',
        'schedule_date',
        'cost',
        'priority',
        'handled_by',
        'status',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'schedule_date' => 'date',
        'last_maintenance_date' => 'date',
        'cost' => 'decimal:2',
        //'maintenance_cost_total' => 'decimal:2',
    ];

    // Relasi ke asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    // Relasi ke user yang menangani
    public function handledBy()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    // Relasi ke ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relasi ke ticket
    public function non_asset_ticket()
    {
        return $this->belongsTo(NonAssetTicket::class, 'non_asset_ticket_id');
    }

}
