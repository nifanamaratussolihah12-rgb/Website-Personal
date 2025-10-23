<?php

namespace App\Http\Controllers;

use App\Models\AdditionalGoods;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetSheetImport;

class AdditionalGoodsController extends Controller
{
    // Menampilkan semua data AdditionalGoods
    public function index()
    {
        $additional = AdditionalGoods::all();
        return view('backend.v_additionalgoods.index', compact('additional'));
    }

    // Menampilkan form untuk tambah data baru
    public function create()
    {
        return view('backend.v_additionalgoods.create');
    }

    // Simpan data baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
           'kategori_id' => 'required|exists:kategori,id',
            'type_asset_id' => 'nullable|exists:type_asset,id',
            'item_name' => 'required|max:255|unique:additional_goods,item_name',
            'asset_type' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:10',
            'asset_number' => 'nullable|string|max:50',
            'qty' => 'required|integer',
            'room' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'status' => 'required|in:new,reclaim',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'catatan' => 'nullable|string',
            // tanggal masuk / purchase date
            'purchase_date'             => 'nullable|date',
            'serial_number'             => 'nullable|string|max:255',
            'model'                     => 'nullable|string|max:255',
            'varian'                     => 'nullable|string|max:255',
            'warranty_expiry'           => 'nullable|date',
            'vendor'                    => 'nullable|string|max:255',
            'harga_beli'                => 'nullable|numeric',
        ]);

        // Simpan ke DB
        AdditionalGoods::create($validated);

        return redirect()->route('backend.additionalgoods.index')->with('success', 'Data berhasil ditambahkan.');
    }


     // Menampilkan detail data berdasarkan ID
    public function show(string $id)
    {
        $item = AdditionalGoods::findOrFail($id);
        return view('backend.v_additionalgoods.show', compact('item'));
    }

    // Menampilkan form edit data
    public function edit(string $id)
    {
        $item = AdditionalGoods::findOrFail($id);
        return view('backend.v_additionalgoods.edit', compact('item'));
    }

    // Update data ke database
    public function update(Request $request, string $id)
    {
        $item = AdditionalGoods::findOrFail($id);

         // Validasi input (item_name harus unik tapi mengabaikan ID saat ini)
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'type_asset_id' => 'nullable|exists:type_asset,id',
            'item_name' => 'required|max:255|unique:additional_goods,item_name,' . $item->id,
            'asset_type' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:10',
            'asset_number' => 'nullable|string|max:50',
            'qty' => 'required|integer',
            'room' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'status' => 'required|in:new,reclaim',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'catatan' => 'nullable|string',
            
            // tanggal masuk / purchase date
            'purchase_date'             => 'nullable|date',
            'serial_number'             => 'nullable|string|max:255',
            'model'                     => 'nullable|string|max:255',
            'varian'                     => 'nullable|string|max:255',
            'warranty_expiry'           => 'nullable|date',
            'vendor'                    => 'nullable|string|max:255',
            'harga_beli'                => 'nullable|numeric',
        ]);
        //dd($validated);

        // TODO: Jika ingin handle hapus file foto lama sebelum update foto baru, tambahkan kode di sini

        // Simpan perubahan
        $item->update($validated);

        return redirect()->route('backend.additionalgoods.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus data berdasarkan ID
    public function destroy(string $id)
    {
        $item = AdditionalGoods::findOrFail($id);

        // TODO: Jika ada foto, hapus file foto lama dari storage di sini

        $item->delete();

        return redirect()->route('backend.additionalgoods.index')->with('success', 'Data berhasil dihapus.');
    }

    // Import data dari file Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Jalankan proses import menggunakan class AssetSheetImport
        Excel::import(new AssetSheetImport, $request->file('file'));

        // Setelah import, proses data tambahan dari tabel Asset
        $this->processFromAsset();

        return redirect()->back()->with('success', 'Data asset berhasil diimport.');
    }

    // Proses data tambahan dari tabel Asset (khusus type_asset Elektronik)
    private function processFromAsset()
    {
        // Ambil semua asset dengan type_asset = Elektronik
        $filteredAsset = \App\Models\Asset::where('type_asset', 'Elektronik')->get();

        foreach ($filteredAsset as $asset) {
            // Update kalau asset_number sudah ada, kalau belum maka create baru
            AdditionalGoods::updateOrCreate(
                ['asset_number' => $asset->asset_number],
                [
                    'kategori_id' => $asset->kategori_id,
                    'type_asset_id' => $asset->type_asset_id,
                    'item_name' => $asset->item_name,
                    'asset_type' => $asset->asset_type,
                    'code' => $asset->code,
                    'qty' => $asset->qty,
                    'room' => $asset->room,
                    'floor' => $asset->floor,
                    'merk' => $asset->merk,
                    'status' => $asset->status,
                    'foto' => $asset->foto,
                    'catatan' => $asset->catatan,
                    
                    // kolom tambahan maintenance
                    'purchase_date'             => $asset->purchase_date,
                    'serial_number'             => $asset->serial_number,
                    'model'                     => $asset->model,
                    'varian'                     => $asset->varian,
                    'warranty_expiry'           => $asset->warranty_expiry,
                    'vendor'                    => $asset->vendor,
                    'harga_beli'                => $asset->harga_beli,
                ]
            );
        }
    }
}
