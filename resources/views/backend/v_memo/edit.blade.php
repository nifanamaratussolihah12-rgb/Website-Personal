@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit Formulir Memo</h4>
        </div>
        <div class="card-body">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.memo.cetak', $memo->id) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Memo
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.memo.update', $memo->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Bagian Disposisi --}}
                <h5 class="mt-3 text-decoration-underline">Disposisi</h5>
                <div class="row" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="tgl_no_surat">{!! fieldLabel('TGL & No. Surat', $memo->tgl_no_surat) !!}</label>
                        <input type="text" name="tgl_no_surat" id="tgl_no_surat" class="form-control form-control-sm border border-dark"
                            value="{{ old('tgl_no_surat', $memo->tgl_no_surat) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="lampiran">{!! fieldLabel('Lampiran', $memo->lampiran) !!}</label>
                        <input type="text" name="lampiran" id="lampiran" class="form-control form-control-sm border border-dark"
                            value="{{ old('lampiran', $memo->lampiran) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dari_disposisi">{!! fieldLabel('Dari', $memo->dari_disposisi) !!}</label>
                        <input type="text" name="dari_disposisi" id="dari_disposisi" class="form-control form-control-sm border border-dark"
                            value="{{ old('dari_disposisi', $memo->dari_disposisi) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_disposisi">{!! fieldLabel('Tanggal Disposisi', $memo->tanggal_disposisi) !!}</label>
                        <input type="date" name="tanggal_disposisi" id="tanggal_disposisi" class="form-control form-control-sm border border-dark"
                            value="{{ old('tanggal_disposisi', $memo->tanggal_disposisi?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="perihal">Perihal</label>
                        <div id="perihal-wrapper">
                            @php
                                // Ambil old value kalau ada, jika tidak coba decode dari $memo->perihal (bisa array atau json)
                                $perihals = old('perihal', []);
                                if (empty($perihals)) {
                                    $raw = $memo->perihal ?? null;
                                    if (is_string($raw)) {
                                        $decoded = json_decode($raw, true);
                                        $arr = is_array($decoded) ? $decoded : [];
                                    } else {
                                        $arr = is_array($raw) ? $raw : [];
                                    }
                                    if (!empty($arr)) {
                                        $perihals = $arr;
                                    }
                                }
                                if (empty($perihals)) {
                                    $perihals = [''];
                                }
                            @endphp

                            @foreach($perihals as $idx => $p)
                                <div class="input-group mb-2">
                                    <input type="text" name="perihal[]" class="form-control border border-dark" value="{{ $p }}">
                                    @if($idx === 0)
                                        <button type="button" class="btn btn-success add-perihal">+</button>
                                    @else
                                        <button type="button" class="btn btn-danger remove-perihal">-</button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const wrapper = document.getElementById("perihal-wrapper");

                        wrapper.addEventListener("click", function(e) {
                            // Tambah input baru
                            if (e.target.classList.contains("add-perihal")) {
                                let newInput = document.createElement("div");
                                newInput.className = "input-group mb-2";
                                newInput.innerHTML = `
                                    <input type="text" name="perihal[]" class="form-control border border-dark" value="">
                                    <button type="button" class="btn btn-danger remove-perihal">-</button>
                                `;
                                wrapper.appendChild(newInput);
                            }

                            // Hapus input yang di-klik
                            if (e.target.classList.contains("remove-perihal")) {
                                e.target.closest(".input-group").remove();

                                // Jika kosong seluruhnya, buat satu input kosong dengan tombol add
                                if (wrapper.querySelectorAll('.input-group').length === 0) {
                                    wrapper.innerHTML = `<div class="input-group mb-2">
                                        <input type="text" name="perihal[]" class="form-control border border-dark" value="">
                                        <button type="button" class="btn btn-success add-perihal">+</button>
                                    </div>`;
                                }
                            }
                        });
                    });
                    </script>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Tujuan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        {{-- Disposisi Atas --}}
                        <tbody id="disposisiAtas">
                            @php
                                $disposisi = is_array($memo->disposisi) ? $memo->disposisi : json_decode($memo->disposisi, true);
                                $atas = old('disposisi_atas', $disposisi['atas'] ?? []);
                            @endphp

                            @if(!empty($atas))
                                @foreach($atas as $i => $row)
                                    <tr>
                                        <td><input type="text" name="disposisi_atas[tujuan][]" class="form-control border border-dark" value="{{ $row['tujuan'] ?? '' }}"></td>
                                        <td><input type="text" name="disposisi_atas[status][]" class="form-control border border-dark" value="{{ $row['status'] ?? '' }}"></td>
                                        <td><input type="text" name="disposisi_atas[keterangan][]" class="form-control border border-dark" value="{{ $row['keterangan'] ?? '' }}"></td>
                                        <td class="text-center">
                                            @if($i == 0)
                                                <button type="button" class="btn btn-sm btn-success addRow" data-target="disposisiAtas">+</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td><input type="text" name="disposisi_atas[tujuan][]" class="form-control border border-dark"></td>
                                    <td><input type="text" name="disposisi_atas[status][]" class="form-control border border-dark"></td>
                                    <td><input type="text" name="disposisi_atas[keterangan][]" class="form-control border border-dark"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-success addRow" data-target="disposisiAtas">+</button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>


                        {{-- Baris statis DITERUSKAN --}}
                        <tbody>
                            <tr>
                                <th colspan="4" style="text-align:left;">DITERUSKAN</th>
                            </tr>
                        </tbody>

                        {{-- Disposisi Bawah --}}
                        <tbody id="disposisiBawah">
                            @php
                                $bawah = old('disposisi_bawah', $disposisi['bawah'] ?? []);
                            @endphp

                            @if(!empty($bawah))
                                @foreach($bawah as $i => $row)
                                    <tr>
                                        <td><input type="text" name="disposisi_bawah[tujuan][]" class="form-control border border-dark" value="{{ $row['tujuan'] ?? '' }}"></td>
                                        <td><input type="text" name="disposisi_bawah[status][]" class="form-control border border-dark" value="{{ $row['status'] ?? '' }}"></td>
                                        <td><input type="text" name="disposisi_bawah[keterangan][]" class="form-control border border-dark" value="{{ $row['keterangan'] ?? '' }}"></td>
                                        <td class="text-center">
                                            @if($i == 0)
                                                <button type="button" class="btn btn-sm btn-success addRow" data-target="disposisiBawah">+</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td><input type="text" name="disposisi_bawah[tujuan][]" class="form-control border border-dark"></td>
                                    <td><input type="text" name="disposisi_bawah[status][]" class="form-control border border-dark"></td>
                                    <td><input type="text" name="disposisi_bawah[keterangan][]" class="form-control border border-dark"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-success addRow" data-target="disposisiBawah">+</button>
                                    </td>
                                </tr>
                            @endif
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

                <div class="row mb-3" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="lokasi_memo">{!! fieldLabel('Tempat', $memo->lokasi_memo) !!}</label>
                        <input type="text" name="lokasi_memo" id="lokasi_memo" class="form-control form-control-sm border border-dark"
                            value="{{ old('lokasi_memo', $memo->lokasi_memo) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_memo">{!! fieldLabel('Tanggal', $memo->tanggal_memo) !!}</label>
                        <input type="date" name="tanggal_memo" id="tanggal_memo" class="form-control form-control-sm border border-dark"
                            value="{{ old('tanggal_memo', $memo->tanggal_memo?->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="row mb-3" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="nomor">{!! fieldLabel('Nomor Memo', $memo->nomor) !!}</label>
                        <input type="text" name="nomor" id="nomor" class="form-control form-control-sm border border-dark"
                            value="{{ old('nomor', $memo->nomor) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="kepada">{!! fieldLabel('Kepada', $memo->kepada) !!}</label>
                        <input type="text" name="kepada" id="kepada" class="form-control form-control-sm border border-dark"
                            value="{{ old('kepada', $memo->kepada) }}">
                    </div>
                </div>

                <div class="row mb-3" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="dari_memo">{!! fieldLabel('Dari', $memo->dari_memo) !!}</label>
                        <input type="text" name="dari_memo" id="dari_memo" class="form-control form-control-sm border border-dark"
                            value="{{ old('dari_memo', $memo->dari_memo) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="perihal_memo">{!! fieldLabel('Perihal Memo', $memo->perihal_memo) !!}</label>
                        <textarea name="perihal_memo" id="perihal_memo" class="form-control form-control-sm border border-dark" rows="3">{{ old('perihal_memo', $memo->perihal_memo) }}</textarea>
                    </div>
                </div>

                <div class="row mb-3" style="font-size: 12px;">
                    <div class="col-12 mb-2">
                        <label for="isi">{!! fieldLabel('Isi Memo', $memo->isi) !!}</label>
                        <textarea name="isi" id="isi" class="form-control form-control-sm border border-dark" rows="5">{{ old('isi', $memo->isi) }}</textarea>
                    </div>
                </div>

                {{-- Bagian TTD --}}
                <h5 class="mt-4 text-decoration-underline">Tanda Tangan</h5>
                <div class="row mb-3" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disusun_nama">{!! fieldLabel('Disusun Oleh (Nama)', $memo->ttd_disusun_nama) !!}</label>
                        <input type="text" name="ttd_disusun_nama" id="ttd_disusun_nama" class="form-control form-control-sm border border-dark"
                            value="{{ old('ttd_disusun_nama', $memo->ttd_disusun_nama) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disusun_jabatan">{!! fieldLabel('Disusun Oleh (Jabatan)', $memo->ttd_disusun_jabatan) !!}</label>
                        <input type="text" name="ttd_disusun_jabatan" id="ttd_disusun_jabatan" class="form-control form-control-sm border border-dark"
                            value="{{ old('ttd_disusun_jabatan', $memo->ttd_disusun_jabatan) }}">
                    </div>
                </div>

                <div class="row mb-3" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="ttd_diperiksa_nama">{!! fieldLabel('Diperiksa Oleh (Nama)', $memo->ttd_diperiksa_nama) !!}</label>
                        <input type="text" name="ttd_diperiksa_nama" id="ttd_diperiksa_nama" class="form-control form-control-sm border border-dark"
                            value="{{ old('ttd_diperiksa_nama', $memo->ttd_diperiksa_nama) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ttd_diperiksa_jabatan">{!! fieldLabel('Diperiksa Oleh (Jabatan)', $memo->ttd_diperiksa_jabatan) !!}</label>
                        <input type="text" name="ttd_diperiksa_jabatan" id="ttd_diperiksa_jabatan" class="form-control form-control-sm border border-dark"
                            value="{{ old('ttd_diperiksa_jabatan', $memo->ttd_diperiksa_jabatan) }}">
                    </div>
                </div>

                <div class="row mb-3" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disetujui_nama">{!! fieldLabel('Disetujui Oleh (Nama)', $memo->ttd_disetujui_nama) !!}</label>
                        <input type="text" name="ttd_disetujui_nama" id="ttd_disetujui_nama" class="form-control form-control-sm border border-dark"
                            value="{{ old('ttd_disetujui_nama', $memo->ttd_disetujui_nama) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="ttd_disetujui_jabatan">{!! fieldLabel('Disetujui Oleh (Jabatan)', $memo->ttd_disetujui_jabatan) !!}</label>
                        <input type="text" name="ttd_disetujui_jabatan" id="ttd_disetujui_jabatan" class="form-control form-control-sm border border-dark"
                            value="{{ old('ttd_disetujui_jabatan', $memo->ttd_disetujui_jabatan) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="status" class="form-label">{!! fieldLabel('Status', $memo->status) !!}</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="">-- Pilih Item --</option>
                            <option value="pending approval" {{ old('status', $memo->status) == 'pending approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approval" {{ old('status', $memo->status) == 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="done" {{ old('status', $memo->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan" class="form-label">{!! fieldLabel('Catatan', $memo->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('catatan', $memo->catatan) }}</textarea>
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
    <a href="{{ route('backend.memo.index') }}" class="btn btn-secondary">Kembali</a>
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
