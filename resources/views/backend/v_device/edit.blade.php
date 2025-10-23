@extends('v_layouts.backend')

@section('content')
<div class="container">
    <h4>✏️ Edit Fixed Asset</h4>
    <form action="{{ route('fixed.update', $fixed->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Item Name --}}
        <div class="mb-3">
            <label>Item Name</label>
            <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $fixed->item_name) }}" required>
        </div>

        {{-- Asset Type --}}
        <div class="mb-3">
            <label>Asset Type</label>
            <input type="text" name="asset_type" class="form-control" value="{{ old('asset_type', $fixed->asset_type) }}">
        </div>

        {{-- Code --}}
        <div class="mb-3">
            <label>Code</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $fixed->code) }}">
        </div>

        {{-- Asset Number --}}
        <div class="mb-3">
            <label>Asset Number</label>
            <input type="text" name="asset_number" class="form-control" value="{{ old('asset_number', $fixed->asset_number) }}">
        </div>

        {{-- Qty --}}
        <div class="mb-3">
            <label>Qty</label>
            <input type="number" name="qty" class="form-control" value="{{ old('qty', $fixed->qty) }}" required>
        </div>

        {{-- Room --}}
        <div class="mb-3">
            <label>Room</label>
            <input type="text" name="room" class="form-control" value="{{ old('room', $fixed->room) }}">
        </div>

        {{-- Floor --}}
        <div class="mb-3">
            <label>Floor</label>
            <input type="text" name="floor" class="form-control" value="{{ old('floor', $fixed->floor) }}">
        </div>

        {{-- Merk --}}
        <div class="mb-3">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" value="{{ old('merk', $fixed->merk) }}">
        </div>

        {{-- Tanggal --}}
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="text" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $fixed->tanggal_masuk) }}">
        </div>

        {{-- Catatan --}}
        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $fixed->catatan) }}</textarea>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="new" {{ $fixed->status == 'new' ? 'selected' : '' }}>New</option>
                <option value="reclaim" {{ $fixed->status == 'reclaim' ? 'selected' : '' }}>Reclaim</option>
            </select>
        </div>

        {{-- Foto --}}
        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
            @if($fixed->foto)
                <img src="{{ asset('storage/img-asset/' . $fixed->foto) }}" alt="Foto Asset" class="mt-2" style="max-height: 120px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('fixed.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
