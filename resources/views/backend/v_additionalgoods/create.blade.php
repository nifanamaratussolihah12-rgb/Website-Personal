@extends('backend.v_layouts.app')

@section('title', 'Tambah Additional Goods')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Additional Goods</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('additional.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Type Asset</label>
                <select name="type_asset_id" class="form-control" required>
                    <option value="">-- Pilih Type Asset --</option>
                    @foreach($typeAsset as $type)
                        <option value="{{ $type->id }}">{{ $type->nama_type ?? $type->type_asset ?? 'Type' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Code</label>
                <input type="text" name="code" class="form-control" placeholder="Misal: 05" >
            </div>

            <div class="form-group">
                <label>Asset Number</label>
                <input type="text" name="asset_number" class="form-control" placeholder="Misal: F01/AKM/05/0001" >
            </div>

            <div class="form-group">
                <label>Qty</label>
                <input type="number" name="qty" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Room</label>
                <input type="text" name="room" class="form-control" placeholder="Misal: Gudang" >
            </div>

            <div class="form-group">
                <label>Floor</label>
                <input type="text" name="floor" class="form-control" placeholder="Misal: Lt. 2" >
            </div>

            <div class="form-group">
                <label>Merk</label>
                <input type="text" name="merk" class="form-control" >
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" name="tanggal_masuk" class="form-control" >
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan tambahan (opsional)"></textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="new">Baru</option>
                    <option value="reclaim">Reclaim</option>
                </select>
            </div>

            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('additional.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
