<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDataDetail extends Model
{
    use HasFactory;

    protected $table = 'form_data_details'; // nama tabel

    protected $fillable = [
        'form_type',   // jenis formulir, misalnya: serah_terima, perbaikan, pengajuan
        'label',       // nama field, misalnya: Nama Barang
        'input_type',  // tipe input: text, number, date, textarea
        'is_required', // wajib atau tidak
    ];
}
