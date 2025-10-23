<form action="{{ route('backend.asset.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="kategori_display">Kategori</label>
        <input type="text" id="kategori_display" class="form-control" 
               value="{{ old('kategori', $asset->kategori->nama_kategori ?? '') }}" readonly>
    </div>

    <div class="form-group">
        <label for="type_asset_display">Type Asset</label>
        <input type="text" id="type_asset_display" class="form-control" 
               value="{{ old('type_asset', $asset->typeAsset->nama_type ?? '') }}" readonly>
    </div>

    <div class="form-group">
        <label for="item_name">Item Name</label>
        <input type="text" name="item_name" id="item_name" class="form-control"
               value="{{ old('item_name', $asset->item_name ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="asset_type">Asset Type</label>
        <input type="text" name="asset_type" id="asset_type" class="form-control"
               value="{{ old('asset_type', $asset->asset_type ?? '') }}">
    </div>

    <div class="form-group">
        <label for="code">Code</label>
        <input type="text" name="code" id="code" class="form-control"
               value="{{ old('code', $asset->code ?? '') }}">
    </div>

    <div class="form-group">
        <label for="asset_number">Asset Number</label>
        <input type="text" name="asset_number" id="asset_number" class="form-control"
               value="{{ old('asset_number', $asset->asset_number ?? '') }}">
    </div>

    <div class="form-group">
        <label for="qty">Quantity</label>
        <input type="number" name="qty" id="qty" class="form-control"
               value="{{ old('qty', $asset->qty ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="user">User</label>
        <input type="number" name="user" id="user" class="form-control"
               value="{{ old('user', $asset->user ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="departemen">Departemen</label>
        <input type="number" name="departemen" id="departemen" class="form-control"
               value="{{ old('departemen', $asset->departemen ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="room">Room</label>
        <input type="text" name="room" id="room" class="form-control"
               value="{{ old('room', $asset->room ?? '') }}">
    </div>

    <div class="form-group">
        <label for="floor">Floor</label>
        <input type="text" name="floor" id="floor" class="form-control"
               value="{{ old('floor', $asset->floor ?? '') }}">
    </div>

    <div class="form-group">
        <label for="site">Site</label>
        <input type="number" name="site" id="site" class="form-control"
               value="{{ old('site', $asset->site ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="merk">Merk</label>
        <input type="text" name="merk" id="merk" class="form-control"
               value="{{ old('merk', $asset->merk ?? '') }}">
    </div>

    <div class="form-group">
        <label for="model">Model</label>
        <input type="text" name="model" id="model" class="form-control"
               value="{{ old('model', $asset->model ?? '') }}">
    </div>

    <div class="form-group">
        <label for="spek">Spek</label>
        <input type="text" name="spek" id="spek" class="form-control"
               value="{{ old('spek', $asset->spek ?? '') }}">
    </div>

    <div class="form-group">
        <label for="kondisi">Kondisi</label>
        <select name="kondisi" id="kondisi" class="form-control @error('kondisi') is-invalid @enderror">
            <option value="">-- Pilih Kondisi --</option>
            <option value="layak pakai" {{ old('kondisi', $asset->kondisi ?? '') == 'layak pakai' ? 'selected' : '' }}>Layak Pakai</option>
            <option value="rusak" {{ old('kondisi', $asset->kondisi ?? '') == 'rusak' ? 'selected' : '' }}>Rusak</option>
            <option value="baik" {{ old('kondisi', $asset->kondisi ?? '') == 'baik' ? 'selected' : '' }}>Baik</option>
        </select>
        @error('kondisi')
            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="text" name="tanggal" id="tanggal" class="form-control"
               value="{{ old('tanggal', $asset->tanggal ?? '') }}">
    </div>

    <div class="form-group">
        <label for="serial_number">Nomor Seri</label>
        <input type="text" name="serial_number" id="serial_number" class="form-control"
               value="{{ old('serial_number', $asset->serial_number ?? '') }}">
    </div>

    <div class="form-group">
        <label for="history">History</label>
        <input type="text" name="history" id="history" class="form-control"
               value="{{ old('history', $asset->history ?? '') }}">
    </div>

    <div class="form-group">
        <label for="warranty_expiry"> Masa Garansi</label>
        <input type="text" name="warranty_expiry" id="warranty_expiry" class="form-control"
               value="{{ old('warranty_expiry', $asset->warranty_expiry ?? '') }}">
    </div> 

    <div class="form-group">
        <label for="official_store">Official Store</label>
        <input type="text" name="official_store" id="official_store" class="form-control"
               value="{{ old('official_store', $asset->official_store ?? '') }}">
    </div> 
    
    <div class="form-group">
        <label for="reseller">Reseller</label>
        <input type="text" name="reseller" id="reseller" class="form-control"
               value="{{ old('reseller', $asset->reseller ?? '') }}">
    </div> 

    <!-- Harga Beli -->
    <div class="form-group">
        <label for="harga_beli">Harga Beli</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
            </div>
            <input type="text" name="harga_beli" id="harga_beli" 
                class="form-control @error('harga_beli') is-invalid @enderror"
                value="{{ old('harga_beli', isset($edit->harga_beli) ? number_format($edit->harga_beli,0,',','.') : '') }}">
            @error('harga_beli') 
            <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span> 
            @enderror
        </div>
    </div>

    <script>
    const input = document.getElementById('harga_beli');
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // hapus semua selain angka
        if(value) {
            // format angka dengan ribuan, tanpa menumpuk Rp
            e.target.value = new Intl.NumberFormat('id-ID', { style: 'decimal', minimumFractionDigits: 0 }).format(value);
        } else {
            e.target.value = '';
        }
    });
    </script>


    <div class="form-group">
        <label for="catatan">Catatan</label>
        <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $asset->catatan ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="new" {{ old('status', $asset->status ?? '') == 'new' ? 'selected' : '' }}>New</option>
            <option value="active" {{ old('status', $asset->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="reclaimed" {{ old('status', $asset->status ?? '') == 'reclaimed' ? 'selected' : '' }}>Reclaimed</option>
            <option value="damaged" {{ old('status', $asset->status ?? '') == 'damaged' ? 'selected' : '' }}>Damaged</option>
            <option value="lost" {{ old('status', $asset->status ?? '') == 'lost' ? 'selected' : '' }}>Lost</option>
            <option value="disposed" {{ old('status', $asset->status ?? '') == 'disposed' ? 'selected' : '' }}>Disposed</option>
        </select>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <input type="file" name="foto" id="foto" class="form-control">
        @if(!empty($asset->foto))
            <img src="{{ asset('storage/' . $asset->foto) }}" style="max-width: 150px;">
        @endif
    </div>

    <button type="submit" class="btn btn-primary mt-3">Simpan Asset</button>
</form>