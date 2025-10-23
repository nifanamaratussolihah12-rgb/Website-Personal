<?php

namespace App\Http\Controllers;

use App\Models\ConsumableGoods;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetSheetImport;

class ConsumableGoodsController extends Controller
{
    public function index()
    {
        $consumables = ConsumableGoods::all();
        return view('backend.v_consumablegoods.index', compact('consumables'));
    }

    public function create()
    {
        return view('backend.v_consumablegoods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'type_asset_id' => 'nullable|exists:type_asset,id',
            'item_name' => 'required|max:255|unique:consumable_goods,item_name',
            'asset_type' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'asset_number' => 'nullable|string|max:255',
            'qty' => 'required|integer|min:1',
            'room' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
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

        ConsumableGoods::create($validated);

        return redirect()->route('consumable.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $item = ConsumableGoods::findOrFail($id);
        return view('backend.v_consumablegoods.show', compact('item'));
    }

    public function edit(string $id)
    {
        $item = ConsumableGoods::findOrFail($id);
        return view('backend.v_consumablegoods.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = ConsumableGoods::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'type_asset_id' => 'nullable|exists:type_asset,id',
            'item_name' => 'required|max:255|unique:consumable_goods,item_name,' . $item->id,
            'asset_type' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'asset_number' => 'nullable|string|max:255',
            'qty' => 'required|integer|min:1',
            'room' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
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

        $item->update($validated);

        return redirect()->route('consumable.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $item = ConsumableGoods::findOrFail($id);
        $item->delete();

        return redirect()->route('consumable.index')->with('success', 'Data berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new AssetSheetImport, $request->file('file'));

        $this->processToConsumableGoods();

        return redirect()->back()->with('success', 'Data asset berhasil diimport.');
    }

    private function processToConsumableGoods()
    {
        $asset = \App\Models\Asset::all();

        foreach ($asset as $asset) {
            // Filter berdasarkan code yang kamu definisikan untuk consumable goods
            if (in_array($asset->code, ['07', '08'])) {
                if (!ConsumableGoods::where('asset_number', $asset->asset_number)->exists()) {
                    ConsumableGoods::create($asset->toArray());
                }
            }
        }
    }
}
