@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Peralihan Asset IT</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.assettransfer.cetak', session('transfer_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.assettransfer.store') }}" method="POST">
                @csrf

                {{-- Data Asset --}}
                <h5 class="mt-3 text-decoration-underline">Data Asset</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="asset_tag">Tag Asset</label>
                        <input type="text" name="asset_tag" id="asset_tag" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Nama Asset</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="asset_brand" id="asset_brand" maxlength="20" class="form-control border border-dark" placeholder="Brand">
                            </div>
                            <div class="col-6">
                                <input type="text" name="asset_model" id="asset_model" maxlength="36" class="form-control border border-dark" placeholder="Model">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="category">Kategori</label>
                        <input type="text" name="category" id="category" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="serial_number">Nomor Seri</label>
                        <input type="text" name="serial_number" id="serial_number" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="purchase_date">Tanggal Pembelian</label>
                        <input type="date" name="purchase_date" id="purchase_date" class="form-control border border-dark">
                    </div>
                   <div class="col-md-6 mb-2">
                        <label for="purchase_price">Harga Pembelian <small class="text-muted">(contoh: 1.000.000)</small></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text border border-dark">Rp.</span>
                            <input type="text" name="purchase_price" id="purchase_price" class="form-control border border-dark" placeholder="1.000.000">
                        </div>
                    </div>
                    <script>
                    document.getElementById('purchase_price').addEventListener('input', function (e) {
                        let value = e.target.value.replace(/\D/g, ""); // Hapus semua karakter non-angka
                        if (value) {
                            e.target.value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambah titik setiap ribuan
                        } else {
                            e.target.value = "";
                        }
                    });
                    </script>
                    <div class="col-md-6 mb-2">
                        <label for="warranty_status">Status Garansi</label>
                        <input type="text" name="warranty_status" id="warranty_status" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="warranty_end_date">Tanggal Akhir Garansi</label>
                        <input type="date" name="warranty_end_date" id="warranty_end_date" class="form-control border border-dark">
                    </div>
                </div>

                {{-- Data Pemilik Sebelumnya --}}
                <h5 class="mt-4 text-decoration-underline">Pemilik Sebelumnya</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="prev_department">Departemen</label>
                        <input type="text" name="prev_department" id="prev_department" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="prev_user">Pengguna</label>
                        <input type="text" name="prev_user" id="prev_user" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="transfer_reason">alasan Pengalihan</label>
                        <input type="text" name="transfer_reason" id="transfer_reason" class="form-control border border-dark">
                    </div>
                </div>

                {{-- Data Pemilik Baru --}}
                <h5 class="mt-4 text-decoration-underline">Pemilik Baru</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="new_department">Departemen</label>
                        <input type="text" name="new_department" id="new_department" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="new_user">Pengguna</label>
                        <input type="text" name="new_user" id="new_user" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="transfer_date">Tanggal Pengalihan</label>
                        <input type="date" name="transfer_date" id="transfer_date" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="placement_location">Lokasi Penempatan</label>
                        <input type="text" name="placement_location" id="placement_location" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="asset_condition">Kondisi Asset</label>
                        <input type="text" name="asset_condition" id="asset_condition" class="form-control border border-dark">
                    </div>
                </div>

                {{-- Bagian ini diisi IT Staff --}}
                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi IT Staff</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dokumen">Tanggal Dokumen Diterbitkan</label>
                        <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_expired">Tanggal Dokumen Expired</label>
                        <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="pending approval">Pending Approval</option>
                            <option value="approval">Approval</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control border border-dark" placeholder="Tambahkan catatan jika ada"></textarea>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success">Simpan & Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="text-center mt-3">
    <a href="{{ route('backend.asset-handover.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
