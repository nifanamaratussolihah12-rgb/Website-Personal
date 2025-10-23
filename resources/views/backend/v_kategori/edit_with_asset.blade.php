@extends('backend.v_layouts.app')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">✏️ {{ $judul }}</h4>

    {{-- Form Update Kategori --}}
    <form action="{{ route('backend.kategori.update', $edit->id) }}" method="POST">
      @method('PUT')
      @csrf

      <div class="form-group">
        <label>Nama Kategori Aset</label>
        <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $edit->nama_kategori) }}" class="form-control">
      </div>

      <div class="form-group">
      <label>Kode Prefix (wajib) <span class="text-muted">*</span></label>
      <small class="form-text" style="color: #495057; margin-top: 2px; display: block;">
          * F = Fixed Asset (5 tahun) | S = Small Asset (1-3 tahun)
      </small>
      <input type="text" 
              name="kategori_prefix" 
              value="{{ old('kategori_prefix', $edit->kategori_prefix ?? '') }}" 
              class="form-control @error('kategori_prefix') is-invalid @enderror" 
              placeholder="Contoh: F01, S01">
      @error('kategori_prefix')
          <div class="invalid-feedback alert-danger">{{ $message }}</div>
      @enderror
      </div>

      <hr>
      <h5>Data Asset Terkait (Read Only)</h5>

      {{-- Table Asset --}}
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead style="background-color:#dcdff5ff; color:#000; font-weight:normal; font-size:14px;">
            <tr>
              <th>No</th>
              <th>Asset Type</th>
              <th>Code</th>
              <th>Asset Number</th>
              <th>Item Name</th>
              <th>User</th>
              <th>Departemen</th>
              <th>Qty</th>
              <th>Room</th>
              <th>Floor</th>
              <th>Site</th>
              <th>Merk</th>
              <th>Model</th>
              <th>Spek</th>
              <th>Kondisi</th>
              <th>Tanggal</th>
              <th>History</th>
              <th>Nomor Seri</th>
              <th>Masa Garansi</th>
              <th>Official Store</th>
              <th>Reseller</th>
              <th>Harga Beli</th>
              <th>Status</th>
              <th>Catatan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($edit->asset as $i => $asset)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td><input type="text" class="form-control" value="{{ $asset->asset_type }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->code }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->asset_number }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->item_name }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->user }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->departemen }}" readonly></td>
              <td><input type="number" class="form-control" value="{{ $asset->qty }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->room }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->floor }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->site }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->merk }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->model }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->spek }}" readonly></td>
              <td><input type="date" class="form-control" value="{{ $asset->tanggal ? \Carbon\Carbon::parse($asset->tanggal)->format('Y-m-d') : '' }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->serial_number }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ ucfirst($asset->kondisi) }}" readonly></td>
              <td><input type="date" class="form-control" value="{{ $asset->tanggal ? \Carbon\Carbon::parse($asset->tanggal)->format('Y-m-d') : '' }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->history }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->serial_number }}" readonly></td>
              <td><input type="date" class="form-control" value="{{ $asset->warranty_expiry ? \Carbon\Carbon::parse($asset->warranty_expiry)->format('Y-m-d') : '' }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->official_store }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->reseller }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->harga_beli }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ ucfirst($asset->status) }}" readonly></td>
              <td><input type="text" class="form-control" value="{{ $asset->catatan }}" readonly></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('backend.asset.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection
