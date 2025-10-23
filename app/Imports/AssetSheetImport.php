<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AssetSheetImport implements WithMultipleSheets
{
    protected $codeReference;

    public function __construct()
    {
        // Inisialisasi referensi kode yang akan digunakan sebagai acuan di sheet lain
        $this->codeReference = new CodeReferenceSheetImport();
    }

    public function sheets(): array
    {
        return [
            // Sheet 0 dan Sheet 1 menggunakan class AssetRowImport yang menerima referensi kode
            0 => new AssetRowImport($this->codeReference),
            1 => new AssetRowImport($this->codeReference),

            // Sheet 2 berisi data mapping kode
            2 => $this->codeReference,
        ];
    }
}
