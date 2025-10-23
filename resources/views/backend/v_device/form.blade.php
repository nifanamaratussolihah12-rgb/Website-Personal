<div class="form-group">
    <label for="item_name">Item Name</label>
    <input type="text" name="item_name" id="item_name" class="form-control"
           value="{{ old('item_name', $fixed->item_name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="asset_type">Asset Type</label>
    <input type="text" name="asset_type" id="asset_type" class="form-control"
           value="{{ old('asset_type', $fixed->asset_type ?? '') }}">
</div>

<div class="form-group">
    <label for="code">Code</label>
    <input type="text" name="code" id="code" class="form-control"
           value="{{ old('code', $fixed->code ?? '') }}">
</div>

<div class="form-group">
    <label for="asset_number">Asset Number</label>
    <input type="text" name="asset_number" id="asset_number" class="form-control"
           value="{{ old('asset_number', $fixed->asset_number ?? '') }}">
</div>

<div class="form-group">
    <label for="qty">Quantity</label>
    <input type="number" name="qty" id="qty" class="form-control"
           value="{{ old('qty', $fixed->qty ?? '') }}" required>
</div>

<div class="form-group">
    <label for="room">Room</label>
    <input type="text" name="room" id="room" class="form-control"
           value="{{ old('room', $fixed->room ?? '') }}">
</div>

<div class="form-group">
    <label for="floor">Floor</label>
    <input type="text" name="floor" id="floor" class="form-control"
           value="{{ old('floor', $fixed->floor ?? '') }}">
</div>

<div class="form-group">
    <label for="merk">Merk</label>
    <input type="text" name="merk" id="merk" class="form-control"
           value="{{ old('merk', $fixed->merk ?? '') }}">
</div>

<div class="form-group">
    <label for="tanggal_masuk">Tanggal</label>
    <input type="text" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
           value="{{ old('tanggal_masuk', $fixed->tanggal_masuk ?? '') }}">
</div>

<div class="form-group">
    <label for="catatan">Catatan</label>
    <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $fixed->catatan ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select name="status" id="status" class="form-control" required>
        <option value="">-- Pilih Status --</option>
        <option value="new" {{ old('status', $fixed->status ?? '') == 'new' ? 'selected' : '' }}>New</option>
        <option value="reclaim" {{ old('status', $fixed->status ?? '') == 'reclaim' ? 'selected' : '' }}>Reclaim</option>
    </select>
</div>

<div class="form-group">
    <label for="foto">Foto</label>
    <input type="file" name="foto" id="foto" class="form-control">
    @if(!empty($fixed->foto))
        <img src="{{ asset('storage/img-asset/' . $fixed->foto) }}" width="100" class="mt-2" alt="Foto Asset">
    @endif
</div>
