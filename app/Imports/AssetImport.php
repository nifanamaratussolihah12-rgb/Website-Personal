<?php
namespace App\Imports;

use App\Models\Asset;
use App\Models\TypeAsset;
use App\Models\Kategori;
use App\Models\Fixed;
use App\Models\AdditionalGoods;
use App\Models\ConsumableGoods;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssetImport implements ToModel, WithHeadingRow
{
    public $duplicates = []; // simpan asset_number duplikat
    public $rejectedRole = [];
    public $totalImported = 0;

    public function model(array $row)
    {
        $kategoriCode  = $row['kategori'] ?? null;
        $typeAssetCode = $row['type_asset'] ?? null;
        $itemName      = $row['item_name'] ?? null;

        if (!$kategoriCode || !$typeAssetCode || !$itemName) return null;

        // cari kategori & type asset
        $kategori = Kategori::where('nama_kategori', $kategoriCode)
                    ->orWhere('kategori_prefix', $kategoriCode)
                    ->first();
        $typeAsset  = TypeAsset::where('type_prefix', $typeAssetCode)->first();

        $kategoriId   = $kategori?->id;
        $kategoriName = $kategori?->nama_kategori ?? 'Unknown';
        $namaType     = $typeAsset?->nama_type ?? 'Unknown';

        // 🔒 cek duplikat asset_number
        $assetNumber = $row['asset_number'] ?? null;
        if ($assetNumber && Asset::where('asset_number', $assetNumber)->exists()) {
            $this->duplicates[] = $assetNumber;
            return null; // skip duplikat
        }

        // 🔒 role check
        $loginUser = Auth::user();
        $fileOwnerRole = strtolower($row['owner_role'] ?? '');

        switch ($loginUser->role) {
            case 1: // Admin IT
                $ownerRole = 'it';
                break;

            case 2: // Admin GA
                $ownerRole = 'ga';
                break;

            case 0: // Super Admin
            case 3: // Staff
                // super admin & staff bisa import semua tanpa batasan
                $ownerRole = $fileOwnerRole ?: null;
                break;

            default:
                $ownerRole = null;
                break;
        }

        // ✅ batasi hanya untuk admin IT & GA yang harus cocok
        if (in_array($loginUser->role, [1, 2])) {
            if ($fileOwnerRole && $fileOwnerRole !== $ownerRole) {
                $this->rejectedRole[] = $assetNumber ?? $itemName;
                return null;
            }
        }

        // ambil user dari excel
        $user = $row['user'] ?? null;
        if (is_array($user)) {
            $user = $user['nama'] ?? null;
        } elseif (is_string($user) && $this->isJson($user)) {
            $userArray = json_decode($user, true);
            $user = $userArray['nama'] ?? null;
        }

        // 🔹 Tentukan asset_kind otomatis dari kategori
        $assetKind = $kategori?->asset_kind ?? 'physical'; // default kalau kategori null

        // 🟢 Tambahkan counter sebelum create
        $this->totalImported++;

        // insert asset
        $newAsset = Asset::create([
            'kategori_id'   => $kategoriId,
            'type_asset_id' => $typeAsset?->id,
            'asset_kind'    => $assetKind,
            'status'        => $row['status'] ?? 'new',
            'foto'          => null,
            'asset_type'    => $namaType,
            'code'          => $row['code'] ?? null,
            'asset_number'  => $assetNumber,
            'item_name'     => $itemName,
            'qty'           => $row['qty'] ?? 1,
            'room'          => $row['room'] ?? null,
            'floor'         => $row['floor'] ?? null,
            'merk'          => $row['merk'] ?? null,
            'catatan'       => $row['catatan'] ?? null,
            'user'          => $user,
            'departemen'    => $row['departemen'] ?? null,
            'site'          => $row['site'] ?? null,
            'model'         => $row['model'] ?? null,
            'spek'          => $row['spek'] ?? null,
            'kondisi'       => $row['kondisi'] ?? null,
            'history'       => $row['history'] ?? null,
            'tanggal'       => $this->transformDate($row['tanggal'] ?? null),
            'serial_number' => $row['serial_number'] ?? null,
            'warranty_expiry'=> $this->transformDate($row['warranty_expiry'] ?? null),
            'official_store' => $row['official_store'] ?? null,
            'reseller'       => $row['reseller'] ?? null,
            'harga_beli'    => $row['harga_beli'] ?? null,
            'owner_role'    => $ownerRole,
        ]);

        // sub tabel
        switch ($kategoriName) {
            case 'Fixed':
                Fixed::create(['asset_id' => $newAsset->id] + $newAsset->toArray());
                break;
            case 'Additional Goods':
                AdditionalGoods::create(['asset_id' => $newAsset->id] + $newAsset->toArray());
                break;
            case 'Consumable Goods':
                ConsumableGoods::create(['asset_id' => $newAsset->id] + $newAsset->toArray());
                break;
        }

        return $newAsset;
    }

    private function transformDate($value, $format = 'Y-m-d')
    {
        if (!$value) return null;
        try {
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value))->format($format);
            }
            return Carbon::parse($value)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function getImportSummaryMessage()
    {
        $msg = "Import selesai. ";

        if ($this->totalImported > 0) {
            $msg .= "{$this->totalImported} data baru ditambahkan.";
        }

        if (count($this->duplicates) > 0) {
            $samples = array_slice($this->duplicates, 0, 5);
            $msg .= " " . count($this->duplicates) . " data duplikat dilewati (contoh: "
                . implode(', ', $samples);

            if (count($this->duplicates) > 5) {
                $msg .= ", dan " . (count($this->duplicates) - 5) . " lainnya";
            }

            $msg .= ").";
        }

        if (count($this->rejectedRole) > 0) {
            $msg .= " " . count($this->rejectedRole) . " data ditolak karena tidak sesuai role.";
        }

        return $msg;
    }

}
