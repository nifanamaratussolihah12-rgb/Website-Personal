@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Permintaan Perbaikan Perangkat IT (F3PIT)</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.f3pit.cetak', session('f3pit_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.f3pit.store') }}" method="POST">
                @csrf
            {{-- TABEL SEBELAH KIRI --}}
                {{-- Informasi Umum --}}
                <h5 class="mt-3 text-decoration-underline">Informasi Umum</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="departement">Departemen</label>
                        <input type="text" name="departement" id="departement" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pic">PIC</label>
                        <input type="text" name="pic" id="pic" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="kode_inventaris">Kode Inventaris</label>
                        <input type="text" name="kode_inventaris" id="kode_inventaris" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tahun_perolehan">Tahun Perolehan</label>
                        <input type="date" name="tahun_perolehan" id="tahun_perolehan" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="jenis_inventaris">Jenis Inventaris</label>
                        <input type="text" name="jenis_inventaris" id="jenis_inventaris" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tipe">Tipe</label>
                        <input type="text" name="tipe" id="tipe" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="sn">S/N</label>
                        <input type="text" name="sn" id="sn" class="form-control border border-dark">
                    </div>
                </div>

                {{-- Sejarah Perbaikan --}}
                <h5 class="mt-4 text-decoration-underline">Sejarah Perbaikan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="sejarah_tanggal">Tanggal</label>
                        <input type="date" name="sejarah_tanggal" id="sejarah_tanggal" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="sejarah_keterangan">Keterangan</label>
                        <textarea name="sejarah_keterangan" id="sejarah_keterangan" rows="3" class="form-control border border-dark"></textarea>
                    </div>
                </div>

                {{-- Deskripsi Permasalahan --}}
                <h5 class="mt-4 text-decoration-underline">Deskripsi Permasalahan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <textarea name="deskripsi_permasalahan" 
                                id="deskripsi_permasalahan" 
                                rows="3" 
                                class="form-control border border-dark"></textarea>
                    </div>
                </div>

                {{-- Penyebab Kerusakan (checkbox + manual) --}}
                <h5 class="mt-4 text-decoration-underline">Penyebab Kerusakan</h5>
                <div class="row">
                    @php
                        $penyebabList = [
                            'perbaikan_sebelumnya_tidak_sempurna' => 'Perbaikan sebelumnya tidak sempurna',
                            'kesalahan_pengoperasian' => 'Kesalahan Pengoperasian',
                            'gangguan_listrik' => 'Gangguan Listrik/Petir',
                            'gangguan_hama' => 'Gangguan Hama (Binatang Pengerat)',
                            'lingkungan_lembab' => 'Lingkungan Lembab/Panas/Kotor',
                            'umur_pemakaian' => 'Umur Pemakaian',
                        ];
                    @endphp

                    {{-- Checkbox standar --}}
                    @foreach($penyebabList as $key => $label)
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    name="penyebab_kerusakan[{{ $key }}]" value="1" 
                                    id="penyebab_{{ $key }}">
                                <label class="form-check-label" for="penyebab_{{ $key }}">
                                    {{ $label }}
                                </label>
                            </div>
                        </div>
                    @endforeach

                    {{-- Checkbox Lainnya --}}
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="penyebab_kerusakan[lainnya_checkbox]" value="1" 
                                id="penyebab_lainnya_checkbox">
                            <label class="form-check-label" for="penyebab_lainnya_checkbox">
                                Lainnya
                            </label>
                        </div>
                        <textarea name="penyebab_kerusakan[lainnya_notes]" 
                                id="penyebab_kerusakan_lainnya_notes" 
                                rows="3" 
                                class="form-control border border-dark mt-2" 
                                placeholder="Notes"></textarea>
                    </div>
                </div>

                {{-- Langkah yang sudah dilakukan --}}
                <h5 class="mt-4 text-decoration-underline">Langkah yang Sudah Dilakukan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="langkah_dilakukan[konsultasi]" value="1" id="langkah_konsultasi">
                            <label class="form-check-label" for="langkah_konsultasi">Telah konsultasi dengan IT Dept. Sdr</label>
                        </div>
                        <input type="text" name="langkah_dilakukan[konsultasi_notes]" class="form-control mt-1 border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="langkah_dilakukan[perbaikan]" value="1" id="langkah_perbaikan">
                            <label class="form-check-label" for="langkah_perbaikan">Telah pernah diperbaiki di Vendor setempat, Toko</label>
                        </div>
                        <input type="text" name="langkah_dilakukan[perbaikan_notes]" class="form-control mt-1 border border-dark">
                    </div>
                </div>

            {{-- TABEL SEBELAH KANAN --}}
                {{-- Kondisi & Prioritas --}}
                <h5 class="mt-4 text-decoration-underline">Kondisi & Prioritas</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="kondisi_fisik">Kondisi Fisik Perangkat</label>
                        <textarea name="kondisi_fisik" id="kondisi_fisik" rows="4" class="form-control border border-dark"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="prioritas_pengerjaan">Prioritas Pengerjaan</label>
                        <select name="prioritas_pengerjaan" id="prioritas_pengerjaan" class="form-control border border-dark">
                            <option value="" selected>-- Pilih --</option>
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                            <option value="top_urgent">Top Urgent</option>
                        </select>
                    </div>
                </div>

                {{-- Approval --}}
                <h5 class="mt-4 text-decoration-underline">Approval</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="pemohon">Pemohon</label>
                        <input type="text" name="pemohon" id="pemohon" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dep_head">Dep. Head</label>
                        <input type="text" name="dep_head" id="dep_head" class="form-control border border-dark">
                    </div>
                </div>

                 {{-- Bagian User IT --}}
                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi oleh IT Dept.</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kelengkapan_dokumen" value="1" id="kelengkapan_dokumen">
                            <label class="form-check-label" for="kelengkapan_dokumen">Kelengkapan Dokumen</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="lampiran_formulir" value="1" id="lampiran_formulir">
                            <label class="form-check-label" for="lampiran_formulir">Lampiran Formulir</label>
                        </div>
                    </div>   
                </div>

                {{-- Pemeriksaan & Keputusan --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="diterima_oleh">Diterima Oleh</label>
                        <input type="text" name="diterima_oleh" id="diterima_oleh" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="garansi_sebelumnya">Garansi Sebelumnya</label>
                        <input type="date" name="garansi_sebelumnya" id="garansi_sebelumnya" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pemeriksaan_teknis_oleh">Pemeriksaan Teknis Oleh</label>
                        <input type="text" name="pemeriksaan_teknis_oleh" id="pemeriksaan_teknis_oleh" class="form-control border border-dark">
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="diputuskan_internal_it[setuju]" value="1" id="internal_it_setuju">
                            <label class="form-check-label" for="internal_it_setuju">Diputuskan Internal IT, dengan penggantian komponen</label>
                        </div>
                        <input type="text" name="diputuskan_internal_it[nama]" class="form-control mb-1 border border-dark">
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="diputuskan_vendor[setuju]" value="1" id="vendor_setuju">
                            <label class="form-check-label" for="vendor_setuju">Diputuskan diperbaiki ke Vendor</label>
                        </div>
                        <input type="text" name="diputuskan_vendor[nama]" class="form-control mb-1 border border-dark">
                    </div>
                </div>

                {{-- Hasil Perbaikan --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="hasil_diperiksa_oleh">Hasil Perbaikan diperiksa fisik oleh</label>
                        <input type="text" name="hasil_diperiksa_oleh" id="hasil_diperiksa_oleh" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="hasil_diperiksa_tgl">Tgl</label>
                        <input type="date" name="hasil_diperiksa_tgl" id="hasil_diperiksa_tgl" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sn_sesuai" value="1" id="sn_sesuai">
                            <label class="form-check-label" for="sn_sesuai">S/N Sesuai</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="bukti_penggantian" value="1" id="bukti_penggantian">
                            <label class="form-check-label" for="bukti_penggantian">Bukti Penggantian</label>
                        </div>
                    </div>
                </div>

                {{-- Bagian ini diisi IT Staff --}}
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
