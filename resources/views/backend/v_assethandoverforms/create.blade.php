@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Serah Terima Asset IT</h4>
        </div>
        <div class="card-body">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.assethandoverforms.cetak', session('handover_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.assethandoverforms.store') }}" method="POST">
                @csrf

                {{-- Bagian User --}}
                <h5 class="mt-3 text-decoration-underline">Bagian ini diisi oleh User</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="nama_user">Nama</label>
                        <input type="text" name="nama_user" id="nama_user" class="form-control border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nik_user">NIK</label>
                        <input type="text" name="nik_user" id="nik_user" class="form-control border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dept">Departemen</label>
                        <input type="text" name="dept" id="dept" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="section">Section</label>
                        <input type="text" name="section" id="section" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control border border-dark" required>
                    </div>
                </div>

                {{-- Bagian IT --}}
                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi IT Staff</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tipe_asset">Tipe Asset</label>
                        <select name="tipe_asset" id="tipe_asset" class="form-control border border-dark">
                            <option value="">-- Pilih --</option>
                            <option value="PC/Laptop">PC/Laptop</option>
                            <option value="Radio">Radio</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Printer">Printer</option>
                            <option value="UPS">UPS</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Nama Asset</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="brand_asset" id="brand_asset" maxlength="20" class="form-control border border-dark" placeholder="Brand">
                            </div>
                            <div class="col-6">
                                <input type="text" name="model_asset" id="model_asset" maxlength="36" class="form-control border border-dark" placeholder="Model">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="handover_type">Tipe Penyerahan</label>
                        <select name="handover_type" id="handover_type" class="form-control border border-dark">
                            <option value="">-- Pilih --</option>
                            <option value="New Asset">New Asset</option>
                            <option value="Re-claimed Asset">Re-claimed Asset</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="asset_tag">Tag Asset</label>
                        <input type="text" name="asset_tag" id="asset_tag" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="serial_number">Serial Number (S/N)</label>
                        <input type="text" name="serial_number" id="serial_number" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ref_rl_acumatica">Referensi RL Acumatica</label>
                        <input type="text" name="ref_rl_acumatica" id="ref_rl_acumatica" class="form-control border border-dark">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="handover_by">Diserahkan Oleh (IT Staff)</label>
                        <input type="text" name="handover_by" id="handover_by" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="handover_by_nik">NIK IT Staff</label>
                        <input type="text" name="handover_by_nik" id="handover_by_nik" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="handover_date">Tanggal Diserahkan</label>
                        <input type="date" name="handover_date" id="handover_date" class="form-control border border-dark">
                    </div>
                </div>

                <div class="row">      
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dokumen">Tanggal Dokumen Diterbitkan</label>
                        <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_expired">Tanggal Dokumen Expired</label>
                        <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark">
                    </div>
                </div>

                <div class="row">  
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

{{-- Tombol Kembali --}}
<div class="text-center mt-3">
    <a href="{{ route('backend.asset-handover.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
