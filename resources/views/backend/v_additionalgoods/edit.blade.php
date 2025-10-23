@extends('backend.v_layouts.app')

@section('title', 'Edit Additional Goods')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Additional Goods</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('additional.update', $additional->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ $additional->kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Asset Type</label>
                <input type="text" name="asset_type" class="form-control" value="{{ $additional->asset_type }}">
            </div>

            <div class="form-group">
                <label>Code</label>
                <input type="text" name="code" class="form-control" value="{{ $additional->code }}">
            </div>

            <div class="form-group">
                <label>Asset Number</label>
                <input type="text" name="asset_number" class="form-control" value="{{ $additional->asset_number }}">
            </div>

            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="item_name" class="form-control" value="{{ $additional->item_name }}" required>
            </div>

            <div class="form-group">
                <label>Qty</label>
                <input type="number" name="qty" class="form-control" value="{{ $additional->qty }}" required>
            </div>

            <div class="form-group">
                <label>Room</label>
                <input type="text" name="room" class="form-control" value="{{ $additional->room }}">
            </div>

            <div class="form-group">
                <label>Floor</label>
                <input type="text" name="floor" class="form-control" value="{{ $additional->floor }}">
            </div>

            <div class="form-group">
                <label>Merk</label>
                <input type="text" name="merk" class="form-control" value="{{ $additional->merk }}">
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ $additional->tanggal_masuk ? \Carbon\Carbon::parse($additional->tanggal_masuk)->format('Y-m-d') : '' }}">
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="3">{{ $additional->catatan }}</textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="new" {{ $additional->status == 'new' ? 'selected' : '' }}>Baru</option>
                    <option value="reclaim" {{ $additional->status == 'reclaim' ? 'selected' : '' }}>Reclaim</option>
                </select>
            </div>

            <div class="form-group">
                <label>Foto</label><br>
                @if($additional->foto)
                    <img src="{{ asset('storage/'.$additional->foto) }}" alt="foto" width="100"><br>
                @endif
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('additional.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
