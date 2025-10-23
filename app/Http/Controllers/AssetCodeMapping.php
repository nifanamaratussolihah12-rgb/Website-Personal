<?php

namespace App\Http\Controllers;

use App\Models\AssetCodeMapping;
use Illuminate\Http\Request;

class AssetCodeMappingController extends Controller
{
    public function index()
    {
        $mappings = AssetCodeMapping::orderBy('asset_type')->orderBy('item_code')->get();
        return view('backend.asset_code_mappings.index', compact('mappings'));
    }

    public function create()
    {
        return view('backend.asset_code_mappings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_type' => 'required|string|max:255',
            'type_code' => 'required|string|max:10',
            'item_name' => 'required|string|max:255',
            'item_code' => 'required|string|max:10',
        ]);

        AssetCodeMapping::create($request->all());

        return redirect()->route('asset_code_mappings.index')->with('success', 'Mapping kode berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mapping = AssetCodeMapping::findOrFail($id);
        return view('backend.asset_code_mappings.edit', compact('mapping'));
    }

    public function update(Request $request, $id)
    {
        $mapping = AssetCodeMapping::findOrFail($id);

        $request->validate([
            'asset_type' => 'required|string|max:255',
            'type_code' => 'required|string|max:10',
            'item_name' => 'required|string|max:255',
            'item_code' => 'required|string|max:10',
        ]);

        $mapping->update($request->all());

        return redirect()->route('asset_code_mappings.index')->with('success', 'Mapping kode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mapping = AssetCodeMapping::findOrFail($id);
        $mapping->delete();

        return redirect()->route('asset_code_mappings.index')->with('success', 'Mapping kode berhasil dihapus.');
    }
}
