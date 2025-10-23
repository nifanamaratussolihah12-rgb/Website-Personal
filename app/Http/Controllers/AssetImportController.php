<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AssetImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Kategori;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AssetImportController extends Controller
{
    public function form()
    {
        $kategori = Kategori::all();
        return view('backend.v_asset.import', compact('kategori'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'kategori_id' => 'nullable|exists:kategori,id'
        ]);

        $file = $request->file('file');
        $kategoriId = $request->kategori_id ?? 1;

        try {
            // buat instance supaya bisa akses $duplicates & $rejectedRole
            $import = new AssetImport($kategoriId);
            Excel::import($import, $file);

            // 🔥 cek hasil import
            $totalImported = $import->totalImported ?? 0;
            $totalDuplicates = count($import->duplicates);
            $totalRejected = count($import->rejectedRole);

            if ($totalImported == 0 && $totalDuplicates > 0) {
                return redirect()->back()->with('warning', 'Semua data sudah terdaftar di database!');
            }

            $msg = "Import selesai. $totalImported data baru ditambahkan.";

            if ($totalDuplicates > 0) {
                $samples = array_slice($import->duplicates, 0, 5); // ambil 5 contoh
                $msg .= " $totalDuplicates data duplikat dilewati (contoh: " . implode(', ', $samples);
                if ($totalDuplicates > 5) $msg .= ", dan " . ($totalDuplicates - 5) . " lainnya";
                $msg .= ").";
            }

            if ($totalRejected > 0) {
                $samplesRejected = array_slice($import->rejectedRole, 0, 5);
                $msg .= " $totalRejected data ditolak (contoh: " . implode(', ', $samplesRejected);
                if ($totalRejected > 5) $msg .= ", dan " . ($totalRejected - 5) . " lainnya";
                $msg .= ").";
            }

            return redirect()->back()->with('success', $msg);
        
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        // Kalau file template sudah ada di storage/public/template.xlsx
        $filePath = storage_path('app/public/template.xlsx');

        if (!file_exists($filePath)) {
            abort(404, 'Template tidak ditemukan.');
        }

        return response()->download($filePath, 'template_asset.xlsx');
    }

}
