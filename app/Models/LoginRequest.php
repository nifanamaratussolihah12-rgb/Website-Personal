<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class LoginRequest extends Model
{
    use HasFactory;

    protected $table = 'login_requests';

    protected $fillable = [
        'tanggal',
        'cabang',
        'is_abm_group',
        'company_name',
        'jenis_permintaan',
        'sub_jenis',
        'nama_depan',
        'nama_tengah',
        'nama_belakang',
        'nik',
        'alamat_email',
        'divisi',
        'departemen',
        'note',
        'mengetahui',
        'tanggal_diterima',
        'alamat_email_login',
        'password',   // akan otomatis terenkripsi via mutator
        'tanggal_efektif',
        'dibuat_oleh',
        'tanggal_dibuat',
        'catatan',
        'tanggal_dokumen', 
        'tanggal_expired',
        'status',       
        'memo',
    ];

    protected $casts = [
        'tanggal'          => 'date',
        'tanggal_diterima' => 'date',
        'tanggal_efektif'  => 'date',
        'tanggal_dibuat'   => 'date',
        'is_abm_group'     => 'boolean',
        'tanggal_dokumen'  => 'date', 
        'tanggal_expired'  => 'date',
    ];
    
    public function getFullNameAttribute()
    {
        return trim("{$this->nama_depan} {$this->nama_tengah} {$this->nama_belakang}");
    }

    public function setPasswordAttribute($value)
{
    if ($value) {
        $this->attributes['password'] = Crypt::encryptString($value);
    }
}

public function getPasswordPlainAttribute()
{
    if (empty($this->attributes['password'])) return null;

    try {
        return Crypt::decryptString($this->attributes['password']);
    } catch (\Exception $e) {
        return null; // jaga-jaga kalau data lama
    }
}
}
