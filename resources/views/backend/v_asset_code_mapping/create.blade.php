@extends('backend.v_layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title mb-4">Tambah Mapping Kode Asset Baru</h4>

    <form action="{{ route('asset_code_mappings.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="asset_type" class="form-label">Asset Type</label>
        <input type="text" name="asset_type" id="asset_type" class="form-control @error('asset_type') is-invalid @enderror" value="{{ old('asset_type') }}" placeholder="Misal: Furniture, Electronics, Consumable">
        @error('asset_type')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="type_code" class="form-label">Type Code</label>
        <input type="text" name="type_code" id="type_code" class="form-control @error('type_code') is-invalid @enderror" value="{{ old('type_code') }}" placeholder="Misal: F01, F02, F03">
        @error('type_code')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="item_name" class="form-label">Item Name</label>
        <input type="text" name="item_name" id="item_name" class="form-control @error('item_name') is-invalid @enderror" value="{{ old('item_name') }}" placeholder="Misal: Kursi, TV LED">
        @error('item_name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="item_code" class="form-label">Item Code</label>
        <input type="text" name="item_code" id="item_code" class="form-control @error('item_code') is-invalid @enderror" value="{{ old('item_code') }}" placeholder="Misal: 01, 02, 03">
        @error('item_code')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{ route('asset_code_mappings.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
