<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CodeReferenceSheetImport implements ToCollection
{
    protected $codeMapping = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Pastikan baris tidak kosong dan kolom 0 dan 1 ada isinya
            if (isset($row[0]) && isset($row[1]) && !empty(trim($row[0])) && !empty(trim($row[1]))) {
                $kode = trim($row[0]);
                $kategori = trim($row[1]);
                // Simpan mapping dengan kategori huruf kecil (lowercase)
                $this->codeMapping[$kode] = strtolower($kategori);
            }
        }
    }

    public function getMapping(): array
    {
        return $this->codeMapping;
    }
}
