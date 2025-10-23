<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AssetHandover; 

class AssetHandoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan formulir default
        AssetHandover::updateOrCreate(
            ['id' => 1], 
            ['nama_formulir' => 'Serah Terima Asset IT']
        );

        // Peralihan Asset IT
        AssetHandover::updateOrCreate(
            ['id' => 2], 
            ['nama_formulir' => 'Peralihan Asset IT']
        );

        AssetHandover::updateOrCreate(
            ['id' => 3], 
            ['nama_formulir' => 'Working Order']
        );

        AssetHandover::updateOrCreate(
            ['id' => 4], 
            ['nama_formulir' => 'Permintaan Asset IT']
        );

        AssetHandover::updateOrCreate(
            ['id' => 5], 
            ['nama_formulir' => 'Readiness/Kesiapan Instalasi']
        );

        AssetHandover::updateOrCreate(
            ['id' => 6], 
            ['nama_formulir' => 'Finding']
        );

        AssetHandover::updateOrCreate(
            ['id' => 7], 
            ['nama_formulir' => 'Permintaan Perbaikan Perangkat IT (F3PIT)']
        );

        AssetHandover::updateOrCreate(
            ['id' => 8], 
            ['nama_formulir' => 'Permintaan Login Email / Internet']
        );

        AssetHandover::updateOrCreate(
            ['id' => 9], 
            ['nama_formulir' => 'Memo']
        );
    }
}