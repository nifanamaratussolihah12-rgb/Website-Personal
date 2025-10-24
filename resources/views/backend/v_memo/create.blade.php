@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Memo</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.memo.cetak', session('memo_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Memo
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.memo.store') }}" method="POST">
                @csrf

                {{-- Bagian Disposisi --}}
                <h5 class="mt-3 text-decoration-underline">Disposisi</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tgl_no_surat">TGL & No. Surat</label>
                        <input type="text" name="tgl_no_surat" id="tgl_no_surat" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="perihal">Perihal</label>
                        <div id="perihal-wrapper">
                            <div class="input-group mb-2">
                                <input type="text" name="perihal[]" class="form-control border border-dark">
                                <button type="button" class="btn btn-success add-perihal">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Script untuk tambah/hapus --}}
                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const wrapper = document.getElementById("perihal-wrapper");

                        wrapper.addEventListener("click", function(e) {
                            if (e.target.classList.contains("add-perihal")) {
                                let newInput = document.createElement("div");
                                newInput.classList.add("input-group", "mb-2");
                                newInput.innerHTML = `
                                    <input type="text" name="perihal[]" class="form-control border border-dark">
                                    <button type="button" class="btn btn-danger remove-perihal">-</button>
                                `;
                                wrapper.appendChild(newInput);
                            }

                            if (e.target.classList.contains("remove-perihal")) {
                                e.target.closest(".input-group").remove();
                            }
                        });
                    });
                    </script>
                    <div class="col-md-6 mb-2">
                        <label for="lampiran">Lampiran</label>
                        <input type="text" name="lampiran" id="lampiran" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dari_disposisi">Dari</label>
                        <input type="text" name="dari_disposisi" id="dari_disposisi" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_disposisi">Tanggal Disposisi</label>
                        <input type="date" name="tanggal_disposisi" id="tanggal_disposisi" class="form-control border border-dark">
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Tujuan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="disposisiAtas">
                            <tr>
                                <td><input type="text" name="disposisi_atas[tujuan][]" class="form-control border border-dark"></td>
                                <td><input type="text" name="disposisi_atas[status][]" class="form-control border border-dark"></td>
                                <td><input type="text" name="disposisi_atas[keterangan][]" class="form-control border border-dark"></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-success addRow" data-target="disposisiAtas">+</button>
                                </td>
                            </tr>
                        </tbody>

                        <!-- Baris statis DITERUSKAN -->
                        <tbody>
                            <tr>
                                <th colspan="4" style="text-align:left;">DITERUSKAN</th>
                            </tr>
                        </tbody>

                        <tbody id="disposisiBawah">
                            <tr>
                                <td><input type="text" name="disposisi_bawah[tujuan][]" class="form-control border border-dark"></td>
                                <td><input type="text" name="disposisi_bawah[status][]" class="form-control border border-dark"></td>
                                <td><input type="text" name="disposisi_bawah[keterangan][]" class="form-control border border-dark"></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-success addRow" data-target="disposisiBawah">+</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Script untuk tambah/hapus row disposisi --}}
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.addEventListener('click', function(e) {
                            if(e.target.classList.contains('addRow')) {
                                let targetId = e.target.dataset.target;
                                const target = document.getElementById(targetId);

                                let newRow = document.createElement('tr');
                                newRow.innerHTML = `
                                    <td><input type="text" name="${targetId.includes('Atas') ? 'disposisi_atas' : 'disposisi_bawah'}[tujuan][]" class="form-control border border-dark"></td>
                                    <td><input type="text" name="${targetId.includes('Atas') ? 'disposisi_atas' : 'disposisi_bawah'}[status][]" class="form-control border border-dark"></td>
                                    <td><input type="text" name="${targetId.includes('Atas') ? 'disposisi_atas' : 'disposisi_bawah'}[keterangan][]" class="form-control border border-dark"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                                    </td>
                                `;
                                target.appendChild(newRow);
                            }

                            if(e.target.classList.contains('removeRow')) {
                                e.target.closest('tr').remove();
                            }
                        });
                    });
                    </script>
                </div>

                {{-- Bagian Memo --}}
                <h5 class="mt-4 text-decoration-underline">Memo</h5>

                <div class="row mb-3">
                    <!-- Tempat -->
                    <div class="col-md-6 mb-2">
                        <label for="lokasi_memo">Tempat</label>
                        <input type="text" name="lokasi_memo" id="lokasi_memo" class="form-control border border-dark" placeholder="Jakarta" value="{{ old('lokasi_memo', $memo->lokasi ?? '') }}">
                    </div>

                    <!-- Tanggal -->
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_memo">Tanggal</label>
                        <input type="date" name="tanggal_memo" id="tanggal_memo" class="form-control border border-dark" value="{{ old('tanggal_memo', $memo->tanggal_memo ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label for="nomor">Nomor Memo</label>
                        <input type="text" name="nomor" id="nomor" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="kepada">Kepada</label>
                        <input type="text" name="kepada" id="kepada" class="form-control border border-dark">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label for="dari_memo">Dari</label>
                        <input type="text" name="dari_memo" id="dari_memo" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="perihal_memo">Perihal Memo</label>
                        <textarea name="perihal_memo" id="perihal_memo" class="form-control border border-dark" rows="5"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 mb-2">
                        <label for="isi">Isi Memo</label>
                        <textarea name="isi" id="isi" class="form-control border border-dark" rows="5"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- TTD Disusun Oleh -->
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disusun_nama">Disusun Oleh (Nama)</label>
                        <input type="text" name="ttd_disusun_nama" id="ttd_disusun_nama" class="form-control border border-dark" value="{{ old('ttd_disusun_nama') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disusun_jabatan">Disusun Oleh (Jabatan)</label>
                        <input type="text" name="ttd_disusun_jabatan" id="ttd_disusun_jabatan" class="form-control border border-dark" value="{{ old('ttd_disusun_jabatan') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- TTD Diperiksa Oleh -->
                    <div class="col-md-6 mb-2">
                        <label for="ttd_diperiksa_nama">Diperiksa Oleh (Nama)</label>
                        <input type="text" name="ttd_diperiksa_nama" id="ttd_diperiksa_nama" class="form-control border border-dark" value="{{ old('ttd_diperiksa_nama') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ttd_diperiksa_jabatan">Diperiksa Oleh (Jabatan)</label>
                        <input type="text" name="ttd_diperiksa_jabatan" id="ttd_diperiksa_jabatan" class="form-control border border-dark" value="{{ old('ttd_diperiksa_jabatan') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- TTD Disetujui Oleh -->
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disetujui_nama">Disetujui Oleh (Nama)</label>
                        <input type="text" name="ttd_disetujui_nama" id="ttd_disetujui_nama" class="form-control border border-dark" value="{{ old('ttd_disetujui_nama') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disetujui_jabatan">Disetujui Oleh (Jabatan)</label>
                        <input type="text" name="ttd_disetujui_jabatan" id="ttd_disetujui_jabatan" class="form-control border border-dark" value="{{ old('ttd_disetujui_jabatan') }}">
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

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/super-build/ckeditor.js"></script>
    <script>
    ClassicEditor
        .create(document.querySelector('#isi'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', '|',
                    'bulletedList', 'numberedList', '|',
                    'undo', 'redo'
                ]
            }
        })
        .then(editor => console.log("✅ CKEditor ready"))
        .catch(error => console.error("❌ CKEditor error:", error));
    </script>
@endpush
