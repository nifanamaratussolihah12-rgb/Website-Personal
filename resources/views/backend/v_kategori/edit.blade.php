@extends('backend.v_layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">✏️ {{ $judul }}</h4>

    <form action="{{ route('kategori.update', $edit->id) }}" method="POST">
      @method('PUT')
      @csrf

      <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $edit->nama_kategori) }}" class="form-control @error('nama_kategori') is-invalid @enderror" placeholder="Contoh: Fixed Asset, Additional goods, Consumable Goods">
        @error('nama_kategori')
          <span class="invalid-feedback alert-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="row mt-3">
        <div class="col-md-12 text-center">
          <button type="submit" class="btn btn-warning">Perbarui</button>
          <a href="{{ route('backend.asset.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
