@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Formulir Finding</h4>
        </div>
        <div class="card-body">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.finding.cetak', $finding->id) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.finding.update', $finding->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Informasi Umum --}}
                <h5 class="mt-3 text-decoration-underline">Informasi Umum</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="nama_departemen">{!! fieldLabel('Nama Departemen', $finding->nama_departemen) !!}</label>
                        <input type="text" name="nama_departemen" id="nama_departemen" class="form-control border border-dark" value="{{ old('nama_departemen', $finding->nama_departemen) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="lokasi_temuan">{!! fieldLabel('Lokasi Temuan', $finding->lokasi_temuan) !!}</label>
                        <input type="text" name="lokasi_temuan" id="lokasi_temuan" class="form-control border border-dark" value="{{ old('lokasi_temuan', $finding->lokasi_temuan) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_penemuan">{!! fieldLabel('Tanggal Penemuan', $finding->tanggal_penemuan) !!}</label>
                        <input type="date" name="tanggal_penemuan" id="tanggal_penemuan" class="form-control border border-dark" value="{{ old('tanggal_penemuan', $finding->tanggal_penemuan?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="judul_temuan">{!! fieldLabel('Judul Temuan', $finding->judul_temuan) !!}</label>
                        <input type="text" name="judul_temuan" id="judul_temuan" class="form-control border border-dark" value="{{ old('judul_temuan', $finding->judul_temuan) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="deskripsi_temuan">{!! fieldLabel('Deskripsi Temuan', $finding->deskripsi_temuan) !!}</label>
                        <textarea name="deskripsi_temuan" id="deskripsi_temuan" class="form-control border border-dark" rows="3">{{ old('deskripsi_temuan', $finding->deskripsi_temuan) }}</textarea>
                    </div>
                </div>

                {{-- Form Readiness --}}
                <h5 class="mt-4 text-decoration-underline">Form Readiness</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="form_readiness_terkait">{!! fieldLabel('Form Readiness Terkait', $finding->form_readiness_terkait) !!}</label>
                        <input type="text" name="form_readiness_terkait" id="form_readiness_terkait" class="form-control border border-dark" value="{{ old('form_readiness_terkait', $finding->form_readiness_terkait) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_form_readiness">{!! fieldLabel('Tanggal Form Readiness', $finding->tanggal_form_readiness) !!}</label>
                        <input type="date" name="tanggal_form_readiness" id="tanggal_form_readiness" class="form-control border border-dark" value="{{ old('tanggal_form_readiness', $finding->tanggal_form_readiness?->format('Y-m-d')) }}">
                    </div>
                </div>

                {{-- Bukti Temuan --}}
                <h5 class="mt-4 text-decoration-underline">Bukti Temuan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="bukti_temuan_foto">{!! fieldLabel('Upload Bukti Temuan', $finding->bukti_temuan_foto) !!}</label>
                        <input type="file" name="bukti_temuan_foto" id="bukti_temuan_foto" class="form-control border border-dark">
                        @if($finding->bukti_temuan_foto)
                            <small class="text-muted">Foto sebelumnya:</small><br>
                            <img src="{{ asset('storage/'.$finding->bukti_temuan_foto) }}" alt="Bukti Temuan" style="max-width:150px; margin-top:5px;">
                        @endif
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="bukti_temuan_text">{!! fieldLabel('Keterangan Bukti', $finding->bukti_temuan_text) !!}</label>
                        <textarea name="bukti_temuan_text" id="bukti_temuan_text" class="form-control border border-dark" rows="3">{{ old('bukti_temuan_text', $finding->bukti_temuan_text) }}</textarea>
                    </div>
                </div>

                {{-- Analisis Temuan --}}
                <h5 class="mt-4 text-decoration-underline">Analisis Temuan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="analisis_penyebab">{!! fieldLabel('Penyebab', $finding->analisis_penyebab) !!}</label>
                        <textarea name="analisis_penyebab" id="analisis_penyebab" class="form-control border border-dark" rows="3">{{ old('analisis_penyebab', $finding->analisis_penyebab) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="analisis_dampak">{!! fieldLabel('Dampak', $finding->analisis_dampak) !!}</label>
                        <textarea name="analisis_dampak" id="analisis_dampak" class="form-control border border-dark" rows="3">{{ old('analisis_dampak', $finding->analisis_dampak) }}</textarea>
                    </div>
                </div>

                {{-- Tindakan --}}
                <h5 class="mt-4 text-decoration-underline">Tindakan</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tindakan_sementara">{!! fieldLabel('Tindakan Sementara', $finding->tindakan_sementara) !!}</label>
                        <textarea name="tindakan_sementara" id="tindakan_sementara" class="form-control border border-dark" rows="3">{{ old('tindakan_sementara', $finding->tindakan_sementara) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tindakan_perbaikan">{!! fieldLabel('Tindakan Perbaikan', $finding->tindakan_perbaikan) !!}</label>
                        <textarea name="tindakan_perbaikan" id="tindakan_perbaikan" class="form-control border border-dark" rows="3">{{ old('tindakan_perbaikan', $finding->tindakan_perbaikan) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="penanggung_jawab_tindakan">{!! fieldLabel('Penanggung Jawab Tindakan', $finding->penanggung_jawab_tindakan) !!}</label>
                        <input type="text" name="penanggung_jawab_tindakan" id="penanggung_jawab_tindakan" class="form-control border border-dark" value="{{ old('penanggung_jawab_tindakan', $finding->penanggung_jawab_tindakan) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="target_waktu_penyelesaian">{!! fieldLabel('Target Waktu Penyelesaian', $finding->target_waktu_penyelesaian) !!}</label>
                        <input type="date" name="target_waktu_penyelesaian" id="target_waktu_penyelesaian" class="form-control border border-dark" value="{{ old('target_waktu_penyelesaian', $finding->target_waktu_penyelesaian?->format('Y-m-d')) }}">
                    </div>
                </div>

                {{-- Status Follow Up --}}
                <h5 class="mt-4 text-decoration-underline">Status Follow Up</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="status_follow_up">{!! fieldLabel('Status', $finding->status_follow_up) !!}</label>
                        <select name="status_follow_up" id="status_follow_up" class="form-select border border-dark">
                            <option value="">-- Pilih Status --</option>
                            <option value="PJO" {{ old('status_follow_up', $finding->status_follow_up) == 'PJO' ? 'selected' : '' }}>PJO</option>
                            <option value="MANAJEMEN" {{ old('status_follow_up', $finding->status_follow_up) == 'MANAJEMEN' ? 'selected' : '' }}>MANAJEMEN</option>
                            <option value="DIREKSI" {{ old('status_follow_up', $finding->status_follow_up) == 'DIREKSI' ? 'selected' : '' }}>DIREKSI</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_verifikasi">{!! fieldLabel('Tanggal Verifikasi', $finding->tanggal_verifikasi) !!}</label>
                        <input type="date" name="tanggal_verifikasi" id="tanggal_verifikasi" class="form-control border border-dark" value="{{ old('tanggal_verifikasi', $finding->tanggal_verifikasi?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="hasil_verifikasi">{!! fieldLabel('Hasil Verifikasi', $finding->hasil_verifikasi) !!}</label>
                        <textarea name="hasil_verifikasi" id="hasil_verifikasi" class="form-control border border-dark" rows="3">{{ old('hasil_verifikasi', $finding->hasil_verifikasi) }}</textarea>
                    </div>
                </div>

                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi IT Staff</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dokumen" class="form-label">{!! fieldLabel('Tanggal Dokumen Diterbitkan', $finding->tanggal_dokumen) !!}</label>
                        <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark" 
                            value="{{ old('tanggal_dokumen', $finding->tanggal_dokumen?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_expired" class="form-label">{!! fieldLabel('Tanggal Dokumen Expired', $finding->tanggal_expired) !!}</label>
                        <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark" 
                            value="{{ old('tanggal_expired', $finding->tanggal_expired?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="status" class="form-label">{!! fieldLabel('Status', $finding->status) !!}</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="">-- Pilih Item --</option>
                            <option value="pending approval" {{ old('status', $finding->status) == 'pending approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approval" {{ old('status', $finding->status) == 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="done" {{ old('status', $finding->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan" class="form-label">{!! fieldLabel('Catatan', $finding->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('catatan', $finding->catatan) }}</textarea>
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
    <a href="{{ route('backend.finding.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
