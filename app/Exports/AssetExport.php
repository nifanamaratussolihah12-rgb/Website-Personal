<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class AssetExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $user = Auth::user();

        $query = Asset::with('typeAsset');

        if (in_array($user->role, [1,3])) { // IT
            $query->where('owner_role', 'it');
        } elseif (in_array($user->role, [2,4])) { // GA
            $query->where('owner_role', 'ga');
        }
        // super admin lihat semua

        return $query->get()->map(function($asset) {
            return [
                'Type Asset'   => $asset->typeAsset?->type_prefix ?? '-',
                'Kategori'     => $asset->kategori?->kategori_prefix ?? '-',
                'Code'          => $asset->code,
                'User'          => $asset->user,
                'Asset Number'  => $asset->asset_number,
                'Item Name'     => $asset->item_name,
                'Qty'           => $asset->qty,
                'Room'          => $asset->room,
                'Floor'         => $asset->floor,
                'Departemen'    => $asset->departemen,
                'Site'          => $asset->site,
                'Merk'          => $asset->merk,
                'Model'         => $asset->model,
                'Spek'          => $asset->spek,
                'Kondisi'       => $asset->kondisi,
                'History'       => $asset->history,
                'Status'        => $asset->status,
                'Tanggal'       => $asset->tanggal,
                'Serial Number' => $asset->serial_number,
                'Warranty Expiry'=> $asset->warranty_expiry,
                'official_store' => $asset->official_store,
                'reseller'      => $asset->reseller,
                'Harga Beli'    => $asset->harga_beli,
                'Catatan'       => $asset->catatan,
                'Owner Role'    => $asset->owner_role,
            ];
        });
    }

    // ⚠️ HARUS ADA method headings() karena implement WithHeadings
    public function headings(): array
    {
        return [
            'Type Asset',
            'Kategori',
            'Code',
            'User',
            'Asset Number',
            'Item Name',
            'Qty',
            'Room',
            'Floor',
            'Departemen',
            'Site',
            'Merk',
            'Model',
            'Spek',
            'Kondisi',
            'History',
            'Status',
            'Tanggal',
            'Serial Number',
            'Warranty Expiry',
            'official_store',   
            'reseller',  
            'Harga Beli',
            'Catatan',
            'Owner Role',
        ];
    }
}
