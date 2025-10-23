@extends('backend.v_layouts.app')

@section('title', $judul ?? 'Edit Asset')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="card-title">✏️ {{ $judul }}</h4>
    <hr>
    <form action="{{ route('backend.asset.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
      @method('PUT')
      @csrf

      <div class="row">
    <!-- FOTO ASSET -->
    <div class="col-md-4 text-center">
        <div class="form-group text-center">
          <label class="d-block mb-2 fw-semibold">Foto Asset</label>
          
          @if ($edit->foto && file_exists(public_path('img-asset/' . $edit->foto)))
              <img src="{{ asset('img-asset/' . $edit->foto) }}" 
                  alt="Foto Asset"
                  class="foto-preview rounded shadow-sm mb-3" 
                  style="width:180px; height:auto;">
          @else
              <img src="{{ asset('img-asset/img-default.jpg') }}" 
                  alt="Default Foto"
                  class="foto-preview rounded shadow-sm mb-3" 
                  style="width:180px; height:auto;">
          @endif

          <input type="file" 
                name="foto" 
                class="form-control @error('foto') is-invalid @enderror" 
                onchange="previewFoto()">

          @error('foto')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>
    </div>

    <!-- DATA ASSET -->
    <div class="col-md-8">
        <div class="row">
            <!-- Status -->
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="new" {{ old('status', $edit->status) == 'new' ? 'selected' : '' }}>New</option>
                    <option value="active" {{ old('status', $edit->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="reclaimed" {{ old('status', $edit->status) == 'reclaimed' ? 'selected' : '' }}>Reclaimed</option>
                    <option value="damaged" {{ old('status', $edit->status) == 'damaged' ? 'selected' : '' }}>Damaged</option>
                    <option value="lost" {{ old('status', $edit->status) == 'lost' ? 'selected' : '' }}>Lost</option>
                    <option value="disposed" {{ old('status', $edit->status) == 'disposed' ? 'selected' : '' }}>Disposed</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Kategori -->
            <div class="col-md-6 mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $row)
                        <option value="{{ $row->id }}" {{ old('kategori_id', $edit->kategori_id) == $row->id ? 'selected' : '' }}>
                            {{ $row->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Type Asset -->
            <div class="col-md-6 mb-3">
                <label>Type Asset</label>
                <select name="type_asset_id" class="form-control @error('type_asset_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Type Asset --</option>
                    @foreach($typeAsset as $type)
                        <option value="{{ $type->id }}" {{ old('type_asset_id', $edit->type_asset_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->nama_type }}
                        </option>
                    @endforeach
                </select>
                @error('type_asset_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Nama Asset -->
            <div class="col-md-6 mb-3">
                <label>Nama Asset</label>
                <select name="item_select" class="form-control" onchange="toggleManualInput(this)">
                    <option value="">-- Pilih Item --</option>
                    @foreach($assetItems as $item)
                        <option value="{{ $item->item_name }}" {{ old('item_name', $edit->item_name) == $item->item_name ? 'selected' : '' }}>
                            {{ $item->item_name }}
                        </option>
                    @endforeach
                    <option value="manual">Lainnya (Manual Input)</option>
                </select>
                <input type="text" name="item_name" id="manualItemInput"
                       value="{{ old('item_name', $edit->item_name) }}"
                       class="form-control mt-2 @error('item_name') is-invalid @enderror"
                       placeholder="Masukkan Nama Asset"
                       style="{{ in_array(old('item_name', $edit->item_name), $assetItems->pluck('item_name')->toArray()) ? 'display:none;' : 'display:block;' }}">
                @error('item_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <!-- Qty -->
            <div class="col-md-6 mb-3">
                <label>Qty</label>
                <input type="number" name="qty" value="{{ old('qty', $edit->qty) }}"
                       class="form-control @error('qty') is-invalid @enderror" required>
                @error('qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- User -->
            <div class="col-md-6 mb-3">
                <label>User</label>
                <input type="text" name="user" value="{{ old('user', $edit->user) }}"
                       class="form-control @error('user') is-invalid @enderror">
                @error('user') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Departemen -->
            <div class="col-md-6 mb-3">
                <label>Departemen</label>
                <input type="text" name="departemen" value="{{ old('departemen', $edit->departemen) }}"
                       class="form-control @error('departemen') is-invalid @enderror">
                @error('departemen') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Room -->
            <div class="col-md-6 mb-3">
                <label>Room</label>
                <input type="text" name="room" value="{{ old('room', $edit->room) }}"
                       class="form-control @error('room') is-invalid @enderror" placeholder="Contoh: Ruang Server">
                @error('room') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Floor -->
            <div class="col-md-6 mb-3">
                <label>Floor</label>
                <input type="text" name="floor" value="{{ old('floor', $edit->floor) }}"
                       class="form-control @error('floor') is-invalid @enderror" placeholder="Contoh: 1, 2, 3">
                @error('floor') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          
            <!-- site -->
            <div class="col-md-6 mb-3">
              <label>Site</label>
              <input type="text" name="site" value="{{ old('site', $edit->site) }}" class="form-control @error('site') is-invalid @enderror">
              @error('site')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Merk -->
            <div class="col-md-6 mb-3">
              <label>Merk</label>
              <input type="text" name="merk" value="{{ old('merk', $edit->merk) }}" class="form-control @error('merk') is-invalid @enderror" placeholder="Contoh: Dell, Acer">
              @error('merk')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Kondisi -->
            <div class="col-md-6 mb-3">
                <label>Kondisi</label>
                <select name="kondisi" class="form-control @error('kondisi') is-invalid @enderror">
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="layak pakai" {{ old('kondisi', $edit->kondisi) == 'layak pakai' ? 'selected' : '' }}>Layak Pakai</option>
                    <option value="rusak" {{ old('kondisi', $edit->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="baik" {{ old('kondisi', $edit->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                </select>
                @error('kondisi') 
                <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Model  -->
            <div class="col-md-6 mb-3">
              <label>Model</label>
              <textarea name="model" class="form-control @error('model') is-invalid @enderror" rows="3">{{ old('model', $edit->model) }}</textarea>
              @error('model')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- spek -->
            <div class="col-md-6 mb-3">
              <label>Spek</label>
              <textarea name="spek" class="form-control @error('spek') is-invalid @enderror" rows="3">{{ old('spek', $edit->spek) }}</textarea>
              @error('spek')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Tanggal -->
            <div class="col-md-6 mb-3"> 
                <label>Tanggal</label> 
                <input type="date" 
                    name="tanggal" 
                    value="{{ old('tanggal', isset($edit->tanggal) ? \Carbon\Carbon::parse($edit->tanggal)->format('Y-m-d') : '') }}" 
                    class="form-control @error('tanggal') is-invalid @enderror"> 
                @error('tanggal') 
                <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span> 
                @enderror 
            </div>

            <!-- Nomor Seri -->
            <div class="col-md-6 mb-3">
              <label>Nomor Seri</label>
              <input type="text" name="serial_number" value="{{ old('serial_number', $edit->serial_number) }}" class="form-control @error('serial_number') is-invalid @enderror">
              @error('serial_number')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- History -->
            <div class="col-md-6 mb-3">
              <label>History</label>
              <textarea name="history" class="form-control @error('history') is-invalid @enderror" rows="3">{{ old('history', $edit->history) }}</textarea>
              @error('history')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Masa Garansi -->
            <div class="col-md-6 mb-3"> 
                <label>Masa Garansi</label> 
                <input type="date" 
                    name="warranty_expiry" 
                    value="{{ old('warranty_expiry', isset($edit->warranty_expiry) ? \Carbon\Carbon::parse($edit->warranty_expiry)->format('Y-m-d') : '') }}" 
                    class="form-control @error('warranty_expiry') is-invalid @enderror"> 
                @error('warranty_expiry') 
                <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span> 
                @enderror 
            </div>

            <!-- Official Store -->
            <div class="col-md-6 mb-3">
              <label>Official Store</label>
              <input type="text" name="official_store" value="{{ old('official_store', $edit->official_store) }}" class="form-control @error('official_store') is-invalid @enderror">
              @error('official_store')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <!-- Reseller -->
            <div class="col-md-6 mb-3">
              <label>Reseller</label>
              <input type="text" name="reseller" value="{{ old('reseller', $edit->reseller) }}" class="form-control @error('reseller') is-invalid @enderror">
              @error('reseller')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Harga Beli -->
            <div class="col-md-6 mb-3">
                <label>Harga Beli</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" name="harga_beli" id="harga_beli" 
                          class="form-control @error('harga_beli') is-invalid @enderror"
                          value="{{ old('harga_beli', isset($edit->harga_beli) ? $edit->harga_beli: '') }}">
                    @error('harga_beli') 
                    <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span> 
                    @enderror
                </div>
            </div>

            <script>
            const input = document.getElementById('harga_beli');

            // format saat mengetik
            input.addEventListener('input', function(e) {
                let numericValue = e.target.value.replace(/\D/g,'');
                e.target.value = numericValue ? new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(numericValue) : '';
            });

            // saat submit, kirim angka murni
            input.closest('form').addEventListener('submit', function() {
                input.value = input.value.replace(/\D/g,'');
            });
            </script>

            <!-- Catatan -->
            <div class="col-md-6 mb-3">
              <label>Catatan</label>
              <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3" placeholder="Tambahkan catatan terkait asset">{{ old('catatan', $edit->catatan) }}</textarea>
              @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
        </div>
      </div>

      <!-- Submit -->
      <div class="row mt-3">
        <div class="col-md-12 text-center">
          <button type="submit" class="btn btn-warning">Perbarui</button>
          <a href="{{ route('backend.asset.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
  function previewFoto() {
    const fotoInput = document.querySelector('input[name="foto"]');
    const preview = document.querySelector('.foto-preview');
    if (fotoInput.files && fotoInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
      }
      reader.readAsDataURL(fotoInput.files[0]);
    }
  }

  function toggleManualInput(select) {
    const manualInput = document.getElementById('manualItemInput');
    if(select.value === 'manual') {
        manualInput.style.display = 'block';
        manualInput.value = '';
    } else if(select.value !== '') {
        manualInput.style.display = 'none';
        manualInput.value = select.value;
    } else {
        manualInput.style.display = 'none';
    }
  }
</script>

@endsection
