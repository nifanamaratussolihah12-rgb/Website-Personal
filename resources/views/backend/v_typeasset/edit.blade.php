@extends('backend.v_layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">✏️ {{ $judul }}</h4>

    <form action="{{ route('v_typeasset.update', $edit->id) }}" method="POST">
      @method('PUT')
      @csrf

      <div class="form-group">
          <label>Nama Type Asset</label>
          <input type="text" 
                name="nama_type" 
                value="{{ old('nama_type', $edit->nama_type) }}" 
                class="form-control @error('nama_type') is-invalid @enderror" 
                placeholder="Contoh: Elektronik, Furniture">
          @error('nama_type')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
      </div>

      <div class="form-group">
          <label>Kode Prefix (WAJIB)</label>
          <input type="text" 
                name="type_prefix" 
                value="{{ old('type_prefix', $edit->type_prefix ?? '') }}" 
                class="form-control @error('type_prefix') is-invalid @enderror" 
                placeholder="Contoh: F01, F02">
          @error('type_prefix')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
      </div>

      <div class="row mt-3">
        <div class="col-md-12 text-center">
          <button type="submit" class="btn btn-warning">Perbarui</button>
          <a href="{{ route('v_asset.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
