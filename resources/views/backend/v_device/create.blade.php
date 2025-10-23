@extends('backend.v_layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Fixed Asset</h2>
    <form action="{{ route('v_fixed.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="type_asset_id" class="form-label">Type Asset</label>
            <select name="type_asset_id" id="type_asset_id" class="form-select" required>
                <option value="">-- Pilih Type Asset --</option>
                @foreach ($typeAsset as $type)
                    <option value="{{ $type->id }}" {{ old('type_asset_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->nama_type_asset ?? $type->name ?? 'Type Asset' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="item_name" class="form-label">Nama Barang</label>
            <input type="text" name="item_name" id="item_name" class="form-control" required value="{{ old('item_name') }}">
        </div>

        <div class="mb-3">
            <label for="asset_type" class="form-label">Jenis Aset</label>
            <input type="text" name="asset_type" id="asset_type" class="form-control" value="{{ old('asset_type') }}">
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Kode</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
        </div>

        <div class="mb-3">
            <label for="asset_number" class="form-label">Nomor Aset</label>
            <input type="text" name="asset_number" id="asset_number" class="form-control" value="{{ old('asset_number') }}">
        </div>

        <div class="mb-3">
            <label for="qty" class="form-label">Jumlah</label>
            <input type="number" name="qty" id="qty" class="form-control" required value="{{ old('qty') }}">
        </div>

        <div class="mb-3">
            <label for="room" class="form-label">Ruangan</label>
            <input type="text" name="room" id="room" class="form-control" value="{{ old('room') }}">
        </div>

        <div class="mb-3">
            <label for="floor" class="form-label">Lantai</label>
            <input type="text" name="floor" id="floor" class="form-control" value="{{ old('floor') }}">
        </div>

        <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" name="merk" id="merk" class="form-control" value="{{ old('merk') }}">
        </div>

        <div class="mb-3">
            <label for="tanggal_masuk" class="form-label">Tanggal</label>
            <input type="text" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea name="catatan" id="catatan" rows="3" class="form-control">{{ old('catatan') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>Baru</option>
                <option value="reclaim" {{ old('status') == 'reclaim' ? 'selected' : '' }}>Reclaim</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('v_fixed.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
