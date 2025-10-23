
@extends('backend.v_layouts.app') 

@section('content')

@if($asset_kind === 'physical')
<!-- contentAwal --> 
<script>
    function previewFoto() {
        const fotoInput = document.querySelector('input[name="foto"]');
        const preview = document.querySelector('.foto-preview');
        const file = fotoInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(file);
        }
    }

    function toggleManualInput(select) {
        const manualInput = document.getElementById('manualItemInput');
        if(select.value === 'manual') {
            manualInput.style.display = 'block';
            manualInput.value = '';
        } else {
            manualInput.style.display = 'none';
            manualInput.value = select.value; // pakai item name dari list
        }
    }
</script>

<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <form class="form-horizontal" action="{{ route('backend.asset.store') }}" method="post" enctype="multipart/form-data"> 
                    @csrf 
                    <div class="card-body"> 
                        <h4 class="card-title">{{ $judul }}</h4> 
                        <div class="row"> 

                            <!-- Foto Asset -->
                            <div class="col-md-4"> 
                                <div class="form-group text-start"> 
                                    <label>Foto</label><br>
                                    <img class="foto-preview mb-2" width="120px" src="{{ asset('storage/img-default.jpg') }}" alt="Preview Foto">
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto(event)"> 
                                    @error('foto') 
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div> 
                                    @enderror 
                                </div> 
                            </div>

                            <!-- Input Data Asset -->
                            <div class="col-md-8"> 
                                <div class="row">
                                    <!-- Kategori -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Kategori</label> 
                                        <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id"> 
                                            <option value="" selected>--Pilih Kategori--</option> 
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
                                            <option value="">--Pilih Tipe Asset--</option>
                                            @foreach($typeAsset as $type)
                                                <option value="{{ $type->id }}" {{ old('type_asset_id') == $type->id ? 'selected' : '' }}>{{ $type->nama_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Nama Asset -->
                                    <div class="col-md-6 mb-3">
                                        <label>Nama Asset</label>
                                        <select id="itemSelect" class="form-control" onchange="toggleManualInput(this)">
                                            <option value="">--Pilih Item--</option>
                                            @foreach($assetItems as $item)
                                            <option value="{{ $item->item_name }}">{{ $item->item_name }}</option>
                                            @endforeach
                                            <option value="manual">Lainnya (Manual Input)</option>
                                        </select>
                                        <input type="text" name="item_name" id="manualItemInput"
                                            value="{{ old('item_name') }}"
                                            class="form-control mt-2 @error('item_name') is-invalid @enderror"
                                            placeholder="Masukkan Nama Asset">
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

                                    <!-- Qty -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Jumlah (Qty)</label> 
                                        <input type="number" name="qty" value="{{ old('qty') }}" class="form-control" placeholder="Masukkan Jumlah"> 
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

                                    <!-- Room -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Room</label> 
                                        <input type="text" name="room" value="{{ old('room') }}" class="form-control" placeholder="Contoh: Ruang Server"> 
                                    </div>

                                    <!-- Floor -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Floor</label> 
                                        <input type="text" name="floor" value="{{ old('floor') }}" class="form-control" placeholder="Contoh: 1, 2, 3"> 
                                    </div>

                                    <!-- Site -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Site</label> 
                                        <input type="text" name="site" value="{{ old('site') }}" class="form-control" placeholder="Contoh: HO, Site"> 
                                    </div>

                                    <!-- Merk -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Merk</label> 
                                        <input type="text" name="merk" value="{{ old('merk') }}" class="form-control" placeholder="Contoh: Dell, Acer"> 
                                    </div>

                                    <!-- Kondisi -->
                                    <div class="col-md-6 mb-3">
                                        <label>Kondisi</label>
                                        <select name="kondisi" class="form-control">
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="layak pakai">Layak Pakai</option>
                                            <option value="baik">Baik</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                    </div>

                                    <!-- Model -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Model</label> 
                                        <textarea name="model" rows="3" class="form-control" placeholder="Contoh: Inspiron 14">{{ old('model') }}</textarea>
                                    </div>

                                    <!-- Spek -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Spek</label> 
                                        <textarea name="spek" rows="3" class="form-control" placeholder="Contoh: i5, RAM 16GB">{{ old('spek') }}</textarea>
                                    </div>

                                    <!-- Tanggal -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Tanggal</label> 
                                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control"> 
                                    </div>

                                    <!-- Nomor Seri -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>Nomor Seri</label> 
                                        <input type="text" name="serial_number" value="{{ old('serial_number') }}" class="form-control" placeholder="Contoh: SN1234567890"> 
                                    </div>

                                    <!-- History -->
                                    <div class="col-md-6 mb-3"> 
                                        <label>History</label> 
                                        <textarea name="history" rows="3" class="form-control" placeholder="Contoh: Site LABUHA LIN-BDL ">{{ old('history') }}</textarea>
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
                                            <option value="new">New</option>
                                            <option value="active">Active</option>
                                            <option value="reclaimed">Reclaimed</option>
                                            <option value="damaged">Damaged</option>
                                            <option value="lost">Lost</option>
                                            <option value="disposed">Disposed</option>
                                        </select>
                                    </div>

                                    <!-- Catatan -->
                                    <div class="col-md-12 mb-3"> 
                                        <label>Catatan</label> 
                                        <textarea name="catatan" rows="3" class="form-control" placeholder="Contoh: Barang perlu dicek">{{ old('catatan') }}</textarea>
                                    </div>
                                </div>
                            </div> <!-- col-md-8 -->
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

@endif

@endsection