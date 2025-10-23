@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Formulir Permintaan Perbaikan Perangkat IT (F3PIT)</h4>
        </div>
        <div class="card-body">
            {{-- Alert sukses --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.f3pit.cetak', $form->id) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            {{-- Form Edit --}}
            <form action="{{ route('backend.f3pit.update', $form->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informasi Umum --}}
                <h5 class="mt-3 text-decoration-underline">Informasi Umum</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="departement">{!! fieldLabel('Departemen', $form->departement) !!}</label>
                        <input type="text" name="departement" id="departement" class="form-control border border-dark"
                            value="{{ old('departement', $form->departement) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pic">{!! fieldLabel('PIC', $form->pic) !!}</label>
                        <input type="text" name="pic" id="pic" class="form-control border border-dark"
                            value="{{ old('pic', $form->pic) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="jabatan">{!! fieldLabel('Jabatan', $form->jabatan) !!}</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control border border-dark"
                            value="{{ old('jabatan', $form->jabatan) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="kode_inventaris">{!! fieldLabel('Kode Inventaris', $form->kode_inventaris) !!}</label>
                        <input type="text" name="kode_inventaris" id="kode_inventaris" class="form-control border border-dark"
                            value="{{ old('kode_inventaris', $form->kode_inventaris) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tahun_perolehan">{!! fieldLabel('Tahun Perolehan', $form->tahun_perolehan) !!}</label>
                        <input type="date" name="tahun_perolehan" id="tahun_perolehan" 
                            class="form-control border border-dark"
                            value="{{ old('tahun_perolehan', $form->tahun_perolehan?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="jenis_inventaris">{!! fieldLabel('Jenis Inventaris', $form->jenis_inventaris) !!}</label>
                        <input type="text" name="jenis_inventaris" id="jenis_inventaris" class="form-control border border-dark"
                            value="{{ old('jenis_inventaris', $form->jenis_inventaris) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="brand">{!! fieldLabel('Brand', $form->brand) !!}</label>
                        <input type="text" name="brand" id="brand" class="form-control border border-dark"
                            value="{{ old('brand', $form->brand) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tipe">{!! fieldLabel('Tipe', $form->tipe) !!}</label>
                        <input type="text" name="tipe" id="tipe" class="form-control border border-dark"
                            value="{{ old('tipe', $form->tipe) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="sn">{!! fieldLabel('S/N', $form->sn) !!}</label>
                        <input type="text" name="sn" id="sn" class="form-control border border-dark"
                            value="{{ old('sn', $form->sn) }}">
                    </div>
                </div>

                {{-- Sejarah Perbaikan --}}
                <h5 class="mt-4 text-decoration-underline">Sejarah Perbaikan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="sejarah_tanggal">{!! fieldLabel('Tanggal', $form->sejarah_tanggal) !!}</label>
                        <input type="date" name="sejarah_tanggal" id="sejarah_tanggal" 
                            class="form-control border border-dark"
                            value="{{ old('sejarah_tanggal', $form->sejarah_tanggal?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="sejarah_keterangan">{!! fieldLabel('Keterangan', $form->sejarah_keterangan) !!}</label>
                        <textarea name="sejarah_keterangan" id="sejarah_keterangan" rows="3" class="form-control border border-dark">{{ old('sejarah_keterangan', $form->sejarah_keterangan) }}</textarea>
                    </div>
                </div>

                {{-- Deskripsi Permasalahan --}}
                <h5 class="mt-4 text-decoration-underline">{!! fieldLabel('Deskripsi Permasalahan', $form->deskripsi_permasalahan) !!}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <textarea name="deskripsi_permasalahan" id="deskripsi_permasalahan" rows="3" class="form-control border border-dark">{{ old('deskripsi_permasalahan', $form->deskripsi_permasalahan) }}</textarea>
                    </div>
                </div>

                {{-- Penyebab Kerusakan --}}
                <h5 class="mt-4 text-decoration-underline">{!! fieldLabel('Penyebab Kerusakan', $form->penyebab_kerusakan) !!}</h5>
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
                        $penyebabChecked = old('penyebab_kerusakan', $form->penyebab_kerusakan ?? []);
                    @endphp

                    @foreach($penyebabList as $key => $label)
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    name="penyebab_kerusakan[{{ $key }}]" value="1" 
                                    id="penyebab_{{ $key }}"
                                    {{ isset($penyebabChecked[$key]) ? 'checked' : '' }}>
                                <label class="form-check-label" for="penyebab_{{ $key }}">{{ $label }}</label>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="penyebab_kerusakan[lainnya_checkbox]" value="1" 
                                id="penyebab_lainnya_checkbox"
                                {{ old('penyebab_kerusakan.lainnya_checkbox', !empty($penyebabChecked['lainnya_notes'])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="penyebab_lainnya_checkbox">Lainnya</label>
                        </div>

                        <textarea name="penyebab_kerusakan[lainnya_notes]" 
                            id="penyebab_kerusakan_lainnya_notes"
                            rows="3" 
                            class="form-control border border-dark mt-2"
                            placeholder="Notes">{{ old('penyebab_kerusakan.lainnya_notes', $penyebabChecked['lainnya_notes'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Langkah yang sudah dilakukan --}}
                <h5 class="mt-4 text-decoration-underline">Langkah yang Sudah Dilakukan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="langkah_dilakukan[konsultasi]" value="1" id="langkah_konsultasi"
                                {{ old('langkah_dilakukan.konsultasi', $form->langkah_dilakukan['konsultasi'] ?? null) ? 'checked' : '' }}>
                            <label class="form-check-label" for="langkah_konsultasi">
                                {!! fieldLabel('Telah konsultasi dengan IT Dept. Sdr', $form->langkah_dilakukan['konsultasi'] ?? null) !!}
                            </label>
                        </div>
                        <input type="text" name="langkah_dilakukan[konsultasi_notes]"
                            class="form-control mt-1 border border-dark"
                            value="{{ old('langkah_dilakukan.konsultasi_notes', $form->langkah_dilakukan['konsultasi_notes'] ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="langkah_dilakukan[perbaikan]" value="1" id="langkah_perbaikan"
                                {{ old('langkah_dilakukan.perbaikan', $form->langkah_dilakukan['perbaikan'] ?? null) ? 'checked' : '' }}>
                            <label class="form-check-label" for="langkah_perbaikan">
                                {!! fieldLabel('Telah pernah diperbaiki di Vendor setempat, Toko', $form->langkah_dilakukan['perbaikan'] ?? null) !!}
                            </label>
                        </div>
                        <input type="text" name="langkah_dilakukan[perbaikan_notes]"
                            class="form-control mt-1 border border-dark"
                            value="{{ old('langkah_dilakukan.perbaikan_notes', $form->langkah_dilakukan['perbaikan_notes'] ?? '') }}">
                    </div>
                </div>

                {{-- Kondisi & Prioritas --}}
                <h5 class="mt-4 text-decoration-underline">Kondisi & Prioritas</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="kondisi_fisik">{!! fieldLabel('Kondisi Fisik Perangkat', $form->kondisi_fisik) !!}</label>
                        <textarea name="kondisi_fisik" id="kondisi_fisik" rows="4" class="form-control border border-dark">{{ old('kondisi_fisik', $form->kondisi_fisik) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="prioritas_pengerjaan">{!! fieldLabel('Prioritas Pengerjaan', $form->prioritas_pengerjaan) !!}</label>
                        <select name="prioritas_pengerjaan" id="prioritas_pengerjaan" class="form-control border border-dark">
                            <option value="">-- Pilih --</option>
                            <option value="normal" {{ old('prioritas_pengerjaan', $form->prioritas_pengerjaan) == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="urgent" {{ old('prioritas_pengerjaan', $form->prioritas_pengerjaan) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            <option value="top_urgent" {{ old('prioritas_pengerjaan', $form->prioritas_pengerjaan) == 'top_urgent' ? 'selected' : '' }}>Top Urgent</option>
                        </select>
                    </div>
                </div>

                {{-- Approval --}}
                <h5 class="mt-4 text-decoration-underline">Approval</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="pemohon">{!! fieldLabel('Pemohon', $form->pemohon) !!}</label>
                        <input type="text" name="pemohon" id="pemohon" class="form-control border border-dark"
                            value="{{ old('pemohon', $form->pemohon) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dep_head">{!! fieldLabel('Dep. Head', $form->dep_head) !!}</label>
                        <input type="text" name="dep_head" id="dep_head" class="form-control border border-dark"
                            value="{{ old('dep_head', $form->dep_head) }}">
                    </div>
                </div>

                {{-- Bagian User IT --}}
                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi oleh IT Dept.</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kelengkapan_dokumen" value="1" id="kelengkapan_dokumen"
                                {{ old('kelengkapan_dokumen', $form->kelengkapan_dokumen) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kelengkapan_dokumen">{!! fieldLabel('Kelengkapan Dokumen', $form->kelengkapan_dokumen) !!}</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="lampiran_formulir" value="1" id="lampiran_formulir"
                                {{ old('lampiran_formulir', $form->lampiran_formulir) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lampiran_formulir">{!! fieldLabel('Lampiran Formulir', $form->lampiran_formulir) !!}</label>
                        </div>
                    </div>
                </div>

                {{-- Pemeriksaan & Keputusan --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="diterima_oleh">{!! fieldLabel('Diterima Oleh', $form->diterima_oleh) !!}</label>
                        <input type="text" name="diterima_oleh" id="diterima_oleh" class="form-control border border-dark"
                            value="{{ old('diterima_oleh', $form->diterima_oleh) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal">{!! fieldLabel('Tanggal', $form->tanggal) !!}</label>
                        <input type="date" name="tanggal" id="tanggal" 
                            class="form-control border border-dark"
                            value="{{ old('tanggal', $form->tanggal?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="garansi_sebelumnya">{!! fieldLabel('Garansi Sebelumnya', $form->garansi_sebelumnya) !!}</label>
                        <input type="date" name="garansi_sebelumnya" id="garansi_sebelumnya" 
                            class="form-control border border-dark"
                            value="{{ old('garansi_sebelumnya', $form->garansi_sebelumnya?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="pemeriksaan_teknis_oleh">{!! fieldLabel('Pemeriksaan Teknis Oleh', $form->pemeriksaan_teknis_oleh) !!}</label>
                        <input type="text" name="pemeriksaan_teknis_oleh" id="pemeriksaan_teknis_oleh" class="form-control border border-dark"
                            value="{{ old('pemeriksaan_teknis_oleh', $form->pemeriksaan_teknis_oleh) }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="diputuskan_internal_it[setuju]" value="1" id="internal_it_setuju"
                                {{ old('diputuskan_internal_it.setuju', $form->diputuskan_internal_it['setuju'] ?? null) ? 'checked' : '' }}>
                            <label class="form-check-label" for="internal_it_setuju">
                                {!! fieldLabel('Diputuskan Internal IT, dengan penggantian komponen', [
                                    $form->diputuskan_internal_it['setuju'] ?? null,
                                    $form->diputuskan_internal_it['nama'] ?? null
                                ]) !!}
                            </label>
                        </div>
                        <input type="text" name="diputuskan_internal_it[nama]" 
                            class="form-control mb-1 border border-dark"
                            value="{{ old('diputuskan_internal_it.nama', $form->diputuskan_internal_it['nama'] ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="diputuskan_vendor[setuju]" value="1" id="vendor_setuju"
                                {{ old('diputuskan_vendor.setuju', $form->diputuskan_vendor['setuju'] ?? null) ? 'checked' : '' }}>
                            <label class="form-check-label" for="vendor_setuju">
                                {!! fieldLabel('Diputuskan diperbaiki ke Vendor', [
                                    $form->diputuskan_vendor['setuju'] ?? null,
                                    $form->diputuskan_vendor['nama'] ?? null
                                ]) !!}
                            </label>
                        </div>
                        <input type="text" name="diputuskan_vendor[nama]" 
                            class="form-control mb-1 border border-dark"
                            value="{{ old('diputuskan_vendor.nama', $form->diputuskan_vendor['nama'] ?? '') }}">
                    </div>
                </div>

                {{-- Hasil Perbaikan --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="hasil_diperiksa_oleh">{!! fieldLabel('Hasil Perbaikan diperiksa fisik oleh', $form->hasil_diperiksa_oleh) !!}</label>
                        <input type="text" name="hasil_diperiksa_oleh" id="hasil_diperiksa_oleh" class="form-control border border-dark"
                            value="{{ old('hasil_diperiksa_oleh', $form->hasil_diperiksa_oleh) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="hasil_diperiksa_tgl">{!! fieldLabel('Tgl', $form->hasil_diperiksa_tgl) !!}</label>
                        <input type="date" name="hasil_diperiksa_tgl" id="hasil_diperiksa_tgl" 
                            class="form-control border border-dark"
                            value="{{ old('hasil_diperiksa_tgl', $form->hasil_diperiksa_tgl?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sn_sesuai" value="1" id="sn_sesuai"
                                {{ old('sn_sesuai', $form->sn_sesuai) ? 'checked' : '' }}>
                            <label class="form-check-label" for="sn_sesuai">{!! fieldLabel('S/N Sesuai', $form->sn_sesuai) !!}</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="bukti_penggantian" value="1" id="bukti_penggantian"
                                {{ old('bukti_penggantian', $form->bukti_penggantian) ? 'checked' : '' }}>
                            <label class="form-check-label" for="bukti_penggantian">{!! fieldLabel('Ada Bukti Penggantian Komponen', $form->bukti_penggantian) !!}</label>
                        </div>
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

<div class="text-center mt-3">
    <a href="{{ route('backend.f3pit.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
