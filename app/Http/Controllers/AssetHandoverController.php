<?php

namespace App\Http\Controllers;

use App\Models\AssetHandover;
use App\Models\TypeAsset;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AssetHandoverController extends Controller
{
    // Tampilkan daftar jenis formulir
    public function index()
    {
        $formulir = AssetHandover::all(); // daftar tipe formulir
        return view('backend.v_assethandover.index', compact('formulir'));
    }

    // Aksi buat form → redirect ke create di AssetHandoverFormController
    public function buat($id)
    {
        if ($id == 1) {
        // Serah Terima Asset IT
        return redirect()->route('asset_handoverforms.create');
        } elseif ($id == 2) {
            // Peralihan Asset IT
            return redirect()->route('asset_transfer.create');
        } elseif ($id == 3) {
            // Working Order
            return redirect()->route('workingorder.create');
        } elseif ($id == 4) {
            // Permintaan Asset IT
            return redirect()->route('assetrequest.create');
        } elseif ($id == 5) {
            // Permintaan Asset IT
            return redirect()->route('installreadyform.create');
        } elseif ($id == 6) {
            // Finding
            return redirect()->route('finding.create');
        } elseif ($id == 7) {
            // Permintaan Perbaikan Perangkat It
            return redirect()->route('f3pit.create');
        } elseif ($id == 8) {
            // Permintaan Perbaikan Perangkat It
            return redirect()->route('loginrequest.create');
        } else {
            abort(404, 'Formulir tidak ditemukan');
        }
    }

}
