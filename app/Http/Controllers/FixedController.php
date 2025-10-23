<?php

namespace App\Http\Controllers;

use App\Models\Fixed;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Imports\AssetSheetImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AssetCodeMapping;

class FixedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Fixed = Fixed::all();
        return view('backend.v_fixed.index', compact('fixed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_fixed.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'type_asset_id' => 'nullable|exists:type_asset,id',
            'item_name' => 'required|max:255|unique:fixed,item_name',
            'asset_type' => 'nullable',
            'code' => 'nullable',
            'asset_number' => 'nullable',
            'qty' => 'required|integer',
            'room' => 'nullable|string',
            'floor' => 'nullable|string',
            'merk' => 'nullable|string',
            'status' => 'required|in:new,reclaim',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|file|max:1024',
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

        $runningNumber = Fixed::count() + 1; // hitung nomor urut
        $assetNumber = $this->generateCode($request->asset_type, $request->item_name, $runningNumber);

        $validated['asset_number'] = $assetNumber;
        
        Fixed::create($validated);

        return redirect()->route('backend.fixed.index')->with('success', 'Data berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fixed = Fixed::findOrFail($id);
        return view('backend.v_fixed.show', compact('fixed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fixed = Fixed::findOrFail($id);
        return view('backend.v_fixed.edit', compact('fixed'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fixed = Fixed::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'type_asset_id' => 'nullable|exists:type_asset,id',
            'item_name' => 'required|max:255|unique:fixed,item_name,' . $id,
            'asset_type' => 'nullable',
            'code' => 'nullable',
            'asset_number' => 'nullable',
            'qty' => 'required|integer',
            'room' => 'nullable|string',
            'floor' => 'nullable|string',
            'merk' => 'nullable|string',
            'status' => 'required|in:new,reclaim',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|file|max:1024',
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

        $fixed->update($validated);

        return redirect()->route('fixed.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fixed = Fixed::findOrFail($id);
        // jika ada foto, hapus file fotonya di sini

        $fixed->delete();

        return redirect()->route('fixed.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new AssetSheetImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data asset berhasil diimport.');
    }

    public function processFromAsset()
    {
        // contoh filter: item_name dan type_asset tertentu
        $filterItemName = ['Laptop A', 'Printer B']; // contoh
        $filterTypeAsset = ['Infranstruktur IT', 'Fixed']; // contoh

        $asset = Asset::whereIn('item_name', $filterItemName)
                        ->whereIn('asset_type', $filterTypeAsset)
                        ->get();

        foreach ($asset as $asset) {
            Fixed::updateOrCreate(
                ['item_name' => $asset->item_name],
                [
                    'kategori_id' => $asset->kategori_id,
                    'type_asset_id' => $asset->type_asset_id,
                    'asset_type' => $asset->asset_type,
                    'code' => $asset->code,
                    'asset_number' => $asset->asset_number,
                    'qty' => $asset->qty,
                    'room' => $asset->room,
                    'floor' => $asset->floor,
                    'merk' => $asset->merk,
                    'status' => $asset->status,
                    'catatan' => $asset->catatan ?? null,
                    'foto' => $asset->foto,
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

        return redirect()->back()->with('success', 'Data Fixed Asset berhasil diupdate dari asset.');
    }

    private function generateCode($assetType, $itemName, $runningNumber = 1)
    {
    $mapping = AssetCodeMapping::where('asset_type', $assetType)
        ->where('item_name', $itemName)
        ->first();

    if (!$mapping) {
        return null; // atau kasih default
    }

    // Ambil nomor urut terakhir dari asset_number yang sesuai pattern
    $lastAsset = Fixed::where('code', $mapping->item_code)
        ->orderBy('id', 'desc')
        ->first();

    $lastNumber = 0;
    if ($lastAsset && preg_match('/(\d{4})$/', $lastAsset->asset_number, $matches)) {
        $lastNumber = intval($matches[1]);
    }

    $nextNumber = $lastNumber + 1;
    $formattedNumber = str_pad($runningNumber, 4, '0', STR_PAD_LEFT);
    return "{$mapping->type_code}/AKM/{$mapping->item_code}/{$formattedNumber}";
    }
}
