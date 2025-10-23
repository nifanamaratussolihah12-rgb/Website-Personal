@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit Formulir Serah Terima Asset IT</h4>
        </div>
        <div class="card-body">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.assethandoverforms.cetak', $form->id) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.assethandoverforms.update', $form->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Bagian User --}}
                <h5 class="mt-3 text-decoration-underline">Bagian ini diisi oleh User</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="nama_user" class="form-label">{!! fieldLabel('Nama', $form->nama_user) !!}</label>
                        <input type="text" name="nama_user" id="nama_user" class="form-control border border-dark" 
                            value="{{ old('nama_user', $form->nama_user) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nik_user" class="form-label">{!! fieldLabel('NIK', $form->nik_user) !!}</label>
                        <input type="text" name="nik_user" id="nik_user" class="form-control border border-dark" 
                            value="{{ old('nik_user', $form->nik_user) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dept" class="form-label">{!! fieldLabel('Departemen', $form->dept) !!}</label>
                        <input type="text" name="dept" id="dept" class="form-control border border-dark"
                            value="{{ old('dept', $form->dept) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="section" class="form-label">{!! fieldLabel('Section', $form->section) !!}</label>
                        <input type="text" name="section" id="section" class="form-control border border-dark"
                            value="{{ old('section', $form->section) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal" class="form-label">{!! fieldLabel('Tanggal', $form->tanggal) !!}</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control border border-dark"
                            value="{{ old('tanggal', $form->tanggal?->format('Y-m-d')) }}" required>
                    </div>
                </div>

                {{-- Bagian IT --}}
                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi IT Staff</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tipe_asset" class="form-label">{!! fieldLabel('Tipe Asset', $form->tipe_asset) !!}</label>
                        <select name="tipe_asset" id="tipe_asset" class="form-control border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="PC/Laptop" {{ old('tipe_asset', $form->tipe_asset) == 'PC/Laptop' ? 'selected' : '' }}>PC/Laptop</option>
                            <option value="Radio" {{ old('tipe_asset', $form->tipe_asset) == 'Radio' ? 'selected' : '' }}>Radio</option>
                            <option value="Aksesoris" {{ old('tipe_asset', $form->tipe_asset) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                            <option value="Printer" {{ old('tipe_asset', $form->tipe_asset) == 'Printer' ? 'selected' : '' }}>Printer</option>
                            <option value="UPS" {{ old('tipe_asset', $form->tipe_asset) == 'UPS' ? 'selected' : '' }}>UPS</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">{!! fieldLabel('Nama Asset', $form->brand_asset || $form->model_asset) !!}</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="brand_asset" id="brand_asset" maxlength="20" 
                                    class="form-control border border-dark" placeholder="Brand" 
                                    value="{{ old('brand_asset', $form->brand_asset) }}" required>
                            </div>
                            <div class="col-6">
                                <input type="text" name="model_asset" id="model_asset" maxlength="36" 
                                    class="form-control border border-dark" placeholder="Model" 
                                    value="{{ old('model_asset', $form->model_asset) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="handover_type" class="form-label">{!! fieldLabel('Tipe Penyerahan', $form->handover_type) !!}</label>
                        <select name="handover_type" id="handover_type" class="form-control border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="New Asset" {{ old('handover_type', $form->handover_type) == 'New Asset' ? 'selected' : '' }}>New Asset</option>
                            <option value="Re-claimed Asset" {{ old('handover_type', $form->handover_type) == 'Re-claimed Asset' ? 'selected' : '' }}>Re-claimed Asset</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="asset_tag" class="form-label">{!! fieldLabel('Tag Asset', $form->asset_tag) !!}</label>
                        <input type="text" name="asset_tag" id="asset_tag" class="form-control border border-dark"
                            value="{{ old('asset_tag', $form->asset_tag) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="asset_sn" class="form-label">{!! fieldLabel('Serial Number (S/N)', $form->asset_sn) !!}</label>
                        <input type="text" name="asset_sn" id="asset_sn" class="form-control border border-dark"
                            value="{{ old('asset_sn', $form->asset_sn) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ref_rl_acumatica" class="form-label">{!! fieldLabel('Referensi RL Acumatica', $form->ref_rl_acumatica) !!}</label>
                        <input type="text" name="ref_rl_acumatica" id="ref_rl_acumatica" class="form-control border border-dark"
                            value="{{ old('ref_rl_acumatica', $form->ref_rl_acumatica) }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="handover_by" class="form-label">{!! fieldLabel('Diserahkan Oleh (IT Staff)', $form->handover_by) !!}</label>
                        <input type="text" name="handover_by" id="handover_by" class="form-control border border-dark" 
                            value="{{ old('handover_by', $form->handover_by) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="handover_by_nik" class="form-label">{!! fieldLabel('NIK IT Staff', $form->handover_by_nik) !!}</label>
                        <input type="text" name="handover_by_nik" id="handover_by_nik" class="form-control border border-dark"
                            value="{{ old('handover_by_nik', $form->handover_by_nik) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="handover_date" class="form-label">{!! fieldLabel('Tanggal Diserahkan', $form->handover_date) !!}</label>
                        <input type="date" name="handover_date" id="handover_date" class="form-control border border-dark" 
                            value="{{ old('handover_date', $form->handover_date?->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dokumen" class="form-label">{!! fieldLabel('Tanggal Dokumen Diterbitkan', $form->tanggal_dokumen) !!}</label>
                        <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark" 
                            value="{{ old('tanggal_dokumen', $form->tanggal_dokumen?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_expired" class="form-label">{!! fieldLabel('Tanggal Dokumen Expired', $form->tanggal_expired) !!}</label>
                        <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark" 
                            value="{{ old('tanggal_expired', $form->tanggal_expired?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="status" class="form-label">{!! fieldLabel('Status', $form->status) !!}</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="">-- Pilih Item --</option>
                            <option value="pending approval" {{ old('status', $form->status) == 'pending approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approval" {{ old('status', $form->status) == 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="done" {{ old('status', $form->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan" class="form-label">{!! fieldLabel('Catatan', $form->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('catatan', $form->catatan) }}</textarea>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tombol Kembali --}}
<div class="text-center mt-3">
    <a href="{{ route('backend.assethandoverforms.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
