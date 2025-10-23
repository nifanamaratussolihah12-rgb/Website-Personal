@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Finding</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.finding.cetak', session('finding_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.finding.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Informasi Umum --}}
                <h5 class="mt-3 text-decoration-underline">Informasi Umum</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="nama_departemen">Nama Departemen</label>
                        <input type="text" name="nama_departemen" id="nama_departemen" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="lokasi_temuan">Lokasi Temuan</label>
                        <input type="text" name="lokasi_temuan" id="lokasi_temuan" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_penemuan">Tanggal Penemuan</label>
                        <input type="date" name="tanggal_penemuan" id="tanggal_penemuan" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="judul_temuan">Judul Temuan</label>
                        <input type="text" name="judul_temuan" id="judul_temuan" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="deskripsi_temuan">Deskripsi Temuan</label>
                        <textarea name="deskripsi_temuan" id="deskripsi_temuan" class="form-control border border-dark" rows="3"></textarea>
                    </div>
                </div>

                {{-- Form Readiness --}}
                <h5 class="mt-4 text-decoration-underline">Form Readiness</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="form_readiness_terkait">Form Readiness Terkait</label>
                        <input type="text" name="form_readiness_terkait" id="form_readiness_terkait" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_form_readiness">Tanggal Form Readiness</label>
                        <input type="date" name="tanggal_form_readiness" id="tanggal_form_readiness" class="form-control border border-dark">
                    </div>
                </div>

                {{-- Bukti Temuan --}}
                <h5 class="mt-4 text-decoration-underline">Bukti Temuan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="bukti_temuan_foto">Upload Bukti Temuan</label>
                        <input type="file" name="bukti_temuan_foto" id="bukti_temuan_foto" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="bukti_temuan_text">Keterangan Bukti</label>
                        <textarea name="bukti_temuan_text" id="bukti_temuan_text" class="form-control border border-dark" rows="3" placeholder="Tuliskan keterangan bukti"></textarea>
                    </div>
                </div>

                {{-- Analisis Temuan --}}
                <h5 class="mt-4 text-decoration-underline">Analisis Temuan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="analisis_penyebab">Penyebab</label>
                        <textarea name="analisis_penyebab" id="analisis_penyebab" class="form-control border border-dark" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="analisis_dampak">Dampak</label>
                        <textarea name="analisis_dampak" id="analisis_dampak" class="form-control border border-dark" rows="3"></textarea>
                    </div>
                </div>

                {{-- Tindakan --}}
                <h5 class="mt-4 text-decoration-underline">Tindakan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tindakan_sementara">Tindakan Sementara</label>
                        <textarea name="tindakan_sementara" id="tindakan_sementara" class="form-control border border-dark" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tindakan_perbaikan">Tindakan Perbaikan</label>
                        <textarea name="tindakan_perbaikan" id="tindakan_perbaikan" class="form-control border border-dark" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="penanggung_jawab_tindakan">Penanggung Jawab Tindakan</label>
                        <input type="text" name="penanggung_jawab_tindakan" id="penanggung_jawab_tindakan" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="target_waktu_penyelesaian">Target Waktu Penyelesaian</label>
                        <input type="date" name="target_waktu_penyelesaian" id="target_waktu_penyelesaian" class="form-control border border-dark">
                    </div>
                </div>

                {{-- Status Follow Up --}}
                <h5 class="mt-4 text-decoration-underline">Status Follow Up</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="status_follow_up">Status</label>
                        <select name="status_follow_up" id="status_follow_up" class="form-select border border-dark">
                            <option value="" selected>-- Pilih Status --</option>
                            <option value="PJO">PJO</option>
                            <option value="MANAJEMEN">MANAJEMEN</option>
                            <option value="DIREKSI">DIREKSI</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_verifikasi">Tanggal Verifikasi</label>
                        <input type="date" name="tanggal_verifikasi" id="tanggal_verifikasi" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="hasil_verifikasi">Hasil Verifikasi</label>
                        <textarea name="hasil_verifikasi" id="hasil_verifikasi" class="form-control border border-dark" rows="3"></textarea>
                    </div>
                </div>

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
@endsection
