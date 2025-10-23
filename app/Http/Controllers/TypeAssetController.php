<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeAsset;
use App\Models\Asset;
use App\Models\AssetHistory;

class TypeAssetController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = TypeAsset::orderBy('nama_type', 'asc');

        if (in_array($user->role, [1])) { // admin/staff IT
            $query->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) { // admin/staff GA
            $query->where('owner_role', 'ga');
        }
        // super_admin (0) lihat semua, tanpa filter

        $index = $query->with('asset')->get();

        return view('backend.v_typeasset.index', [
            'judul' => 'Data Tipe Asset',
            'index' => $index
        ]);
    }

    public function create()
    {
        return view('backend.v_typeasset.create', [
            'judul' => 'Tambah Tipe Asset'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_type' => 'required|string|max:255',
            'type_prefix' => 'required|string|max:10'
        ]);

        // cek duplikat dulu
        $exists = TypeAsset::where('nama_type', $request->nama_type)->first();
        if ($exists) {
            return redirect()->back()->withInput()->with('warning', "Nama Type Asset '{$request->nama_type}' sudah ada.");
        }

        $typeAsset = TypeAsset::create($request->only(['nama_type', 'type_prefix']));

        AssetHistory::log(
            null,
            'created',
            "Tipe Asset '{$typeAsset->nama_type}' berhasil ditambahkan",
            null,
            auth()->id()
        );

        return redirect()
        ->route('backend.asset.index')
        ->with('success', 'Tipe asset berhasil ditambahkan.')
        ->with('active_tab', '#type');
    }

    public function show($id)
    {
        $type = TypeAsset::findOrFail($id);
        $user = auth()->user();

        $assetQuery = $type->asset()->orderBy('item_name', 'asc');

        if (in_array($user->role, [1])) { // Admin/Staff IT
            $assetQuery->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) { // Admin/Staff GA
            $assetQuery->where('owner_role', 'ga');
        }
        // Super Admin (0) lihat semua

        $asset = $assetQuery->get();

        return view('backend.v_typeasset.show', [
            'judul' => 'Detail Asset Berdasarkan Tipe',
            'type' => $type,
            'asset' => $asset
        ]);

    }

    public function edit($id)
    {
        $edit = TypeAsset::findOrFail($id);
        $user = auth()->user();

        $assetQuery = $edit->asset()->orderBy('item_name', 'asc');

        if (in_array($user->role, [1])) {
            $assetQuery->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) {
            $assetQuery->where('owner_role', 'ga');
        }

        $editAssets = $assetQuery->get();

        $judul = "Edit Type Asset dan Data Asset Terkait";

        return view('backend.v_typeasset.edit_with_asset', [
            'edit' => $edit,
            'judul' => $judul,
            'assets' => $editAssets
        ]);

    }

    public function detail($id)
    {
        $type_asset = TypeAsset::findOrFail($id);
        $user = auth()->user();

        $assetQuery = Asset::where('type_asset_id', $type_asset->id)->orderBy('item_name', 'asc');

        if (in_array($user->role, [1])) {
            $assetQuery->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) {
            $assetQuery->where('owner_role', 'ga');
        }

        $asset = $assetQuery->get();

        return view('backend.v_typeasset.detail', [
            'judul' => 'Detail Tipe Asset',
            'type_asset' => $type_asset,
            'asset' => $asset
        ]);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_type' => 'required|string|max:255',
            'type_prefix' => 'required|string|max:10',
            'asset.*.item_name' => 'nullable|string|max:255',
            'asset.*.qty' => 'nullable|integer|min:0',
            'asset.*.room' => 'nullable|string|max:255',
            'asset.*.merk' => 'nullable|string|max:255',
            'asset.*.asset_number' => 'nullable|string|max:255',
            'asset.*.status' => 'nullable|string|max:50',
            'asset.*.catatan' => 'nullable|string',
            // tanggal masuk / purchase date
            'asset.*.tanggal'             => 'nullable|date',
            'asset.*.serial_number'             => 'nullable|string|max:255',
            'asset.*.model'                     => 'nullable|string|max:255',
            'asset.*.spek'                     => 'nullable|string|max:255',
            'asset.*.warranty_expiry'           => 'nullable|date',
            'asset.*.official_store'              => 'nullable|string|max:255',
            'asset.*.reseller'                    => 'nullable|string|max:255',
            'asset.*.harga_beli'    => 'nullable|numeric',
            // tambahan
            'asset.*.user'        => 'nullable|string|max:255',
            'asset.*.departemen'  => 'nullable|string|max:255',
            'asset.*.site'        => 'nullable|string|max:255',
            'asset.*.kondisi'     => 'nullable|in:layak pakai,rusak,baik',
            'asset.*.history'     => 'nullable|string',

        ]);

        $typeAsset = TypeAsset::findOrFail($id);
        $typeAsset->update($request->only(['nama_type', 'type_prefix']));

        if ($request->has('asset')) {
            foreach ($request->asset as $assetData) {
                if (!empty($assetData['id'])) {
                    Asset::where('id', $assetData['id'])->update([
                        'item_name' => $assetData['item_name'] ?? null,
                        'qty' => $assetData['qty'] ?? null,
                        'room' => $assetData['room'] ?? null,
                        'merk' => $assetData['merk'] ?? null,
                        'asset_number' => $assetData['asset_number'] ?? null,
                        'status' => $assetData['status'] ?? null,
                        'catatan' => $assetData['catatan'] ?? null,
                        
                        // tambahan
                        'tanggal'             => $assetData['tanggal'] ?? null,
                        'serial_number'             => $assetData['serial_number'] ?? null,
                        'model'                     => $assetData['model'] ?? null,
                        'spek'                     => $assetData['spek'] ?? null,
                        'warranty_expiry'           => $assetData['warranty_expiry'] ?? null,
                        'official_store'              => $assetData['official_store'] ?? null,
                        'reseller'                    => $assetData['reseller'] ?? null,
                        'harga_beli'                => $assetData['harga_beli'] ?? null,
                        // tambahan
                        'user'           => $assetData['user'] ?? null,   
                        'departemen'     => $assetData['departemen'] ?? null,
                        'site'           => $assetData['site'] ?? null,
                        'kondisi'        => $assetData['kondisi'] ?? null,
                        'history'        => $assetData['history'] ?? null,
                        
                    ]);
                }
            }
        }

        // di update
        AssetHistory::log(
            null,
            'updated',
            "Tipe Asset '{$typeAsset->nama_type}' berhasil diperbarui",
            null,
            auth()->id()
        );

        return redirect()
        ->route('backend.asset.index')
        ->with('success', 'Data berhasil diperbarui.')
        ->with('active_tab', '#type');

    }

    public function destroy(string $id)
    {
        $typeasset = TypeAsset::findOrFail($id);

        // di destroy
        AssetHistory::log(
            null,
            'deleted',
            "Tipe Asset '{$typeasset->nama_type}' berhasil dihapus",
            null,
            auth()->id()
        );

        $typeasset->delete();

        return redirect()
        ->route('backend.asset.index')
        ->with('success', 'Tipe asset berhasil dihapus.')
        ->with('active_tab', '#type');

    }
}
