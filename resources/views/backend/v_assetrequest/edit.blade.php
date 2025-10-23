@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">✏️ Edit Formulir Permintaan Asset IT</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('backend.assetrequest.update', $requestData->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Data Permintaan --}}
                <h5 class="mt-3 text-decoration-underline">Data Permintaan</h5>
                <div class="row">
                    {{-- Tipe Request --}}
                    <div class="col-md-6 mb-2">
                        <label for="request_type">{!! fieldLabel('Tipe Request', $requestData->request_type) !!}</label>
                        <select name="request_type" id="request_type" class="form-control border border-dark">
                            <option value="Request Baru" {{ old('request_type', $requestData->request_type) == 'Request Baru' ? 'selected' : '' }}>Request Baru</option>
                            <option value="Replacement ( refer to doc FP3IT)" {{ old('request_type', $requestData->request_type) == 'Replacement ( refer to doc FP3IT)' ? 'selected' : '' }}>Replacement ( refer to doc FP3IT)</option>
                        </select>

                        <input type="text" 
                               name="request_type_extra" 
                               id="request_type_extra" 
                               class="form-control mt-2 border border-dark" 
                               placeholder="Keterangan tambahan (jika ada)"
                               value="{{ old('request_type_extra', $requestData->request_type_extra) }}"
                               style="{{ old('request_type', $requestData->request_type) == 'Replacement ( refer to doc FP3IT)' ? '' : 'display:none;' }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="request_ref_num">{!! fieldLabel('Request Ref Num', $requestData->request_ref_num) !!}</label>
                        <input type="text" name="request_ref_num" id="request_ref_num" class="form-control border border-dark"
                               value="{{ old('request_ref_num', $requestData->request_ref_num) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nik">{!! fieldLabel('NIK', $requestData->nik) !!}</label>
                        <input type="text" name="nik" id="nik" class="form-control border border-dark" required
                               value="{{ old('nik', $requestData->nik) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dept">{!! fieldLabel('Departemen', $requestData->dept) !!}</label>
                        <input type="text" name="dept" id="dept" class="form-control border border-dark" required
                               value="{{ old('dept', $requestData->dept) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="section">{!! fieldLabel('Section', $requestData->section) !!}</label>
                        <input type="text" name="section" id="section" class="form-control border border-dark" required
                               value="{{ old('section', $requestData->section) }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="tipe_penyerahan">{!! fieldLabel('Tipe Penyerahan', $requestData->tipe_penyerahan) !!}</label>
                        <select name="tipe_penyerahan" id="tipe_penyerahan" class="form-select border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="New Asset" {{ old('tipe_penyerahan', $requestData->tipe_penyerahan) == 'New Asset' ? 'selected' : '' }}>New Asset</option>
                            <option value="Re-claimed Asset" {{ old('tipe_penyerahan', $requestData->tipe_penyerahan) == 'Re-claimed Asset' ? 'selected' : '' }}>Re-claimed Asset</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label for="asset_type">{!! fieldLabel('Tipe Asset', $requestData->asset_type) !!}</label>
                        <select name="asset_type" id="asset_type" class="form-select border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="Alat Komunikasi" {{ old('asset_type', $requestData->asset_type) == 'Alat Komunikasi' ? 'selected' : '' }}>Alat Komunikasi</option>
                            <option value="Aksesoris" {{ old('asset_type', $requestData->asset_type) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                            <option value="PC/Laptop" {{ old('asset_type', $requestData->asset_type) == 'PC/Laptop' ? 'selected' : '' }}>PC / Laptop</option>
                        </select>
                    </div>
                </div>

                {{-- Detail Request --}}
                <h5 class="mt-4 text-decoration-underline">Detail Request</h5>
                <div id="detail-rows">
                    @foreach(old('details', $requestData->details ?? []) as $i => $detail)
                        <div class="row detail-row mb-2">
                            <div class="col-md-3">
                                <label>{!! fieldLabel('Brand', $detail['brand'] ?? '') !!}</label>
                                <input type="text" name="details[{{ $i }}][brand]" class="form-control border border-dark" placeholder="Brand" value="{{ $detail['brand'] ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>{!! fieldLabel('Model', $detail['model'] ?? '') !!}</label>
                                <input type="text" name="details[{{ $i }}][model]" class="form-control border border-dark" placeholder="Model" value="{{ $detail['model'] ?? '' }}" required>
                            </div>
                            <div class="col-md-2">
                                <label>{!! fieldLabel('Qty', $detail['qty'] ?? '') !!}</label>
                                <input type="number" name="details[{{ $i }}][qty]" class="form-control border border-dark" placeholder="Qty" value="{{ $detail['qty'] ?? '' }}" required min="1">
                            </div>
                            <div class="col-md-3">
                                <label>{!! fieldLabel('User / PIC', $detail['user_pic'] ?? '') !!}</label>
                                <input type="text" name="details[{{ $i }}][user_pic]" class="form-control border border-dark" placeholder="User / PIC" value="{{ $detail['user_pic'] ?? '' }}" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-row">+ Tambah Baris</button>

                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi IT Staff</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dokumen" class="form-label">{!! fieldLabel('Tanggal Dokumen Diterbitkan', $requestData->tanggal_dokumen) !!}</label>
                        <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark" 
                            value="{{ old('tanggal_dokumen', $requestData->tanggal_dokumen?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_expired" class="form-label">{!! fieldLabel('Tanggal Dokumen Expired', $requestData->tanggal_expired) !!}</label>
                        <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark" 
                            value="{{ old('tanggal_expired', $requestData->tanggal_expired?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="status" class="form-label">{!! fieldLabel('Status', $requestData->status) !!}</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="">-- Pilih Item --</option>
                            <option value="pending approval" {{ old('status', $requestData->status) == 'pending approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approval" {{ old('status', $requestData->status) == 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="done" {{ old('status', $requestData->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan" class="form-label">{!! fieldLabel('Catatan', $requestData->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('catatan', $requestData->catatan) }}</textarea>
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
    <a href="{{ route('backend.assetrequest.index') }}" class="btn btn-secondary">Kembali</a>
</div>

{{-- Script Tambah/Hapus Baris --}}
<script>
    let rowIdx = {{ count(old('details', $requestData->details ?? [])) }};
    document.getElementById('add-row').addEventListener('click', function () {
        const container = document.getElementById('detail-rows');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'detail-row', 'mb-2');
        newRow.innerHTML = `
            <div class="col-md-3"><label>Brand</label><input type="text" name="details[${rowIdx}][brand]" class="form-control border border-dark" placeholder="Brand" required></div>
            <div class="col-md-3"><label>Model</label><input type="text" name="details[${rowIdx}][model]" class="form-control border border-dark" placeholder="Model" required></div>
            <div class="col-md-2"><label>Qty</label><input type="number" name="details[${rowIdx}][qty]" class="form-control border border-dark" placeholder="Qty" required min="1"></div>
            <div class="col-md-3"><label>User / PIC</label><input type="text" name="details[${rowIdx}][user_pic]" class="form-control border border-dark" placeholder="User / PIC" required></div>
            <div class="col-md-1 d-flex align-items-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></div>
        `;
        container.appendChild(newRow);
        rowIdx++;
    });

    document.getElementById('detail-rows').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.detail-row').remove();
        }
    });

    // toggle input tambahan tipe request
    const requestTypeSelect = document.getElementById('request_type');
    const requestTypeExtra = document.getElementById('request_type_extra');
    requestTypeSelect.addEventListener('change', function() {
        if (this.value.includes('Replacement')) {
            requestTypeExtra.style.display = 'block';
        } else {
            requestTypeExtra.style.display = 'none';
            requestTypeExtra.value = '';
        }
    });
</script>
@endsection
