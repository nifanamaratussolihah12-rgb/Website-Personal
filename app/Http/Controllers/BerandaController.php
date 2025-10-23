<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use App\Models\Asset;
use App\Models\User;

class BerandaController extends Controller
{
    public function berandaBackend()
    {
        $user = Auth::user();

        // 🔥 Buat query dasar asset sesuai role
        $assetQuery = Asset::query();

        if (in_array($user->role, [1,3])) {
            // admin/staff IT
            $assetQuery->where('owner_role', 'it');
        } elseif (in_array($user->role, [2,4])) {
            // admin/staff GA
            $assetQuery->where('owner_role', 'ga');
        }
        // super_admin (0) bisa lihat semua asset

        // Total Asset (filter AKM unit)
        $totalAssetAkm = (clone $assetQuery)->where('asset_number', 'like', '%/AKM/%')->count();
        $totalAsset    = $assetQuery->count();

        // Total User sesuai role login
        if ($user->role == 0) {
            $totalUser = User::count(); // super_admin lihat semua
        } elseif ($user->role == 1) {
            $totalUser = User::whereIn('role', [1])->count(); // admin IT lihat staff/admin IT
        } elseif ($user->role == 2) {
            $totalUser = User::whereIn('role', [2])->count(); // admin GA lihat staff/admin GA
        } else {
            $totalUser = null; // staff IT/GA atau role lain tidak dihitung
        }

        // Total Qty sesuai role
        $totalQty = (clone $assetQuery)->sum('qty');

        // Daftar perusahaan sesuai role
        $companies = (clone $assetQuery)
            ->select(DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(asset_number,'/',2),'/',-1) as company"))
            ->distinct()
            ->pluck('company');

        // Asset Donuts by Type
        $assetByType = (clone $assetQuery)
            ->select('asset_type', DB::raw('COUNT(*) as total'))
            ->where('asset_number', 'LIKE', '%/AKM/%')
            ->groupBy('asset_type')
            ->pluck('total', 'asset_type');

        // Asset Donuts by Category
        $assetByCategory = (clone $assetQuery)
            ->with('kategori')
            ->where('asset_number', 'LIKE', '%/AKM/%')
            ->get()
            ->groupBy(fn($asset) => $asset->kategori->nama_kategori ?? 'Unknown')
            ->map(fn($group) => $group->count());

        // Qty per item khusus unit AKM
        $akmItems = (clone $assetQuery)
            ->where('asset_number', 'like', '%/AKM/%')
            ->select('item_name', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('item_name')
            ->orderBy('item_name')
            ->get();

        return view('backend.v_beranda.index', [
            'judul'           => 'Halaman Beranda',
            'role'            => $user->role,
            'totalAsset'      => $totalAssetAkm,
            'totalUser'       => $totalUser,
            'totalQty'        => $totalQty,
            'companies'       => $companies,
            'assetByType'     => $assetByType,
            'assetByCategory' => $assetByCategory,
            'akmItems'        => $akmItems,
        ]);
    }
}
