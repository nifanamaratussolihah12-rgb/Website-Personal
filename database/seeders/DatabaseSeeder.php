<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kategori;
use App\Models\TypeAsset;
use App\Models\AssetHandover;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User dengan updateOrCreate supaya tidak duplikat
        User::updateOrCreate(
            ['email' => 'suhendi.eko@adijayakaryamakmur.com'],
            [
             'nama' => 'Suhendi Eko',
             'role' => 0,
             'hp' => '0812345678901',
             'password' => bcrypt('S@55word'),
             'nik' => '0098781234567890',
             'divisi' => 'IT',
             'site' => 'Jakarta',
             'date_of_receive' => '2025-08-13',
            ]
        );

        User::updateOrCreate(
            ['email' => 'am.it@adijayakaryamakmur.com'],
            [
             'nama' => 'Sopian Kia',
             'role' => 1,
             'hp' => '081234567892',
             'password' => bcrypt('S@55word'),
             'nik' => '3454320987654321',
             'divisi' => 'Finance',
             'site' => 'Jakarta',
             'date_of_receive' => '2025-08-13',
             ]
        );

        User::updateOrCreate(
            ['email' => 'olav@gmail.com'],
            [
             'nama' => 'Olav',
             'role' => 2,
             'hp' => '081234567892',
             'password' => bcrypt('O@55word'),
             'nik' => '0987650987654321',
             'divisi' => 'GA',
             'site' => 'Jakarta',
             'date_of_receive' => '2025-08-13',
             ]
        );

        User::updateOrCreate(
            ['email' => 'bela@gmail.com'],
            [
             'nama' => 'Bela',
             'role' => 3,
             'hp' => '081234523679',
             'password' => bcrypt('B@55word'),
             'nik' => '0045630987098765',
             'divisi' => 'Finance',
             'site' => 'Jakarta',
             'date_of_receive' => '2025-08-13',
             ]
        );

        // Seeder untuk kategori
        // ✅ ASSET FISIK (physical)
        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Fixed Asset - Furniture IT', 'owner_role' => 'it'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'FF01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Fixed Asset - Furniture GA', 'owner_role' => 'ga'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'FF02', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Fixed Asset - Electronics IT', 'owner_role' => 'it'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'FE01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Fixed Asset - Electronics GA', 'owner_role' => 'ga'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'FE02', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Additional Goods IT', 'owner_role' => 'it'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'A01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Additional Goods GA', 'owner_role' => 'ga'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'A02', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Consumable Goods IT', 'owner_role' => 'it'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'C01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Consumable Goods GA', 'owner_role' => 'ga'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'C02', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Small Asset IT', 'owner_role' => 'it'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'S01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Small Asset GA', 'owner_role' => 'ga'],
            ['asset_kind' => 'physical', 'kategori_prefix' => 'S02', 'updated_at' => now(), 'created_at' => now()]
        );


        // ✅ ASSET NON-FISIK / SERVICE
        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Software License / Subscription', 'owner_role' => 'it'],
            ['asset_kind' => 'service', 'kategori_prefix' => 'SL01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Network & Communication Service', 'owner_role' => 'it'],
            ['asset_kind' => 'service', 'kategori_prefix' => 'NCS01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Cloud Service / Online Platform', 'owner_role' => 'it'],
            ['asset_kind' => 'service', 'kategori_prefix' => 'CS01', 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('kategori')->updateOrInsert(
            ['nama_kategori' => 'Other Services (e.g., IESR, Training, etc.)', 'owner_role' => 'it'],
            ['asset_kind' => 'service', 'kategori_prefix' => 'OS01', 'updated_at' => now(), 'created_at' => now()]
        );


        // Seeder untuk type_asset
        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Infrastruktur IT'],
            ['type_prefix' => 'IT01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Furniture GA'],
            ['type_prefix' => 'GA01', 'owner_role' => 'ga', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Electronics IT'],
            ['type_prefix' => 'IT02', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Electronics GA'],
            ['type_prefix' => 'GA02', 'owner_role' => 'ga', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Laptop AKM'],
            ['type_prefix' => 'LAKM01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Laptop LIN'],
            ['type_prefix' => 'LLIN01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Laptop SMM'],
            ['type_prefix' => 'LSMM01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Laptop AGI'],
            ['type_prefix' => 'LAGI01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Laptop ADL'],
            ['type_prefix' => 'LADL01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Laptop CMT'],
            ['type_prefix' => 'LMT01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        DB::table('type_asset')->updateOrInsert(
            ['nama_type' => 'Laptop BDM'],
            ['type_prefix' => 'LBDM01', 'owner_role' => 'it', 'updated_at' => now()]
        );

        // Ambil ID berdasarkan nama_type
        $itInfraId       = DB::table('type_asset')->where('nama_type', 'Infrastruktur IT')->value('id');
        $gaFurnId        = DB::table('type_asset')->where('nama_type', 'Furniture GA')->value('id');
        $itElectronicsId = DB::table('type_asset')->where('nama_type', 'Electronics IT')->value('id');
        $gaElectronicsId = DB::table('type_asset')->where('nama_type', 'Electronics GA')->value('id');
        $laptopId        = DB::table('type_asset')->where('nama_type', 'Laptop AKM')->value('id');

        // Upsert data asset_item_code
        DB::table('asset_item_code')->upsert([

            // Infrastruktur GA
            ['type_asset_id' => $gaFurnId, 'item_name' => 'MEJA',       'item_code' => '01', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaFurnId, 'item_name' => 'KURSI',      'item_code' => '02', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaFurnId, 'item_name' => 'SOFA',       'item_code' => '03', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaFurnId, 'item_name' => 'GLASSBOARD', 'item_code' => '04', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaFurnId, 'item_name' => 'LEMARI',     'item_code' => '05', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaFurnId, 'item_name' => 'LAIN - LAIN',   'item_code' => '06', 'created_at' => now(), 'updated_at' => now()],

            // Electronics GA
            ['type_asset_id' => $gaElectronicsId, 'item_name' => 'AIR PURIFIER',       'item_code' => '03', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaElectronicsId, 'item_name' => 'AC SPLIT',           'item_code' => '06', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaElectronicsId, 'item_name' => 'DISPENSER',          'item_code' => '07', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $gaElectronicsId, 'item_name' => 'PAPER SHREDDER',     'item_code' => '08', 'created_at' => now(), 'updated_at' => now()],

            // Electronics IT
            ['type_asset_id' => $itElectronicsId, 'item_name' => 'SCREEN PROYEKTOR', 'item_code' => '01', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $itElectronicsId, 'item_name' => 'PROYEKTOR',        'item_code' => '02', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $itElectronicsId, 'item_name' => 'IP PHONE',         'item_code' => '04', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $itElectronicsId, 'item_name' => 'TV LED',           'item_code' => '05', 'created_at' => now(), 'updated_at' => now()],

            // Laptop
            ['type_asset_id' => $laptopId, 'item_name' => 'Laptop Lenovo',        'item_code'  => '01', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $laptopId, 'item_name' => 'Laptop Apple',         'item_code'  => '02', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $laptopId, 'item_name' => 'Storage',              'item_code'  => '03', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $laptopId, 'item_name' => 'Monitor',              'item_code'  => '04', 'created_at' => now(), 'updated_at' => now()],
            ['type_asset_id' => $laptopId, 'item_name' => 'Audio / Recorder',     'item_code'  => '01', 'created_at' => now(), 'updated_at' => now()],

        ], ['type_asset_id', 'item_name'], ['item_code', 'updated_at']);

        $this->call([
            AssetHandoverSeeder::class,
        ]);
    }
}
