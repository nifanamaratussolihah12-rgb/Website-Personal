@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit Formulir Peralihan Asset IT</h4>
        </div>
        <div class="card-body">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.assettransfer.cetak', $transfer->id) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.assettransfer.update', $transfer->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Data Asset --}}
                <h5 class="mt-3 text-decoration-underline">Data Asset</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="asset_tag" class="form-label">{!! fieldLabel('Tag Asset', $transfer->asset_tag) !!}</label>
                        <input type="text" name="asset_tag" id="asset_tag" class="form-control border border-dark"
                               value="{{ old('asset_tag', $transfer->asset_tag) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">{!! fieldLabel('Nama Asset', $transfer->asset_brand || $transfer->asset_model) !!}</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="asset_brand" id="asset_brand" class="form-control border border-dark"
                                       value="{{ old('asset_brand', $transfer->asset_brand) }}" placeholder="Brand">
                            </div>
                            <div class="col-6">
                                <input type="text" name="asset_model" id="asset_model" class="form-control border border-dark"
                                       value="{{ old('asset_model', $transfer->asset_model) }}" placeholder="Model">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="category" class="form-label">{!! fieldLabel('Kategori', $transfer->category) !!}</label>
                        <input type="text" name="category" id="category" class="form-control border border-dark"
                               value="{{ old('category', $transfer->category) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="serial_number" class="form-label">{!! fieldLabel('Nomor Seri', $transfer->serial_number) !!}</label>
                        <input type="text" name="serial_number" id="serial_number" class="form-control border border-dark"
                               value="{{ old('serial_number', $transfer->serial_number) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="purchase_date" class="form-label">{!! fieldLabel('Tanggal Pembelian', $transfer->purchase_date) !!}</label>
                        <input type="date" name="purchase_date" id="purchase_date" class="form-control border border-dark"
                               value="{{ old('purchase_date', $transfer->purchase_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="purchase_price" class="form-label">{!! fieldLabel('Harga Pembelian', $transfer->purchase_price) !!}</label>
                        <div class="input-group">
                            <span class="input-group-text border border-dark">Rp.</span>
                            <input type="text" name="purchase_price" id="purchase_price" class="form-control border border-dark"
                                   value="{{ old('purchase_price', number_format($transfer->purchase_price, 0, ',', '.')) }}">
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="warranty_status" class="form-label">{!! fieldLabel('Status Garansi', $transfer->warranty_status) !!}</label>
                        <input type="text" name="warranty_status" id="warranty_status" class="form-control border border-dark"
                               value="{{ old('warranty_status', $transfer->warranty_status) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="warranty_end_date" class="form-label">{!! fieldLabel('Tanggal Akhir Garansi', $transfer->warranty_end_date) !!}</label>
                        <input type="date" name="warranty_end_date" id="warranty_end_date" class="form-control border border-dark"
                               value="{{ old('warranty_end_date', $transfer->warranty_end_date?->format('Y-m-d')) }}">
                    </div>
                </div>

                {{-- Pemilik Sebelumnya --}}
                <h5 class="mt-4 text-decoration-underline">Pemilik Sebelumnya</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="prev_department" class="form-label">{!! fieldLabel('Departemen', $transfer->prev_department) !!}</label>
                        <input type="text" name="prev_department" id="prev_department" class="form-control border border-dark"
                               value="{{ old('prev_department', $transfer->prev_department) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="prev_user" class="form-label">{!! fieldLabel('Pengguna', $transfer->prev_user) !!}</label>
                        <input type="text" name="prev_user" id="prev_user" class="form-control border border-dark"
                               value="{{ old('prev_user', $transfer->prev_user) }}">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="transfer_reason" class="form-label">{!! fieldLabel('Alasan Pengalihan', $transfer->transfer_reason) !!}</label>
                        <textarea name="transfer_reason" id="transfer_reason" rows="2" class="form-control border border-dark">{{ old('transfer_reason', $transfer->transfer_reason) }}</textarea>
                    </div>
                </div>

                {{-- Pemilik Baru --}}
                <h5 class="mt-4 text-decoration-underline">Pemilik Baru</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="new_department" class="form-label">{!! fieldLabel('Departemen', $transfer->new_department) !!}</label>
                        <input type="text" name="new_department" id="new_department" class="form-control border border-dark"
                               value="{{ old('new_department', $transfer->new_department) }}" >
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="new_user" class="form-label">{!! fieldLabel('Pengguna', $transfer->new_user) !!}</label>
                        <input type="text" name="new_user" id="new_user" class="form-control border border-dark"
                               value="{{ old('new_user', $transfer->new_user) }}" >
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="transfer_date" class="form-label">{!! fieldLabel('Tanggal Pengalihan', $transfer->transfer_date) !!}</label>
                        <input type="date" name="transfer_date" id="transfer_date" class="form-control border border-dark"
                               value="{{ old('transfer_date', $transfer->transfer_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="placement_location" class="form-label">{!! fieldLabel('Lokasi Penempatan', $transfer->placement_location) !!}</label>
                        <input type="text" name="placement_location" id="placement_location" class="form-control border border-dark"
                               value="{{ old('placement_location', $transfer->placement_location) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="asset_condition" class="form-label">{!! fieldLabel('Kondisi Asset', $transfer->asset_condition) !!}</label>
                        <input type="text" name="asset_condition" id="asset_condition" class="form-control border border-dark"
                               value="{{ old('asset_condition', $transfer->asset_condition) }}">
                    </div>
                </div>

                {{-- Bagian ini diisi IT Staff --}}
                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi IT Staff</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dokumen" class="form-label">{!! fieldLabel('Tanggal Dokumen Diterbitkan', $transfer->tanggal_dokumen) !!}</label>
                        <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark"
                               value="{{ old('tanggal_dokumen', $transfer->tanggal_dokumen?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_expired" class="form-label">{!! fieldLabel('Tanggal Dokumen Expired', $transfer->tanggal_expired) !!}</label>
                        <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark"
                               value="{{ old('tanggal_expired', $transfer->tanggal_expired?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="status" class="form-label">{!! fieldLabel('Status', $transfer->status) !!}</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="">-- Pilih Item --</option>
                            <option value="pending approval" {{ old('status', $transfer->status) == 'pending approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approval" {{ old('status', $transfer->status) == 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="done" {{ old('status', $transfer->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan" class="form-label">{!! fieldLabel('Catatan', $transfer->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('catatan', $transfer->catatan) }}</textarea>
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
    <a href="{{ route('backend.assettransfer.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
