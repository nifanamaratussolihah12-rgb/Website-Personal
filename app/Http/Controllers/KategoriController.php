<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\AssetHistory;

class KategoriController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Kategori::orderBy('nama_kategori', 'asc');

        switch ($user->role) {
            case 1: // Admin IT
                $query->where('owner_role', 'it');
                break;

            case 2: // Admin GA
                $query->where('owner_role', 'ga');
                break;

            case 0: // Super Admin -> no filter
            default:
                break;
        }

        $data = $query->get();

        return view('backend.v_kategori.index', [
            'judul' => 'Data Kategori Asset',
            'index' => $data
        ]);
    }

    public function create()
    {
        return view('backend.v_kategori.create', [
            'judul' => 'Tambah Kategori Asset',
            'assetKinds' => [
                'physical' => 'Asset Fisik',
                'service' => 'Layanan / Non-Fisik'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
            'kategori_prefix' => 'required|string|max:10',
            'asset_kind' => 'required|in:physical,service', // ✅ tambahkan validasi
        ]);

        $user = auth()->user();
        $role = null;

        if (in_array($user->role, [1])) { // Admin/Staff IT
            $role = 'it';
        } elseif (in_array($user->role, [2])) { // Admin/Staff GA
            $role = 'ga';
        }

        $kategori = Kategori::create([
            'nama_kategori'   => $request->nama_kategori,
            'kategori_prefix' => $request->kategori_prefix,
            'owner_role'      => $role,
            'asset_kind'      => $request->asset_kind, // ✅ simpan ke DB
        ]);

        AssetHistory::log(
            null,
            'created',
            "Kategori '{$kategori->nama_kategori}' berhasil ditambahkan",
            null,
            auth()->id()
        );

        return redirect()->route('backend.asset.index')
                 ->with('success', 'Kategori berhasil ditambahkan!')
                 ->with('active_tab', '#kategori');
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        $user = auth()->user();

        $assetQuery = $kategori->asset()->orderBy('item_name', 'asc');

        if (in_array($user->role, [1])) { // Admin/Staff IT
            $assetQuery->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) { // Admin/Staff GA
            $assetQuery->where('owner_role', 'ga');
        }
        // Super Admin (0) lihat semua, tidak perlu filter

        $asset = $assetQuery->get();

        return view('backend.kategori.show', [
            'judul' => 'Detail Asset Berdasarkan Kategori',
            'kategori' => $kategori,
            'asset' => $asset
        ]);

    }

    public function edit($id)
    {
        $edit = Kategori::findOrFail($id);
        $user = auth()->user();

        $assetQuery = $edit->asset();

        if (in_array($user->role, [1])) {
            $assetQuery->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) {
            $assetQuery->where('owner_role', 'ga');
        }

        $editAssets = $assetQuery->get();

        $judul = "Edit Kategori dan Data Asset Terkait";

        return view('backend.v_kategori.edit_with_asset', [
            'edit' => $edit,
            'judul' => $judul,
            'assets' => $editAssets
        ]);

    }

    public function detail($id)
    {
        $kategori = Kategori::findOrFail($id);
        $user = auth()->user();

        $assetQuery = $kategori->asset()->orderBy('item_name', 'asc');

        if (in_array($user->role, [1])) {
            $assetQuery->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) {
            $assetQuery->where('owner_role', 'ga');
        }

        $asset = $assetQuery->get();

        return view('backend.v_kategori.detail', [
            'judul' => 'Detail Kategori Asset',
            'kategori' => $kategori,
            'asset' => $asset
        ]);

    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $user = auth()->user();

        // Batasi update sesuai owner_role
        if (
            (in_array($user->role, [1]) && $kategori->owner_role !== 'it') ||
            (in_array($user->role, [2]) && $kategori->owner_role !== 'ga')
        ) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah kategori ini.');
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->id,
            'kategori_prefix' => 'required|string|max:10',
            'asset' => 'nullable|array'
        ]);

        // Update kategori
        $kategori->update([
            'nama_kategori'   => $validated['nama_kategori'],
            'kategori_prefix' => $validated['kategori_prefix'],
        ]);


        // Update aset terkait jika ada
        if (!empty($validated['asset'])) {
            foreach ($validated['asset'] as $assetData) {
                $asset = Asset::find($assetData['id']);
                if ($asset) {
                    $asset->update([
                        'item_name'     => $assetData['item_name'] ?? $asset->item_name,
                        'qty'           => $assetData['qty'] ?? $asset->qty,
                        'room'          => $assetData['room'] ?? $asset->room,
                        'merk'          => $assetData['merk'] ?? $asset->merk,
                        'status'        => $assetData['status'] ?? $asset->status,
                        'catatan'       => $assetData['catatan'] ?? $asset->catatan,
                        // tanggal masuk / purchase date
                        'tanggal'             => $assetData['tanggal'] ?? $asset->tanggal,
                        'serial_number'             => $assetData['serial_number'] ?? $asset->serial_number,
                        'model'                     => $assetData['model'] ?? $asset->model,
                        'spek'                     => $assetData['spek'] ?? $asset->spek,
                        'warranty_expiry'           => $assetData['warranty_expiry'] ?? $asset->warranty_expired,
                        'official_store'              => $assetData['official_store'] ?? $asset->official_store,
                        'reseller'                    => $assetData['reseller'] ?? $asset->reseller,
                        'harga_beli'                => $assetData['harga_beli'] ?? $asset->harga_beli,
                        // tambahan
                        'user'           => $assetData['user'] ?? $asset->user,   
                        'departemen'     => $assetData['departemen'] ?? $asset->departemen,
                        'site'           => $assetData['site'] ?? $asset->site,
                        'kondisi'        => $assetData['Kondisi'] ?? $asset->kondisi,
                        'history'        => $assetData['History'] ?? $asset->history,
                        
                    ]);
                }
            }
        }

        //dd($validated); // sekarang pasti muncul
        // Setelah update kategori dan asset terkait
        AssetHistory::log(
            null,
            'updated',
            "Kategori '{$kategori->nama_kategori}' berhasil diperbarui",
            null, // bisa diisi array perubahan jika mau lebih detail
            auth()->id()
        );

        return redirect()
        ->route('backend.asset.index')
        ->with('success', 'Data kategori berhasil diperbarui.')
        ->with('active_tab', '#kategori');

    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $user = auth()->user();

        if (
            (in_array($user->role, [1]) && $kategori->owner_role !== 'it') ||
            (in_array($user->role, [2]) && $kategori->owner_role !== 'ga')
        ) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus kategori ini.');
        }

        AssetHistory::log(
            null,
            'deleted',
            "Kategori '{$kategori->nama_kategori}' berhasil dihapus",
            null,
            auth()->id()
        );

        $kategori->delete();

        return redirect()
        ->route('backend.asset.index')
        ->with('success', 'Kategori asset berhasil dihapus.')
        ->with('active_tab', '#kategori');

    }

}
