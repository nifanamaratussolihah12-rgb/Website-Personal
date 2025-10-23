<div class="form-group">
    <label for="nama_barang">Nama Barang</label>
    <input type="text" name="nama_barang" id="nama_barang" class="form-control"
           value="{{ old('nama_barang', $consumable->nama_barang ?? '') }}" required>
</div>

<div class="form-group">
    <label for="qty">Quantity</label>
    <input type="number" name="qty" id="qty" class="form-control"
           value="{{ old('qty', $consumable->qty ?? '') }}" required>
</div>

<div class="form-group">
    <label for="lokasi">Lokasi</label>
    <input type="text" name="lokasi" id="lokasi" class="form-control"
           value="{{ old('lokasi', $consumable->lokasi ?? '') }}">
</div>

<div class="form-group">
    <label for="keterangan">Keterangan</label>
    <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ old('keterangan', $consumable->keterangan ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="foto">Foto</label>
    <input type="file" name="foto" id="foto" class="form-control">
    @if(!empty($consumable->foto))
        <img src="{{ asset('storage/' . $consumable->foto) }}" width="100" class="mt-2">
    @endif
</div>
