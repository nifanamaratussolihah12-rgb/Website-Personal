<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Fixed;
use App\Models\AdditionalGoods;
use App\Models\ConsumableGoods;
use App\Models\Kategori;
use App\Models\TypeAsset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AssetExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AssetHistory;

class AssetController extends Controller
{
    // ================== READ ==================
    // Menampilkan daftar asset
    public function index(Request $request)
    {
        $user = auth()->user();
        $kategori = $request->get('kategori');

        $query = Asset::query();

        // Filter berdasarkan kategori jika ada
        if ($kategori) {
            $query->whereHas('kategori', function ($sub) use ($kategori) {
                $sub->where('nama_kategori', $kategori);
            });
        }

        // 🔥 Filter berdasarkan role untuk asset
        if (in_array($user->role, [1])) { // IT
            $query->where('owner_role', 'it');
        } elseif (in_array($user->role, [2])) { // GA
            $query->where('owner_role', 'ga');
        }
        // super_admin (0) bisa lihat semua

        // Ambil data asset
        $asset = $query->orderBy('updated_at', 'desc')->get();

        // 🔹 Ambil data kategori sesuai role user
        $kategoriQuery = \App\Models\Kategori::orderBy('nama_kategori', 'asc');
        switch ($user->role) {
            case 1: // Admin IT
                $kategoriQuery->where('owner_role', 'it');
                break;

            case 2: // Admin GA
                $kategoriQuery->where('owner_role', 'ga');
                break;

            // case 3: Staff → tidak perlu filter, bisa lihat semua
            // case 0: Super Admin → bisa lihat semua
        }
        $kategoriList = $kategoriQuery->get();

        // 🔹 Ambil data type asset sesuai role user
        $typeQuery = \App\Models\TypeAsset::orderBy('nama_type', 'asc');
        switch ($user->role) {
            case 1: // Admin IT
                $typeQuery->where('owner_role', 'it');
                break;

            case 2: // Admin GA
                $typeQuery->where('owner_role', 'ga');
                break;

            // case 3: Staff → tidak perlu filter, bisa lihat semua
            // case 0: Super Admin → bisa lihat semua
        }
        $typeAssetList = $typeQuery->get();

        // 🔹 Kirim semuanya ke view
        return view('backend.v_asset.index', [
            'judul' => $request->type === 'service' ? 'Data Service Items' : 'Data Asset',
            'index' => $asset,
            'kategoriList' => $kategoriList,
            'typeAssetList' => $typeAssetList
        ]);
    }

    // ================== CREATE (Form Input) ==================
    // Menampilkan form untuk menambah asset baru
    public function create()
    {
        $user = auth()->user();

        // Ambil kategori sesuai role login & asset_kind = physical
        $kategoriQuery = Kategori::orderBy('nama_kategori', 'asc')
            ->where('asset_kind', 'physical');
        switch ($user->role) {
            case 1: $kategoriQuery->where('owner_role', 'it'); break;
            case 2: $kategoriQuery->where('owner_role', 'ga'); break;
        }
        $kategori = $kategoriQuery->get();

        // Ambil type asset sesuai role login
        $typeAssetQuery = TypeAsset::orderBy('nama_type', 'asc');
        switch ($user->role) {
            case 1: $typeAssetQuery->where('owner_role', 'it'); break;
            case 2: $typeAssetQuery->where('owner_role', 'ga'); break;
        }
        $typeAsset = $typeAssetQuery->get();

        // Ambil daftar item asset code sesuai role login
        $assetItemsQuery = \DB::table('asset_item_code')
            ->join('type_asset', 'asset_item_code.type_asset_id', '=', 'type_asset.id')
            ->select('asset_item_code.*');

        switch ($user->role) {
            case 1: $assetItemsQuery->where('type_asset.owner_role', 'it'); break;
            case 2: $assetItemsQuery->where('type_asset.owner_role', 'ga'); break;
        }

        $assetItems = $assetItemsQuery->orderBy('asset_item_code.item_name')->get();

        return view('backend.v_asset.create', [
            'judul' => 'Tambah Asset',
            'kategori' => $kategori,
            'typeAsset' => $typeAsset,
            'assetItems' => $assetItems,
            'asset_kind' => 'physical'
        ]);
    }

    public function createService()
    {
        $user = auth()->user();

        // Ambil kategori sesuai role login & asset_kind = service
        $kategoriQuery = Kategori::orderBy('nama_kategori', 'asc')
            ->where('asset_kind', 'service');
        switch ($user->role) {
            case 1: $kategoriQuery->where('owner_role', 'it'); break;
            case 2: $kategoriQuery->where('owner_role', 'ga'); break;
        }
        $kategori = $kategoriQuery->get();

        $typeAssetQuery = TypeAsset::orderBy('nama_type', 'asc');
        switch ($user->role) {
            case 1: $typeAssetQuery->where('owner_role', 'it'); break;
            case 2: $typeAssetQuery->where('owner_role', 'ga'); break;
        }
        $typeAsset = $typeAssetQuery->get();

        return view('backend.v_asset.create_service', [
            'judul' => 'Tambah Service / Non-Fisik',
            'kategori' => $kategori,
            'typeAsset' => $typeAsset,
            'assetItems' => [],
            'asset_kind' => 'service',
        ]);
    }

     // ================== STORE (Proses Simpan) ==================
    // Menyimpan asset baru ke database
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'item_name'                 => 'required|string|max:255',
            'qty'                       => 'required|integer|min:1',
            'status'                    => 'nullable|in:new,active,reclaimed,damaged,lost,disposed',
            'room'                      => 'nullable|string|max:255',
            'floor'                     => 'nullable|string|max:255',
            'merk'                      => 'nullable|string|max:255',
            'catatan'                    => 'nullable|string',
            'foto'                      => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
            'kategori_id'               => 'required|exists:kategori,id',
            'type_asset_id'             => 'required|exists:type_asset,id',
            
            // tambahan
            'tanggal'             => 'nullable|date',
            'serial_number'             => 'nullable|string|max:255',
            'model'                     => 'nullable|string',
            'spek'                      => 'nullable|string',
            'warranty_expiry'           => 'nullable|date',
            'official_store'            => 'nullable|string|max:255',
            'reseller'                  => 'nullable|string|max:255',
            'harga_beli'                => 'nullable|numeric',

            // tambahan
            'user'        => 'nullable|string|max:255',
            'departemen'  => 'nullable|string|max:255',
            'site'        => 'nullable|string|max:255',
            'kondisi'     => 'nullable|in:layak pakai,rusak,baik',
            'history'     => 'nullable|string',

        ]);
        
        //dd($request->all());

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'img-asset/';

            // Resize & simpan menggunakan helper custom
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);
            $fotoPath = $originalFileName;
        }

        // Ambil data kategori & type asset
        $kategori   = Kategori::findOrFail($request->kategori_id);
        $typeAsset  = TypeAsset::findOrFail($request->type_asset_id);

        $kategori_prefix = $kategori->kategori_prefix; // ← ambil prefix kategori
        $type_prefix     = $typeAsset->type_prefix;    // misal GA01 / IT01

        // ===== Mapping item_name ke item_code =====
        $firstWord = strtoupper(trim(strtok($request->item_name, ' '))); // ambil kata pertama dari item_name
        $mapping = \DB::table('asset_item_code')
            ->whereRaw('UPPER(item_name) LIKE ?', [$firstWord . '%'])
            ->where('type_asset_id', $request->type_asset_id)
            ->first();

        // Jika tidak ada, buat item_code baru otomatis (lanjut dari numeric terakhir)
        if (!$mapping) {
            // Cari kode numeric terakhir untuk type_asset ini
            $lastNumericItem = \DB::table('asset_item_code')
                ->where('type_asset_id', $request->type_asset_id)
                ->whereRaw('item_code REGEXP "^[0-9]+$"') // ambil hanya numeric
                ->orderByRaw('CAST(item_code AS UNSIGNED) DESC') // urut dari terbesar
                ->first();

            if ($lastNumericItem) {
                // Ambil angka terakhir lalu increment
                $nextCodeNumber = intval($lastNumericItem->item_code) + 1;
                $newCode = str_pad($nextCodeNumber, 2, '0', STR_PAD_LEFT);
            } else {
                $newCode = '01'; // default kode pertama
            }

            // Insert ke tabel mapping asset_item_code
            $mappingId = \DB::table('asset_item_code')->insertGetId([
                'item_name'     => $request->item_name,
                'item_code'     => $newCode,
                'type_asset_id' => $request->type_asset_id,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // Bentuk object mapping manual
            $mapping = (object)[
                'id'        => $mappingId,
                'item_code' => $newCode,
                'item_name' => $request->item_name,
            ];
        }

        // Ambil company dari request
        $company = $request->company;

        // Generate asset_number berdasarkan asset terakhir untuk type_asset + company ini
        $lastAsset = Asset::where('type_asset_id', $typeAsset->id)
            ->where('asset_number', 'LIKE', "%/{$company}/%") // filter per company
            ->orderBy('id', 'desc')
            ->first();

        if ($lastAsset) {
            // Ambil 4 digit terakhir lalu increment
            $lastNumber = intval(substr($lastAsset->asset_number, -4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format jadi 4 digit, contoh: 0001
        $numberFormatted = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Bentuk asset_number final, contoh: F01/AKM/05/0001
        $assetNumber = "{$kategori_prefix}/{$company}/{$mapping->item_code}/{$numberFormatted}";

        // Ambil user yang sedang login
        $user = auth()->user();

        // 🔥 Tentukan owner_role
        if ($request->has('owner_role') && $request->owner_role) {
            // Kalau ada input owner_role dari form / excel → pakai itu (import Excel bisa kirim owner_role)
            $ownerRole = $request->owner_role;
        } else {
            // Manual input → ambil dari kategori / type asset
            $ownerRole = $kategori?->owner_role ?? $typeAsset?->owner_role ?? null;
        }

        // ===== Simpan ke tabel utama Asset =====
        $newAsset = Asset::create([
            'kategori_id'               => $request->kategori_id,
            'type_asset_id'             => $request->type_asset_id,
            'asset_type'                => $typeAsset->nama_type,
            'code'                      => $mapping->item_code,
            'asset_number'              => $assetNumber,
            'item_name'                 => $request->item_name,
            'qty'                       => $request->qty,
            'room'                      => $request->room,
            'floor'                     => $request->floor,
            'merk'                      => $request->merk,
            'catatan'                   => $request->catatan,
            'foto'                      => $fotoPath,
            'status'                    => $request->status ?? 'new',

            // kolom tambahan
            'tanggal'             => $request->tanggal,
            'serial_number'             => $request->serial_number,
            'model'                     => $request->model,
            'spek'                     => $request->spek,
            'warranty_expiry'           => $request->warranty_expiry,
            'official_store'            => $request->official_store,
            'reseller'                  => $request->reseller,
            'harga_beli'                => $request->harga_beli,

            // tambahan baru
            'user'            => $request->user,
            'departemen'      => $request->departemen,
            'site'            => $request->site,
            'kondisi'         => $request->kondisi,
            'history'         => $request->history,

            // 🔥 baru taruh owner_role di sini
            'owner_role'    => $ownerRole,
            'asset_kind'    => $request->asset_kind ?? 'physical',
            
        ]);

        // ===== Simpan juga ke tabel khusus sesuai kategori =====
        $kategori = Kategori::findOrFail($request->kategori_id);
        switch ($kategori->nama_kategori) {
            case 'Fixed':
                Fixed::create($newAsset->toArray());
                break;
            case 'Additional Goods':
                AdditionalGoods::create($newAsset->toArray());
                break;
            case 'Consumable Goods':
                ConsumableGoods::create($newAsset->toArray());
                break;
            default:
                // kalau kategori baru / tidak dikenal, tidak melakukan apa-apa
                break;
        }

        AssetHistory::log(
            $newAsset->id,                                      // ID asset
            'created',                                          // action
            "Asset {$newAsset->item_name} berhasil ditambahkan", // deskripsi ← koma di sini!
            null,                                               // $changes, kosong untuk create
            auth()->id()                                       // user_id
        );

        return redirect()->route('backend.asset.index')->with('success', 'Asset berhasil ditambahkan.');
    }

    // Menampilkan form edit untuk asset tertentu
    public function edit(string $id)
    {
        // cari asset berdasarkan ID, error 404 kalau tidak ada
        $asset = Asset::findOrFail($id);

        // ambil semua kategori, urut nama
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        // ambil semua type asset
        $typeAsset = TypeAsset::all();

        // ambil kode item
        $assetItems = \DB::table('asset_item_code')->orderBy('item_name')->get();

        // kirim data ke view edit asset
        return view('backend.v_asset.edit', [
            'judul' => 'Edit Asset',
            'edit' => $asset,
            'kategori' => $kategori,
            'typeAsset' => $typeAsset,
            'assetItems' => $assetItems,
            'asset_kind' => 'physical'
        ]);
    }

    public function editService(string $id)
    {
        $asset = Asset::findOrFail($id); // cari asset service

        $kategori = Kategori::all(); // ambil semua kategori
        $typeAsset = TypeAsset::all(); // ambil semua type asset

        // untuk service, biasanya assetItems kosong atau bisa khusus service
        $assetItems = []; 

        return view('backend.v_asset.edit_service', [
            'judul' => 'Edit Service / Non-Fisik',
            'edit' => $asset,
            'kategori' => $kategori,
            'typeAsset' => $typeAsset,
            'assetItems' => $assetItems,
            'asset_kind' => 'service',
        ]);
    }

    // Proses update asset
    public function update(Request $request, Asset $asset)
    {
        // ambil kondisi sebelum update
        $before = $asset->getOriginal();

        // Validasi input
        $request->validate([
            'item_name'                 => 'required|string|max:255',
            'qty'                       => 'required|integer|min:1',
            'status'                    => 'nullable|in:new,active,reclaimed,damaged,lost,disposed',
            'room'                      => 'nullable|string|max:255',
            'floor'                     => 'nullable|string|max:255',
            'merk'                      => 'nullable|string|max:255',
            'catatan'                    => 'nullable|string',
            'foto'                      => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
            'kategori_id'               => 'required|exists:kategori,id',
            'type_asset_id'             => 'required|exists:type_asset,id',
            
            // tambahan
            'tanggal'             => 'nullable|date',
            'serial_number'             => 'nullable|string|max:255',
            'model'                     => 'nullable|string',
            'spek'                      => 'nullable|string',
            'warranty_expiry'           => 'nullable|date',
            'official_store'            => 'nullable|string|max:255',
            'reseller'                  => 'nullable|string|max:255',
            'harga_beli'                => 'nullable|numeric',

            // tambahan
            'user'        => 'nullable|string|max:255',
            'departemen'  => 'nullable|string|max:255',
            'site'        => 'nullable|string|max:255',
            'kondisi'     => 'nullable|in:layak pakai,rusak,baik',
            'history'     => 'nullable|string',

        ]);

        // Default pakai foto lama
        $fotoPath = $asset->foto; 

        // Jika ada foto baru diupload → hapus foto lama, simpan foto baru
        if ($request->hasFile('foto')) {
            if ($asset->foto && file_exists(storage_path('app/public/img-asset/' . $asset->foto))) {
                unlink(storage_path('app/public/img-asset/' . $asset->foto));
            }
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'img-asset/';
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400);
            $fotoPath = $originalFileName;
        }

        // Ambil type asset sesuai input
        $typeAsset = TypeAsset::findOrFail($request->type_asset_id);

        // Kalau type_asset berubah, regenerasi item_code
        $newItemCode = $asset->code; // default pakai kode lama

        // Update prefix asset_number kalau kategori_id berubah
        $newAssetNumber = $asset->asset_number; // default tetap
        if ($asset->kategori_id != $request->kategori_id) {
            // ambil prefix baru dari tabel kategori
            $kategoriBaru = Kategori::find($request->kategori_id);
            $prefixBaru   = $kategoriBaru->kategori_prefix ?? null;

            if (!empty($asset->asset_number) && $prefixBaru) {
                $parts = explode('/', $asset->asset_number);
                if (count($parts) > 1) {
                    $parts[0] = $prefixBaru; // replace prefix lama pakai kategori_prefix baru
                    $newAssetNumber = implode('/', $parts);
                }
            }
        }

        if ($asset->type_asset_id != $request->type_asset_id) {
            // cari item_code terakhir di type asset baru
            $lastCode = \DB::table('asset_item_code')
                ->where('type_asset_id', $request->type_asset_id)
                ->max('item_code');

            $nextCode = $lastCode ? str_pad(((int)$lastCode) + 1, 2, '0', STR_PAD_LEFT) : '01';

            // insert mapping baru untuk item_name jika belum ada
            $exists = \DB::table('asset_item_code')
                ->where('type_asset_id', $request->type_asset_id)
                ->whereRaw('UPPER(item_name) = ?', [strtoupper($request->item_name)])
                ->first();

            if (!$exists) {
                \DB::table('asset_item_code')->insert([
                    'type_asset_id' => $request->type_asset_id,
                    'item_name'     => $request->item_name,
                    'item_code'     => $nextCode,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }

            $newItemCode = $exists->item_code ?? $nextCode;
        }

        // Tentukan owner_role baru
        if ($request->has('owner_role') && $request->owner_role) {
            // Jika ada owner_role dikirim (misal Excel import / super admin pilih) → pakai itu
            $ownerRole = $request->owner_role;
        } else {
            // Manual update / role biasa → ambil dari kategori/type asset baru
            $kategori   = Kategori::find($request->kategori_id);
            $typeAsset  = TypeAsset::find($request->type_asset_id);
            $ownerRole  = $kategori?->owner_role ?? $typeAsset?->owner_role ?? $asset->owner_role;
        }

        // Update data asset utama
        $asset->update([
            'kategori_id'               => $request->kategori_id,
            'type_asset_id'             => $request->type_asset_id,
            'asset_type'                => $typeAsset->nama_type,
            'code'                      => $newItemCode,
            'item_name'                 => $request->item_name,
            'qty'                       => $request->qty,
            'room'                      => $request->room,
            'floor'                     => $request->floor,
            'merk'                      => $request->merk,
            'catatan'                   => $request->catatan,
            'foto'                      => $fotoPath,
            'status'                    => $request->status,
            'asset_number'              => $newAssetNumber,

            // kolom tambahan 
            'tanggal'             => $request->tanggal,
            'serial_number'             => $request->serial_number,
            'model'                     => $request->model,
            'spek'                     => $request->spek,
            'warranty_expiry'           => $request->warranty_expiry,
            'official_store'            => $request->official_store,
            'reseller'                  => $request->reseller,
            'harga_beli'                => $request->harga_beli,

            // tambahan baru
            'user'            => $request->user,
            'departemen'      => $request->departemen,
            'site'            => $request->site,
            'kondisi'         => $request->kondisi,
            'history'         => $request->history,

            // 🔥 tetap simpan owner_role
            'owner_role'    => $ownerRole,
            
        ]);

        // ambil kondisi setelah update
        $after = $asset->fresh()->getAttributes();

        // diff sederhana: hanya field yang berubah
        $diff = [];
        foreach ($after as $key => $value) {
            $oldVal = $before[$key] ?? null;
            if ($oldVal != $value) {
                $diff[$key] = [
                    'before' => $oldVal,
                    'after'  => $value,
                ];
            }
        }

        $changes = [
            'before' => $before,
            'after'  => $after,
            'diff'   => $diff,
        ];

        // Hapus asset lama dari tabel khusus jika kategori berubah
        Fixed::where('id', $asset->id)->delete();
        AdditionalGoods::where('id', $asset->id)->delete();
        ConsumableGoods::where('id', $asset->id)->delete();

        // Simpan ke tabel khusus baru berdasarkan kategori
        $kategori = Kategori::findOrFail($request->kategori_id);
        switch ($kategori->nama_kategori) {
            case 'Fixed':
                Fixed::create($asset->toArray());
                break;
            case 'Additional Goods':
                AdditionalGoods::create($asset->toArray());
                break;
            case 'Consumable Goods':
                ConsumableGoods::create($asset->toArray());
                break;
        }

        // simpan history
        AssetHistory::log(
            $asset->id,
            'updated',
            "Asset {$asset->item_name} diupdate",
            $changes,
            auth()->id()
        );

        return redirect()->route('backend.asset.index')->with('success', 'Asset berhasil diperbarui.');
    }

    // Hapus asset
    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);

        // Hapus file foto dari storage kalau ada
        if ($asset->foto) {
            $path = storage_path('app/public/' . $asset->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        AssetHistory::log(
            $asset->id,
            'deleted',
            "Asset {$asset->item_name} dihapus",
            null, // tidak ada changes detail
            auth()->id()
        );

        // Hapus data asset dari DB
        $asset->delete();
        return redirect()->route('backend.asset.index')->with('success', 'Asset berhasil dihapus');
    }

    // Cetak laporan asset dalam bentuk PDF
    public function cetakAsset(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
        ]);

        // Ambil data asset berdasarkan range tanggal
        $asset = Asset::whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir])
            ->orderBy('id', 'desc')
            ->get();

        // Load view untuk PDF
        $pdf = Pdf::loadView('backend.asset.cetak', [
            'judul' => 'Laporan Asset',
            'tanggalAwal' => $request->tanggal_awal,
            'tanggalAkhir' => $request->tanggal_akhir,
            'cetak' => $asset
        ]);

        return $pdf->stream('Laporan_Asset.pdf'); // langsung tampilkan di browser
    }

    // Menampilkan detail asset tertentu
    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        $kategori = Kategori::all();
        return view('backend.v_asset.show', compact('asset', 'kategori'));
    }

    public function showService($id)
    {
        $asset = Asset::findOrFail($id);
        $kategori = Kategori::all();

        return view('backend.v_asset.show_service', compact('asset', 'kategori'));
    }


    // Menampilkan daftar asset berdasarkan perusahaan
    public function daftarPerusahaan($company)
    {
        $user = auth()->user();

        $ownerRole = match($user->role) {
            1 => 'it',   // Admin/Staff IT
            2 => 'ga',   // Admin/Staff GA
            default => null  // Super Admin
        };

        $assetQuery = Asset::where('asset_number', 'LIKE', '%/'.$company.'/%');

        if ($ownerRole) {
            $assetQuery->where('owner_role', $ownerRole);
        }

        $asset = $assetQuery->get();

        return view('backend.v_asset.daftar_perusahaan', [
            'judul' => "Daftar Asset $company",
            'asset' => $asset
        ]);
    }

    public function grafikPerusahaan($company)
    {
        $user = auth()->user();

        $ownerRole = match($user->role) {
            1 => 'it',
            2 => 'ga',
            default => null
        };

        $assetQuery = Asset::select('item_name', 'room', \DB::raw('SUM(qty) as total_qty'))
            ->where('asset_number', 'LIKE', '%/'.$company.'/%')
            ->groupBy('item_name', 'room');

        if ($ownerRole) {
            $assetQuery->where('owner_role', $ownerRole);
        }

        $assetGrouped = $assetQuery->get();

        $labels = $assetGrouped->map(fn($a) => $a->item_name . ' (' . $a->room . ')');
        $qty = $assetGrouped->pluck('total_qty');

        return view('backend.v_asset.grafik_perusahaan', [
            'judul' => "Grafik Stok $company",
            'company' => $company,
            'labels' => $labels,
            'qty' => $qty
        ]);
    }

    public function export(Request $request)
    {
        $exportQuery = Asset::query();

        // Filter asset berdasarkan asset_kind kalau ada di request
        if ($request->has('type') && in_array($request->type, ['physical', 'service'])) {
            $exportQuery->where('asset_kind', $request->type);
        }

        return Excel::download(new AssetExport($exportQuery), 'asset.xlsx');
    }

    public function akmByItem($item)
    {
        $user = auth()->user();

        $asset = Asset::where('asset_number', 'like', '%/AKM/%')
                    ->where('item_name', $item)
                    ->get();

        // 🔹 Ambil kategori sesuai role
        $kategoriQuery = \App\Models\Kategori::orderBy('nama_kategori', 'asc');
        switch ($user->role) {
            case 1: $kategoriQuery->where('owner_role', 'it'); break;
            case 2: $kategoriQuery->where('owner_role', 'ga'); break;
        }
        $kategoriList = $kategoriQuery->get();

        // 🔹 Ambil type asset sesuai role
        $typeQuery = \App\Models\TypeAsset::orderBy('nama_type', 'asc');
        switch ($user->role) {
            case 1: $typeQuery->where('owner_role', 'it'); break;
            case 2: $typeQuery->where('owner_role', 'ga'); break;
        }
        $typeAssetList = $typeQuery->get();

        return view('backend.v_asset.index', [
            'judul' => "Daftar Asset Unit AKM - $item",
            'index' => $asset,
            'kategoriList' => $kategoriList,
            'typeAssetList' => $typeAssetList
        ]);
    }

    public function periodGaransi()
    {
        $user = auth()->user();

        // 🔹 Tentukan filter berdasarkan role
        $assetQuery = Asset::select('id', 'item_name', 'room', 'tanggal', 'warranty_expiry', 'official_store', 'reseller', 'serial_number', 'merk', 'harga_beli');

        switch ($user->role) {
            case 1: // Admin IT
                $assetQuery->where('owner_role', 'it');
                break;

            case 2: // Admin GA
                $assetQuery->where('owner_role', 'ga');
                break;

            case 3: // Staff
                // Staff bisa lihat semua (tanpa filter owner_role)
                break;

            default:
                // Super Admin (role 0) bisa lihat semua
                break;
        }

        // 🔹 Eksekusi dan olah datanya
        $asset = $assetQuery->get()
            ->sortByDesc(function ($asset) {
                return ($asset->tanggal && $asset->warranty_expiry) ? 1 : 0;
            })
            ->values()
            ->map(function ($asset) {
                $today = now();

                $asset->umur = $asset->tanggal
                    ? $today->diffInDays(\Carbon\Carbon::parse($asset->tanggal)) . ' hari'
                    : '-';

                if ($asset->warranty_expiry) {
                    $expDate = \Carbon\Carbon::parse($asset->warranty_expiry);
                    $selisih = $today->diffInDays($expDate, false);

                    if ($selisih >= 0) {
                        $asset->sisa_garansi = $selisih . ' hari';
                        $asset->status_garansi = 'Masih Bergaransi';
                    } else {
                        $asset->sisa_garansi = abs($selisih) . ' hari lalu';
                        $asset->status_garansi = 'Garansi Habis';
                    }
                } else {
                    $asset->sisa_garansi = '-';
                    $asset->status_garansi = 'Tidak Ada Data';
                }

                return $asset;
            });

        return view('backend.v_asset.period_garansi', [
            'judul' => 'Period Garansi Asset',
            'asset' => $asset
        ]);
    }

    public function perusahaan($company)
    {
        //dd($company);

        $tab = request()->get('tab', 'grafik');
        //dd($tab);
        $user = auth()->user();

        // Tentukan role user
        $ownerRole = match($user->role) {
            1 => 'it',
            2 => 'ga',
            default => null,
        };

        // Ambil semua asset dari perusahaan tsb
        $assetQuery = Asset::where('asset_number', 'LIKE', '%/' . $company . '/%');
        if ($ownerRole) {
            $assetQuery->where('owner_role', $ownerRole);
        }
        $asset = $assetQuery->get();

        // Default kosong
        $labels = collect();
        $qty = collect();

        // Kalau tab = grafik, ambil data grafik stok
        if ($tab === 'grafik') {
            $grafikData = Asset::select('asset_type', DB::raw('SUM(COALESCE(qty,0)) as total_qty'))
                ->where('asset_number', 'LIKE', '%/' . $company . '/%')
                ->groupBy('asset_type');

            if ($ownerRole) {
                $grafikData->where('owner_role', $ownerRole);
            }

            $grafikData = $grafikData->get();

            $labels = $grafikData->pluck('asset_type');
            $qty = $grafikData->pluck('total_qty');
        }

        return view('backend.v_asset.perusahaan', [
            'company' => $company,
            'tab' => $tab,
            'asset' => $asset,
            'labels' => $labels,
            'qty' => $qty,
            'judul' => 'Stok Asset ' . $company
        ]);
    }

}
