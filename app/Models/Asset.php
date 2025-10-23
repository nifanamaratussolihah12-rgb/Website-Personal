<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'asset';
    public $timestamps = true;

    protected $guarded = ['id'];

    protected $fillable = [
        'kategori_id',
        'type_asset_id',
        'status',
        'foto',
        'asset_type',
        'code',
        'asset_number',
        'item_name',
        'qty',
        'room',
        'floor',
        'merk',
        'catatan',
        'tanggal',           
        'serial_number',            
        'model',                   
        'spek',                   
        'warranty_expiry',          
        'official_store',   
        'reseller',                
        'harga_beli', 
        //tambahan   
        'user',
        'departemen',
        'site',
        'kondisi',
        'history',

        // 🔥 tambahan penting
        'owner_role',
        'asset_kind',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'warranty_expiry' => 'date',
    ];

    public function typeAsset()
    {
        return $this->belongsTo(TypeAsset::class, 'type_asset_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

        // Akses gabungan kode asset (prefix + nomor)
    public function getFullCodeAttribute()
    {
        return $this->typeAsset 
            ? $this->typeAsset->type_prefix . $this->asset_number 
            : $this->asset_number;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fotoAsset()
    {
        return $this->hasMany(FotoAsset::class);
    }

    // Biar pas ambil data asset_number langsung uppercase (opsional)
    public function getAssetNumberAttribute($value)
    {
        return strtoupper($value);
    }

    public function setKategoriIdAttribute($value)
    {
        // Ambil kategori baru
        $kategori = Kategori::find($value);

        if ($kategori && !empty($this->attributes['asset_number'])) {
            // Pecah asset_number lama
            $parts = explode('/', $this->attributes['asset_number']);

            if (count($parts) > 1) {
                // Ganti prefix lama dengan kategori_prefix baru
                $parts[0] = $kategori->kategori_prefix;

                // Susun ulang asset_number
                $this->attributes['asset_number'] = implode('/', $parts);
            }
        }

        // Simpan kategori_id baru
        $this->attributes['kategori_id'] = $value;
    }

    public function maintenances()
    {
        return $this->hasMany(\App\Models\AssetMaintenance::class);
    }

    // Ambil asset fisik saja
    public function scopePhysical($query)
    {
        return $query->where('asset_kind', 'physical');
    }

    // Ambil service items saja
    public function scopeService($query)
    {
        return $query->where('asset_kind', 'service');
    }

    public function getIsServiceItemAttribute()
    {
        return $this->asset_kind === 'service';
    }

    public function getIsPhysicalAttribute()
    {
        return $this->asset_kind === 'physical';
    }

}
