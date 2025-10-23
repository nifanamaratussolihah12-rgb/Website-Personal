@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.asset.update', $edit->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="asset_kind" value="service">

                    <div class="card-body">
                        <h4 class="card-title">✏️ {{ $judul ?? 'Edit Service Item' }}</h4>
                        <hr>

                        <div class="row">
                            <!-- Kategori -->
                            <div class="col-md-6 mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori Service --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id }}" {{ $edit->kategori_id == $k->id ? 'selected' : '' }}>
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
                                        <option value="{{ $type->id }}" {{ $edit->type_asset_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->nama_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nama Service Item -->
                            <div class="col-md-6 mb-3">
                                <label>Nama Service Item</label>
                                <input type="text" name="item_name" value="{{ $edit->item_name }}"
                                    class="form-control @error('item_name') is-invalid @enderror"
                                    placeholder="Contoh: Maintenance Website, Lisensi Software">
                                @error('item_name')
                                    <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div class="form-group"> 
                                <label>Tanggal</label> 
                                <input type="date" 
                                    name="tanggal" 
                                    value="{{ old('tanggal', isset($edit->tanggal) ? \Carbon\Carbon::parse($edit->tanggal)->format('Y-m-d') : '') }}" 
                                    class="form-control @error('tanggal') is-invalid @enderror"> 
                                @error('tanggal') 
                                <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span> 
                                @enderror 
                            </div>

                            <!-- User -->
                            <div class="col-md-6 mb-3"> 
                                <label>User</label> 
                                <input type="text" name="user" value="{{ $edit->user }}" class="form-control" placeholder="Contoh: Rika"> 
                            </div>

                            <!-- Departemen -->
                            <div class="col-md-6 mb-3"> 
                                <label>Departemen</label> 
                                <input type="text" name="departemen" value="{{ $edit->departemen }}" class="form-control" placeholder="Contoh: IT, GA, Finance"> 
                            </div>

                            <!-- Site -->
                            <div class="col-md-6 mb-3">
                                <label>Site</label>
                                <input type="text" name="site" value="{{ $edit->site }}" class="form-control" placeholder="Contoh: HO, Site">
                            </div>

                            <!-- Jumlah -->
                            <div class="col-md-6 mb-3">
                                <label>Jumlah (Qty)</label>
                                <input type="number" name="qty" value="{{ $edit->qty }}" class="form-control" placeholder="Masukkan Jumlah">
                            </div>

                            <!-- Service ID -->
                            <div class="col-md-6 mb-3"> 
                                <label>Service ID</label> 
                                <input type="text" name="serial_number" value="{{ $edit->serial_number }}" class="form-control" placeholder="Contoh: LIC-2025-001, SUBS-98765"> 
                            </div>

                            <!-- Masa Garansi -->
                            <div class="form-group"> 
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
                                <input type="text" name="official_store" value="{{ $edit->official_store }}" class="form-control" placeholder="Contoh: Lenovo Official Store"> 
                            </div>

                            <!-- Reseller -->
                            <div class="col-md-6 mb-3"> 
                                <label>Reseller</label> 
                                <input type="text" name="reseller" value="{{ $edit->reseller }}" class="form-control" placeholder="Contoh: Toko Jaya Abadi"> 
                            </div>

                            <!-- Harga Beli -->
                            <div class="col-md-6 mb-3">
                                <label>Harga Beli</label>
                                <input type="text" name="harga_beli" id="harga_beli" value="{{ number_format($edit->harga_beli,0,',','.') }}" class="form-control" placeholder="Contoh: 1.200.000">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="new" {{ $edit->status=='new'?'selected':'' }}>New</option>
                                    <option value="active" {{ $edit->status=='active'?'selected':'' }}>Active</option>
                                    <option value="reclaimed" {{ $edit->status=='reclaimed'?'selected':'' }}>Reclaimed</option>
                                </select>
                            </div>

                            <!-- Catatan -->
                            <div class="col-md-6 mb-3">
                                <label>Catatan</label>
                                <textarea name="catatan" rows="3" class="form-control" placeholder="Contoh: Service perlu dicek">{{ $edit->catatan }}</textarea>
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
// sama seperti create_service
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
