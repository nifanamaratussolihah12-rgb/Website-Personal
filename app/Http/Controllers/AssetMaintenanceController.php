<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\User;
use App\Models\AssetHistory;

class AssetMaintenanceController extends Controller
{
    // Tampilkan semua maintenance
    public function index()
    {
        $user = auth()->user();

        $maintenancesQuery = AssetMaintenance::with('asset', 'handledBy')->latest();

        // Filter asset sesuai role user
        switch ($user->role) {
            case 1:  // IT
                $maintenancesQuery->whereHas('asset', function($q) {
                    $q->where('owner_role', 'it');
                });
                break;
            case 2:  // GA
                $maintenancesQuery->whereHas('asset', function($q) {
                    $q->where('owner_role', 'ga');
                });
                break;
            case 0: // Super Admin
            default:
                break; // super admin lihat semua
        }

        $maintenances = $maintenancesQuery->get();

        return view('backend.v_assetmaintenance.index', compact('maintenances'));
    }

    // Form tambah maintenance baru
    public function create()
    {
        $userLogin = auth()->user();

        // Ambil asset sesuai role user login
        $assetQuery = Asset::orderBy('item_name', 'asc');
        switch ($userLogin->role) {
            case 1: // Admin IT
                $assetQuery->where('owner_role', 'it');
                break;

            case 2: // Admin GA
                $assetQuery->where('owner_role', 'ga');
                break;

            case 0: // Super Admin -> tampil semua
            default:
                break;
        }
        $asset = $assetQuery->get();

        // Ambil user sesuai role user login
        $userQuery = User::orderBy('nama', 'asc');
        switch ($userLogin->role) {
            case 1: // Admin IT
                $userQuery->whereIn('role', [1]); // Admin IT & Staff IT
                break;

            case 2: // Admin GA
                $userQuery->whereIn('role', [2]); // Admin GA & Staff GA
                break;

            case 0: // Super Admin -> semua user
            default:
                break;
        }
        $user = $userQuery->get();

        return view('backend.v_assetmaintenance.create', compact('asset','user'));
    }

    // Simpan maintenance baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_id'        => 'nullable|exists:tickets,id',
            'non_asset_ticket_id'        => 'nullable|exists:non_asset_tickets,id',
            'asset_id'         => 'required|exists:asset,id',
            'issue_date'       => 'nullable|date',
            'maintenance_type' => 'nullable|in:preventive,corrective,replace',
            'schedule_date'    => 'nullable|date',
            'cost'             => 'nullable|numeric',
            'priority'         => 'nullable|in:Top Urgent,Urgent,Medium,Low',
            'handled_by'       => 'nullable|exists:user,id',
            'status'           => 'nullable|in:pending,done,cancelled',
            'notes'            => 'nullable|string',
        ]);

        $maintenance = AssetMaintenance::create($data);

        // Catat ke history
        AssetHistory::log(
            $maintenance->asset_id, // hubungkan ke asset yang di-maintenance
            'maintenance',
            "Maintenance baru ({$maintenance->maintenance_type}) untuk asset {$maintenance->asset->item_name} ditambahkan",
            null, // tidak ada changes detail untuk create
            auth()->id()
        );


        // Update last maintenance date otomatis
        if ($maintenance->status === 'done') {
            $maintenance->last_maintenance_date = $maintenance->schedule_date;
            $maintenance->save();
        }

        return redirect()->route('backend.asset-maintenance.index')
                        ->with('success', 'Maintenance berhasil ditambahkan.');
    }

    // Tampilkan detail maintenance
    public function show($id)
    {
        $maintenance = AssetMaintenance::with('asset', 'handledBy')->findOrFail($id);
        return view('backend.v_assetmaintenance.show', compact('maintenance'));
    }

    // Form edit
    public function edit($id)
    {
        $maintenance = AssetMaintenance::findOrFail($id);
        $asset = Asset::all();
        $user  = User::all();
        return view('backend.v_assetmaintenance.edit', compact('maintenance','asset','user'));
    }

    // Update maintenance
    public function update(Request $request, $id)
    {
        $maintenance = AssetMaintenance::findOrFail($id);

        $data = $request->validate([
            'asset_id'         => 'required|exists:asset,id',
            'issue_date'       => 'nullable|date',
            'maintenance_type' => 'nullable|in:preventive,corrective,replace',
            'schedule_date'    => 'nullable|date',
            'cost'             => 'nullable|numeric',
            'priority'         => 'nullable|in:Top Urgent,Urgent,Medium,Low',
            'handled_by'       => 'nullable|exists:user,id',
            'status'           => 'nullable|in:pending,done,cancelled',
            'notes'            => 'nullable|string',
        ]);

        $original = $maintenance->getOriginal(); // data sebelum update

        $maintenance->update($data);

        // Catat perubahan ke history
        $changes = [];
        foreach ($data as $key => $value) {
            if (isset($original[$key]) && $original[$key] != $value) {
                $changes[$key] = [
                    'old' => $original[$key],
                    'new' => $value
                ];
            }
        }

        AssetHistory::log(
            $maintenance->asset_id,
            'maintenance',
            "Maintenance ({$maintenance->maintenance_type}) untuk asset {$maintenance->asset->item_name} diupdate",
            $changes,
            auth()->id()
        );

        // Update last maintenance date otomatis
        if ($maintenance->status === 'done') {
            $maintenance->last_maintenance_date = $maintenance->schedule_date;
            $maintenance->save();
        }

        return redirect()->route('backend.asset-maintenance.index')
                         ->with('success', 'Maintenance berhasil diperbarui.');
    }

    // Hapus maintenance
    public function destroy($id)
    {
        $maintenance = AssetMaintenance::findOrFail($id);

        AssetHistory::log(
            $maintenance->asset_id,
            'maintenance',
            "Maintenance ({$maintenance->maintenance_type}) untuk asset {$maintenance->asset->item_name} dihapus",
            null,
            auth()->id()
        );

        $maintenance->delete();

        return redirect()->route('backend.asset-maintenance.index')
                         ->with('success', 'Maintenance berhasil dihapus.');
    }
}
