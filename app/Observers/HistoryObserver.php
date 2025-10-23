<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\AssetHistory;
use Illuminate\Support\Facades\Auth;

class HistoryObserver
{
    public function created(Model $model)
    {
        $this->logAction($model, 'created');
    }

    public function updated(Model $model)
    {
        $changes = $model->getChanges();

        // Kalau ada perubahan status → catat 1 log khusus
        if (isset($changes['status'])) {
            $old = $model->getOriginal('status');
            $new = $changes['status'];

            $this->logAction($model, 'status_changed', [
                'status' => $new,
                'description' => $this->statusChangeDescription($model, $old, $new),
                'changes' => ['status_from' => $old, 'status_to' => $new],
            ]);

            // ⛔ stop di sini, jangan lanjut ke log update umum
            return;
        }

        // Kalau bukan perubahan status, catat log update umum
        $this->logAction($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->logAction($model, 'deleted');
    }

    protected function logAction(Model $model, string $action)
    {
        $assetId = $model->asset_id ?? null;

        // ambil status kalau ada di model
        $status = $model->status 
                ?? $model->maintenance_status 
                ?? $model->progress_status 
                ?? ($model->ticket->status ?? null) 
                ?? '-';

        $description = match (class_basename($model)) {
            'Ticket' => "Ticket #{$model->ticket_number} $action",
            'NonAssetTicket' => "Non-asset Ticket #{$model->ticket_number} $action",
            'AssetMaintenance' => match ($action) {
                'created' => "Maintenance (".($model->maintenance_type ?? '-').") untuk asset {$model->asset->item_name} dibuat",
                'updated' => "Maintenance (".($model->maintenance_type ?? '-').") untuk asset {$model->asset->item_name} diupdate",
                'deleted' => "Maintenance asset #{$assetId} dihapus",
                default => "Maintenance asset #{$assetId} $action",
            },
            default => "$action performed on ".class_basename($model),
        };

        AssetHistory::create([
            'asset_id' => $assetId,
            'action' => ucfirst($action),
            'status' => $status, 
            'description' => $description,
            'changes' => json_encode($model->getChanges() ?: $model->toArray()),
            'user_id' => Auth::id(),
            'owner_role' => match(optional(Auth::user())->role) {
                1, 3 => 'it',
                2, 4 => 'ga',
                default => null
            },
            'retention_option' => '3 hari',
            'expires_at' => now()->addDays(3),
        ]);
    }

    protected function statusChangeDescription(Model $model, $old, $new)
    {
        $assetId = $model->asset_id ?? null;

        return match (class_basename($model)) {
            'Ticket' => "Status Ticket #{$model->ticket_number} berubah dari '$old' menjadi '$new'",
            'NonAssetTicket' => "Status Non-asset Ticket #{$model->ticket_number} berubah dari '$old' menjadi '$new'",
            'AssetMaintenance' => "Status Maintenance asset #{$assetId} berubah dari '$old' menjadi '$new'",
            default => "Status ".class_basename($model)." berubah dari '$old' menjadi '$new'",
        };
    }
}
