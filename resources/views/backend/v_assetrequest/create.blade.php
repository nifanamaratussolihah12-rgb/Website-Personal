@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Permintaan Asset IT</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.assetrequest.cetak', session('asset_request_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.assetrequest.store') }}" method="POST">
                @csrf

                {{-- Data Permintaan --}}
                <h5 class="mt-3 text-decoration-underline">Data Permintaan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                    <label for="request_type">Tipe Request</label>
                    <select name="request_type" id="request_type" class="form-control border border-dark">
                        <option value="Request Baru">Request Baru</option>
                        <option value="Replacement ( refer to doc FP3IT)">Replacement ( refer to doc FP3IT)</option>
                    </select>

                    <input type="text" name="request_type_extra" id="request_type_extra" class="form-control mt-2 border border-dark" placeholder="Keterangan tambahan (jika ada)" style="display:none;">
                </div>

                <script>
                    const requestTypeSelect = document.getElementById('request_type');
                    const requestTypeExtra = document.getElementById('request_type_extra');

                    requestTypeSelect.addEventListener('change', function() {
                        if (this.value.includes('Replacement')) {
                            requestTypeExtra.style.display = 'block';
                        } else {
                            requestTypeExtra.style.display = 'none';
                            requestTypeExtra.value = ''; // bersihkan input
                        }
                    });
                </script>

                    <div class="col-md-6 mb-2">
                        <label for="request_ref_num">Request Ref Num</label>
                        <input type="text" name="request_ref_num" id="request_ref_num" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" id="nik" class="form-control border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dept">Departemen</label>
                        <input type="text" name="dept" id="dept" class="form-control border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="section">Section</label>
                        <input type="text" name="section" id="section" class="form-control border border-dark" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="tipe_penyerahan">Tipe Penyerahan</label>
                        <select name="tipe_penyerahan" id="tipe_penyerahan" class="form-select border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="New Asset">New Asset</option>
                            <option value="Re-claimed Asset">Re-claimed Asset</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-2">
                        <label for="asset_type">Tipe Asset</label>
                        <select name="asset_type" id="asset_type" class="form-select border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="Alat Komunikasi">Alat Komunikasi</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="PC/Laptop">PC / Laptop</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="asset_id">Item Asset</label>
                        <select name="details[0][asset_id]" id="asset_id" class="form-select border border-dark" required>
                            <option value="">-- Pilih Item --</option>
                            @foreach($asset->sortBy('item_name') as $a)
                                @php $labelTambahan = $a->room ?: $a->user; @endphp
                                <option value="{{ $a->id }}">
                                    {{ Str::limit($a->item_name, 25) }}
                                    {{ $labelTambahan ? ' (' . $labelTambahan . ')' : '' }}
                                    (Sisa: {{ $a->qty }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Detail Request --}}
                <h5 class="mt-4 text-decoration-underline">Detail Request</h5>
                <div id="detail-rows">
                    <div class="row detail-row mb-2 ">
                        <div class="col-md-3">
                            <input type="text" name="details[0][brand]" class="form-control border border-dark" placeholder="Brand" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="details[0][model]" class="form-control border border-dark" placeholder="Model" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="details[0][qty]" class="form-control border border-dark" placeholder="Qty" required min="1">
                            <small class="text-muted fst-italic">*Jumlah qty harus disesuaikan dengan stok tersedia</small>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="details[0][user_pic]" class="form-control border border-dark" placeholder="User / PIC" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-row">+ Tambah Baris</button>

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

{{-- Script Tambah/Hapus Baris --}}
<script>
    let rowIdx = 1;
    document.getElementById('add-row').addEventListener('click', function () {
        const container = document.getElementById('detail-rows');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'detail-row', 'mb-2');
        newRow.innerHTML = `
            <div class="col-md-3"><input type="text" name="details[${rowIdx}][brand]" class="form-control border border-dark" placeholder="Brand" required></div>
            <div class="col-md-3"><input type="text" name="details[${rowIdx}][model]" class="form-control border border-dark" placeholder="Model" required></div>
            <div class="col-md-2"><input type="number" name="details[${rowIdx}][qty]" class="form-control border border-dark" placeholder="Qty" required min="1"></div>
            <div class="col-md-3"><input type="text" name="details[${rowIdx}][user_pic]" class="form-control border border-dark" placeholder="User / PIC" required></div>
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
</script>
@endsection
