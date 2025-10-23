<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class F3pit extends Model
{
    use HasFactory;

    protected $fillable = [
        'departement', 'pic', 'jabatan', 'kode_inventaris', 'tahun_perolehan',
        'jenis_inventaris', 'brand', 'tipe', 'sn',
        'sejarah_tanggal', 'sejarah_keterangan',
        'deskripsi_permasalahan',
        'penyebab_kerusakan', 'langkah_dilakukan',
        'kondisi_fisik', 'prioritas_pengerjaan',
        'pemohon', 'dep_head', 'kelengkapan_dokumen', 'lampiran_formulir',
        'diterima_oleh', 'tanggal', 'garansi_sebelumnya',
        'pemeriksaan_teknis_oleh', 'diputuskan_internal_it', 'diputuskan_vendor',
        'hasil_diperiksa_oleh', 'hasil_diperiksa_tgl',
        'sn_sesuai', 'bukti_penggantian', 'tanggal_dokumen', 'tanggal_expired', 'status',       
        'catatan',
    ];

    protected $casts = [
        'penyebab_kerusakan' => 'array',
        'langkah_dilakukan' => 'array',
        'diputuskan_internal_it' => 'array',
        'diputuskan_vendor' => 'array',
        'kelengkapan_dokumen' => 'boolean',
        'lampiran_formulir' => 'boolean',
        'sn_sesuai' => 'boolean',
        'bukti_penggantian' => 'boolean',
        'tahun_perolehan' => 'date',
        'sejarah_tanggal' => 'date',
        'tanggal' => 'date',
        'garansi_sebelumnya' => 'date',
        'hasil_diperiksa_tgl' => 'date',
        'tanggal_dokumen' => 'date', 
        'tanggal_expired' => 'date',
    ];

    // F3pit.php
    public function getPenyebabKerusakanCetakAttribute()
    {
        $penyebabList = [
            'perbaikan_sebelumnya_tidak_sempurna' => 'Perbaikan sebelumnya tidak sempurna',
            'kesalahan_pengoperasian' => 'Kesalahan Pengoperasian',
            'gangguan_listrik' => 'Gangguan Listrik/Petir',
            'gangguan_hama' => 'Gangguan Hama (Binatang Pengerat)',
            'lingkungan_lembab' => 'Lingkungan Lembab/Panas/Kotor',
            'umur_pemakaian' => 'Umur Pemakaian',
        ];

        $data = $this->penyebab_kerusakan ?? [];
        $hasil = [];

        // Ambil semua checkbox yang dicentang
        foreach($penyebabList as $key => $label){
            if(!empty($data[$key]) && $data[$key] != '0'){
                $hasil[] = $label;
            }
        }

        // Notes Lainnya
        if(!empty($data['lainnya_notes'])){
            $hasil[] = 'Lainnya';
        }

        return !empty($hasil) ? implode(', ', $hasil) : '-';
    }

    // Optional accessor untuk notes Lainnya
    public function getPenyebabKerusakanNotesAttribute()
    {
        $data = $this->penyebab_kerusakan ?? [];
        return !empty($data['lainnya_notes']) ? $data['lainnya_notes'] : null;
    }

    // F3pit.php (Model)
    public function getLangkahDilakukanCetakAttribute()
    {
        $data = $this->langkah_dilakukan ?? [];
        $hasil = [];

        // Atur urutan di sini, yang pertama muncul di cetak akan paling atas
        $mapping = [
            'konsultasi' => 'Telah konsultasi dengan IT Dept Sdr',   // selalu di atas
            'perbaikan'     => 'Telah pernah diperbaiki di Vendor setempat, Toko', // di bawah
            // Tambah key lain sesuai urutan yang diinginkan
        ];

        foreach ($mapping as $key => $label) {
            if (!empty($data[$key]) && $data[$key] != '0') {
                $notesKey = $key . '_notes';
                $notes = $data[$notesKey] ?? '-';
                $hasil[] = [
                    'label' => $label,
                    'notes' => $notes
                ];
            }
        }

        return $hasil;
    }

}
