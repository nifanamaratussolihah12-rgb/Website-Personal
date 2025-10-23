<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class AssetRowImport implements ToCollection
{
    protected $codeReference;

    public function __construct(CodeReferenceSheetImport $codeReference)
    {
        $this->codeReference = $codeReference;
    }

    public function collection(Collection $rows)
    {
        $mapping = $this->codeReference->getMapping();

        foreach ($rows as $index => $row) {
            // Lewati header
            if ($index === 0) continue;

            $kode = isset($row[1]) ? trim($row[1]) : null;

            if (!$kode) {
                // Kalau kode kosong, skip baris ini
                continue;
            }

            $kategori = $mapping[$kode] ?? null;

            if (!$kategori) {
                // Kalau nggak ada mapping kategori, skip baris ini
                continue;
            }

            // Siapkan data umum yang akan dimasukkan
            $data = [
                'asset_type'   => $row[0] ?? null,
                'code'         => $kode,
                'asset_number' => $row[3] ?? null,
                'item_name'    => $row[4] ?? null,
                'qty'          => is_numeric($row[5]) ? (int)$row[5] : 0,
                'room'         => $row[6] ?? null,
                'floor'        => $row[7] ?? null,
                'merk'         => $row[8] ?? null,
                'catatan'      => $row[9] ?? null,
                'status'       => 'new',
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            // Insert ke tabel sesuai kategori
            switch ($kategori) {
                case 'device':
                    DB::table('devices')->insert($data);
                    break;

                case 'additional_goods':
                    DB::table('additionalgoods')->insert($data);
                    break;

                case 'consumable_goods':
                    DB::table('consumablegoods')->insert($data);
                    break;

                default:
                    // Kategori tidak dikenal, skip
                    break;
            }
        }
    }
}
