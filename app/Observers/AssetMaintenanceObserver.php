<?php

namespace App\Observers;

use App\Models\AssetMaintenance;
use App\Models\Asset;

class AssetMaintenanceObserver
{
    public function saved(AssetMaintenance $maintenance)
    {
        if ($maintenance->status === 'done') {
            $asset = Asset::find($maintenance->asset_id);
            if ($asset) {
                // last maintenance date otomatis dari maintenance terbaru yang done
                $lastDate = AssetMaintenance::where('asset_id', $asset->id)
                                ->where('status', 'done')
                                ->latest('issue_date')
                                ->value('issue_date');

                // total cost
                $totalCost = AssetMaintenance::where('asset_id', $asset->id)
                                ->where('status', 'done')
                                ->sum('cost');

                $asset->last_maintenance_date = $lastDate;
                $asset->maintenance_cost_total = $totalCost;
                $asset->save();
            }
        }
    }

    public function deleted(AssetMaintenance $maintenance)
    {
        $asset = Asset::find($maintenance->asset_id);
        if ($asset) {
            $totalCost = AssetMaintenance::where('asset_id', $asset->id)
                            ->where('status', 'done')
                            ->sum('cost');

            $lastDate = AssetMaintenance::where('asset_id', $asset->id)
                            ->where('status', 'done')
                            ->latest('issue_date')
                            ->value('issue_date');

            $asset->maintenance_cost_total = $totalCost;
            $asset->last_maintenance_date = $lastDate;
            $asset->save();
        }
    }
}
