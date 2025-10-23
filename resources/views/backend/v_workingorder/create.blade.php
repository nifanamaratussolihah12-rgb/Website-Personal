@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Working Order</h4>
        </div>
        <div class="card-body">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.workingorder.cetak', session('working_order_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.workingorder.store') }}" method="POST">
                @csrf

                {{-- Bagian User --}}
                <h5 class="mt-3 text-decoration-underline">Bagian ini diisi oleh User</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="divisi">Divisi</label>
                        <input type="text" name="divisi" id="divisi" class="form-control border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="section">Section</label>
                        <input type="text" name="section" id="section" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="permintaan">Permintaan</label>
                        <textarea name="permintaan" id="permintaan" class="form-control border border-dark" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="jenis_pekerjaan">Jenis Pekerjaan</label>
                        <select name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-control border border-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="jaringan">Jaringan</option>
                            <option value="cctv">CCTV</option>
                            <option value="radio">Radio</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="details">Details</label>
                        <textarea name="details" id="details" class="form-control border border-dark" rows="2"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dokumen_diterima">Dokumen Diterima</label>
                        <input type="text" name="dokumen_diterima" id="dokumen_diterima" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="target_pengerjaan">Target Pengerjaan</label>
                        <input type="date" name="target_pengerjaan" id="target_pengerjaan" class="form-control border border-dark" required>
                    </div>
                </div>

                {{-- Bagian Task --}}
                <h5 class="mt-4 text-decoration-underline">IT & SI Preparation Checklist</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Sign</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- 1. Kesiapan Instalasi Listrik --}}
                        <tr>
                            <td><strong>Kesiapan instalasi listrik & ke-stabilan listrik</strong></td>
                            <td>
                                <select name="status_kesiapan_listrik" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_kesiapan_listrik" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_kesiapan_listrik" class="form-control border border-dark"></td>
                        </tr>

                        {{-- 2. Tiang --}}
                        <tr>
                            <td><strong>Tiang</strong></td>
                            <td>
                                <select name="status_tiang" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_tiang" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_tiang" class="form-control border border-dark"></td>
                        </tr>

                        {{-- 3. CCTV / Radio / Perangkat Jaringan --}}
                        <tr>
                            <td>
                                <select name="task_perangkat" class="form-control mt-1 border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="cctv">CCTV</option>
                                    <option value="radio">Radio</option>
                                    <option value="jaringan">Perangkat Jaringan</option>
                                </select>
                            </td>
                            <td>
                                <select name="status_perangkat" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_perangkat" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_perangkat" class="form-control border border-dark"></td>
                        </tr>

                        {{-- 4. Panel --}}
                        <tr>
                            <td><strong>Panel</strong></td>
                            <td>
                                <select name="status_panel" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_panel" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_panel" class="form-control border border-dark"></td>
                        </tr>

                       {{-- 5. Keselamatan Kerja (Manual) --}}
                        <tr>
                            <td><strong>Keselamatan Kerja</strong></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_keselamatan[]" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_keselamatan[]" class="form-control border border-dark"></td>
                        </tr>

                        {{-- Baris nomor 1 --}}
                        <tr>
                            <td><input type="text" name="task_keselamatan[]" class="form-control border border-dark" placeholder="1. ..."></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_keselamatan[]" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_keselamatan[]" class="form-control border border-dark"></td>
                        </tr>

                        {{-- Baris nomor 2 --}}
                        <tr>
                            <td><input type="text" name="task_keselamatan[]" class="form-control border border-dark" placeholder="2. ..."></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_keselamatan[]" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_keselamatan[]" class="form-control border border-dark"></td>
                        </tr>

                        {{-- Baris nomor 3 --}}
                        <tr>
                            <td><input type="text" name="task_keselamatan[]" class="form-control border border-dark" placeholder="3. ..."></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_keselamatan[]" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_keselamatan[]" class="form-control border border-dark"></td>
                        </tr>

                        {{-- Baris nomor 4 --}}
                        <tr>
                            <td><input type="text" name="task_keselamatan[]" class="form-control border border-dark" placeholder="4. ..."></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_keselamatan[]" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_keselamatan[]" class="form-control border border-dark"></td>
                        </tr>

                        {{-- Baris nomor 5 --}}
                        <tr>
                            <td><input type="text" name="task_keselamatan[]" class="form-control border border-dark" placeholder="5. ..."></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_keselamatan[]" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_keselamatan[]" class="form-control border border-dark"></td>
                        </tr>

                        {{-- Baris nomor 6 --}}
                        <tr>
                            <td><input type="text" name="task_keselamatan[]" class="form-control border border-dark" placeholder="6. ..."></td>
                            <td>
                                <select name="status_keselamatan[]" class="form-control border border-dark">
                                    <option value="">-- Pilih --</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </td>
                            <td><input type="text" name="reason_keselamatan[]" class="form-control border border-dark"></td>
                            <td><input type="text" name="sign_keselamatan[]" class="form-control border border-dark"></td>
                        </tr>
                    </tbody>
                </table>

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

{{-- Tombol Kembali --}}
<div class="text-center mt-3">
     <a href="{{ route('backend.asset-handover.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
