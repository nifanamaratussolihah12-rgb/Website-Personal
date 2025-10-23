<div class="form-group">
    <label>Kategori</label>
    <select name="kategori_id" class="form-control" required>
        @foreach($kategori as $kat)
            <option value="{{ $kat->id }}" {{ (old('kategori_id', $additional->kategori_id) == $kat->id) ? 'selected' : '' }}>
                {{ $kat->nama_kategori }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Asset Type</label>
    <input type="text" name="asset_type" class="form-control" value="{{ old('asset_type', $additional->asset_type) }}">
</div>

<div class="form-group">
    <label>Code</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $additional->code) }}">
</div>

<div class="form-group">
    <label>Asset Number</label>
    <input type="text" name="asset_number" class="form-control" value="{{ old('asset_number', $additional->asset_number) }}">
</div>

<div class="form-group">
    <label>Item Name</label>
    <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $additional->item_name) }}" required>
</div>

<div class="form-group">
    <label>Qty</label>
    <input type="number" name="qty" class="form-control" value="{{ old('qty', $additional->qty) }}" required>
</div>

<div class="form-group">
    <label>Room</label>
    <input type="text" name="room" class="form-control" value="{{ old('room', $additional->room) }}">
</div>

<div class="form-group">
    <label>Floor</label>
    <input type="text" name="floor" class="form-control" value="{{ old('floor', $additional->floor) }}">
</div>

<div class="form-group">
    <label>Merk</label>
    <input type="text" name="merk" class="form-control" value="{{ old('merk', $additional->merk) }}">
</div>

<div class="form-group">
    <label>Tanggal</label>
    <input type="text" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $additional->tanggal_masuk) }}">
</div>

<div class="form-group">
    <label>Catatan</label>
    <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $additional->catatan) }}</textarea>
</div>

<div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control" required>
        <option value="new" {{ old('status', $additional->status) == 'new' ? 'selected' : '' }}>Baru</option>
        <option value="reclaim" {{ old('status', $additional->status) == 'reclaim' ? 'selected' : '' }}>Reclaim</option>
    </select>
</div>

<div class="form-group">
    <label>Foto</label><br>
    @if(!empty($additional->foto))
        <img src="{{ asset('storage/'.$additional->foto) }}" alt="foto" width="100"><br>
    @endif
    <input type="file" name="foto" class="form-control">
</div>
