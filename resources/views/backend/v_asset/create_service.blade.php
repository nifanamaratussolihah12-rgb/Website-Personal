@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.asset.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="asset_kind" value="service">

                    <div class="card-body">
                        <h4 class="card-title">{{ $judul ?? 'Tambah Service Item' }}</h4>

                        <div class="row">
                            <!-- Kategori -->
                            <div class="col-md-6 mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori Service --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Type Asset -->
                            <div class="col-md-6 mb-3">
                                <label>Tipe Asset</label>
                                <select name="type_asset_id" class="form-control">
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach($typeAsset as $type)
                                        <option value="{{ $type->id }}" {{ old('type_asset_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->nama_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Service Item -->
                            <div class="col-md-6 mb-3">
                                <label>Nama Service Item</label>
                                <input type="text" name="item_name" value="{{ old('item_name') }}"
                                    class="form-control @error('item_name') is-invalid @enderror"
                                    placeholder="Contoh: Maintenance Website, Lisensi Software">
                                @error('item_name')
                                    <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div class="col-md-6 mb-3">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control">
                            </div>

                            <!-- Asset Number -->
                            <div class="col-md-6 mb-3"> 
                                <label>Unit / Company</label>
                                <select name="company" class="form-control" required>
                                    <option value="">-- Pilih Unit --</option>
                                    <option value="AKM">AKM</option>
                                    <option value="SMM">SMM</option>
                                    <option value="AKD">AKD</option>
                                    <option value="BPN">BPN</option>
                                    <option value="BPN">LIN</option>
                                    <option value="BPN">AGI</option>
                                    <option value="BPN">ADL</option>
                                    <option value="BPN">CMT</option>
                                    <option value="BPN">BDM</option>
                                </select>
                            </div>

                            <!-- User -->
                            <div class="col-md-6 mb-3"> 
                                <label>User</label> 
                                <input type="text" name="user" value="{{ old('user') }}" class="form-control" placeholder="Contoh: Rika"> 
                            </div>

                            <!-- Departemen -->
                            <div class="col-md-6 mb-3"> 
                                <label>Departemen</label> 
                                <input type="text" name="departemen" value="{{ old('departemen') }}" class="form-control" placeholder="Contoh: IT, GA, Finance"> 
                            </div>

                            <!-- Site -->
                            <div class="col-md-6 mb-3">
                                <label>Site</label>
                                <input type="text" name="site" value="{{ old('site') }}" class="form-control" placeholder="Contoh: HO, Site">
                            </div>

                            <!-- Jumlah -->
                            <div class="col-md-6 mb-3">
                                <label>Jumlah (Qty)</label>
                                <input type="number" name="qty" value="{{ old('qty') }}" class="form-control" placeholder="Masukkan Jumlah">
                            </div>

                            <!-- Service ID -->
                            <div class="col-md-6 mb-3"> 
                                <label>Service ID</label> 
                                <input type="text" name="serial_number" value="{{ old('serial_number') }}" class="form-control" placeholder="Contoh: LIC-2025-001, SUBS-98765"> 
                            </div>

                            <!-- Masa Garansi -->
                            <div class="col-md-6 mb-3"> 
                                <label>Masa Garansi</label> 
                                <input type="date" name="warranty_expiry" value="{{ old('warranty_expiry') }}" class="form-control"> 
                            </div>

                            <!-- Official Store -->
                            <div class="col-md-6 mb-3"> 
                                <label>Official Store</label> 
                                <input type="text" name="official_store" value="{{ old('official_store') }}" class="form-control" placeholder="Contoh: Lenovo Official Store"> 
                            </div>

                            <!-- Reseller -->
                            <div class="col-md-6 mb-3"> 
                                <label>Reseller</label> 
                                <input type="text" name="reseller" value="{{ old('reseller') }}" class="form-control" placeholder="Contoh: Toko Jaya Abadi"> 
                            </div>

                            <!-- Harga Beli -->
                            <div class="col-md-6 mb-3">
                                <label>Harga Beli</label>
                                <input type="text" name="harga_beli" id="harga_beli" class="form-control" placeholder="Contoh: 1.200.000">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="new" {{ old('status')=='new'?'selected':'' }}>New</option>
                                    <option value="active" {{ old('status')=='active'?'selected':'' }}>Active</option>
                                    <option value="reclaimed" {{ old('status')=='reclaimed'?'selected':'' }}>Reclaimed</option>
                                </select>
                            </div>

                            <!-- Catatan -->
                            <div class="col-md-6 mb-3">
                                <label>Catatan</label>
                                <textarea name="catatan" rows="3" class="form-control" placeholder="Contoh: Service perlu dicek">{{ old('catatan') }}</textarea>
                            </div>

                        </div> <!-- row -->
                    </div> <!-- card-body -->

                    <div class="border-top">
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('backend.asset.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleManualInput(select) {
    const manualInput = document.getElementById('manualItemInput');
    if (select.value === 'manual') {
        manualInput.style.display = 'block';
        manualInput.readOnly = false;
        manualInput.required = true;
        manualInput.value = "";
    } else if (select.value === '') {
        manualInput.value = '';
        manualInput.readOnly = false;
    } else {
        manualInput.style.display = 'block';
        manualInput.readOnly = true;
        manualInput.required = true;
        manualInput.value = select.value;
    }
}

const input = document.getElementById('harga_beli');
input.addEventListener('input', function(e) {
    let numericValue = e.target.value.replace(/\D/g, '');
    e.target.value = numericValue ? 
        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(numericValue) : '';
});
input.closest('form').addEventListener('submit', function() {
    input.value = input.value.replace(/\D/g, '');
});
</script>
@endsection
