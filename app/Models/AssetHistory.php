<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    use HasFactory;

    protected $table = 'asset_histories';

    protected $fillable = [
        'asset_id',
        'action',
        'status',
        'description',
        'changes',
        'user_id',
        'owner_role',
        'retention_option',  // <-- baru
        'expires_at',        // <-- baru
    ];

    protected $casts = [
        'changes' => 'array',
        'expires_at' => 'datetime', // supaya otomatis jadi Carbon object
    ];

    // relasi (asumsi ada App\Models\Asset dan App\Models\User)
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Helper statis untuk mencatat history.
     *
     * Contoh panggilan:
     * AssetHistory::log($asset, 'updated', 'Ubah serial', auth()->id(), $changedAttributes, request());
     *
     * @param mixed $asset Asset model atau asset_id
     * @param string $action
     * @param string|null $description
     * @param mixed $user User model atau user_id (optional)
     * @param array|null $changes
     * @param \Illuminate\Http\Request|null $request
     * @return static
     */
    public static function log(
        $assetId,
        $action,
        $description,
        $changes = null,
        $userId = null,
        $request = null,
        $retentionOption = null,
        $status = null  // <-- status tiket saat ini
    ) {
        // Ambil user
        $user = $userId ? \App\Models\User::find($userId) : auth()->user();
        $userId = $userId ?? $user->id ?? null;

        // Owner role
        $ownerRole = match($user->role ?? null) {
            0 => 'superadmin',
            1 => 'it',
            2 => 'ga',
            3 => 'staff',
            default => null,
        };

        // Hitung expires_at
        $expiresAt = null;
        if ($retentionOption) {
            $now = now();
            $expiresAt = match($retentionOption) {
                '3 hari' => $now->copy()->addDays(3),
                '1 minggu' => $now->copy()->addWeek(),
                '1 bulan' => $now->copy()->addMonth(),
                default => null,
            };
        }

        return static::create([
            'asset_id'        => $assetId,
            'action'          => $action,
            'description'     => $description,
            'changes'         => is_array($changes) ? json_encode($changes) : $changes,
            'user_id'         => $userId,
            'owner_role'      => $ownerRole,
            'retention_option'=> $retentionOption,
            'expires_at'      => $expiresAt,
            'status'          => $status,
        ]);
    }

    public function ticket()
    {
        return $this->belongsTo(\App\Models\Ticket::class, 'ticket_id');
    }

    public function nonAssetTicket()
    {
        return $this->belongsTo(\App\Models\NonAssetTicket::class, 'non_asset_ticket_id');
    }


}
