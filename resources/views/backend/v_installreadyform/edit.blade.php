@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit Formulir Readiness/Kesiapan Instalasi</h4>
        </div>
        <div class="card-body">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.installreadyform.cetak', $form->id) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.installreadyform.update', $form->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Bagian Proyek --}}
                <div class="row" style="font-size: 12px;">
                    <div class="col-md-6 mb-2">
                        <label for="project">{!! fieldLabel('PROJECT', $form->project) !!}</label>
                        <input type="text" name="project" id="project" class="form-control form-control-sm border border-dark" 
                            value="{{ old('project', $form->project) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="lokasi">{!! fieldLabel('LOKASI', $form->lokasi) !!}</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control form-control-sm border border-dark" 
                            value="{{ old('lokasi', $form->lokasi) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal">{!! fieldLabel('TANGGAL', $form->tanggal) !!}</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm border border-dark" 
                            value="{{ old('tanggal', $form->tanggal?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tim_pelaksana">{!! fieldLabel('TIM PELAKSANA', $form->tim_pelaksana) !!}</label>
                        <input type="text" name="tim_pelaksana" id="tim_pelaksana" class="form-control form-control-sm border border-dark" 
                            value="{{ old('tim_pelaksana', $form->tim_pelaksana) }}" required>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="catatan" style="font-size: 11px;">{!! fieldLabel('*CATATAN TAMBAHAN', $form->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" class="form-control form-control-sm border border-dark" rows="3" style="width: 50%;">{{ old('catatan', $form->catatan) }}</textarea>
                    </div>
                </div>

                {{-- Persiapan Awal --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label><strong>1. PERSIAPAN AWAL</strong></label>
                    @php $persiapan = old('persiapan_awal', $form->persiapan_awal ?? []); @endphp
                    @foreach([
                        "INVENTARISASI PERANGKAT YANG AKAN DIPASANG",
                        "KETERSEDIAAN INSTALASI LISTRIK DAN ARUS LISTRIK STABIL",
                        "PENJADWALAN INSTALASI",
                        "KOORDINASI DENGAN DEPT. TERKAIT ( ELECTRICAL/PLANT MTC, SCM, HSE )",
                        "PERSIAPAN ALAT DAN MATERIAL YANG DIBUTUHKAN",
                        "PERENCANAAN RUANG/LAYOUT"
                    ] as $idx => $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="persiapan_awal[]" value="{{ $item }}" id="persiapan{{ $idx }}"
                                {{ in_array($item, $persiapan) ? 'checked' : '' }}>
                            <label class="form-check-label" for="persiapan{{ $idx }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- K3 --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label><strong>2. KESEHATAN & KESELAMATAN KERJA (K3)</strong></label>
                    @php $k3 = old('k3', $form->k3 ?? []); @endphp
                    @foreach([
                        "PENGGUNAAN APD",
                        "KONDISI KESEHATAN TIM PELAKSANA",
                        "TIANG INSTALASI TELAH TERSEDIA DAN DI COR",
                        "ANAK TANGGA PADA TIANG INSTALASI TELAH TERSEDIA DAN AMAN",
                        "LOKASI TIANG DAN SEKITARNYA TELAH DINYATAKAN AMAN OLEH TEAM HSE"
                    ] as $idx => $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="k3[]" value="{{ $item }}" id="k3{{ $idx }}"
                                {{ in_array($item, $k3) ? 'checked' : '' }}>
                            <label class="form-check-label" for="k3{{ $idx }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- Aspek Teknis --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label><strong>3. ASPEK TEKNIS</strong></label>
                    @php $teknis = old('aspek_teknis', $form->aspek_teknis ?? []); @endphp
                    @foreach([
                        "KONFIGURASI PERANGKAT KERAS",
                        "PENGATURAN JARINGAN/KONEKSI",
                        "PEMASANGAN KONFIGURASI PERANGKAT LUNAK",
                        "PENGUJIAN FUNGSI DAN KINERJA PERANGKAT",
                        "INTEGRASI DENGAN SISTEM EXISTING",
                        "DOKUMENTASI TEKNIS DAN PROSEDUR OPERASIONAL"
                    ] as $idx => $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="aspek_teknis[]" value="{{ $item }}" id="teknis{{ $idx }}"
                                {{ in_array($item, $teknis) ? 'checked' : '' }}>
                            <label class="form-check-label" for="teknis{{ $idx }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- Manajemen Project --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label><strong>4. MANAJEMEN PROJECT</strong></label>
                    @php $manajemen = old('manajemen', $form->manajemen ?? []); @endphp
                    @foreach([
                        "PENUNJUKAN KOORDINATOR LAPANGAN",
                        "PEMANTAUAN KEMAJUAN INSTALASI/PEMASANGAN",
                        "PENANGANAN ISU DAN KENDALA",
                        "KOORDINASI DENGAN VENDOR/PIHAK EKSTERNAL",
                        "PENYEDIAAN LAPORAN KEMAJUAN KEPADA MANAJEMEN"
                    ] as $idx => $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="manajemen[]" value="{{ $item }}" id="manajemen{{ $idx }}"
                                {{ in_array($item, $manajemen) ? 'checked' : '' }}>
                            <label class="form-check-label" for="manajemen{{ $idx }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                {{-- Pasca Project --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label><strong>5. PASCA PROJECT</strong></label>
                    @php $pasca = old('pasca', $form->pasca ?? []); @endphp
                    @foreach([
                        "PELATIHAN PENGGUNA",
                        "PEMBUATAN DOKUMENTASI PENGGUNAAN DAN PEMELIHARAAN",
                        "PENYIAPAN DUKUNGAN TEKNIS",
                        "EVALUASI KINERJA SISTEM"
                    ] as $idx => $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pasca[]" value="{{ $item }}" id="pasca{{ $idx }}"
                                {{ in_array($item, $pasca) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pasca{{ $idx }}">{{ $item }}</label>
                        </div>
                    @endforeach
                </div>

                <h5 class="mt-4 text-decoration-underline">Bagian ini diisi IT Staff</h5>
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
                        <label for="note" class="form-label">{!! fieldLabel('note', $form->note) !!}</label>
                        <textarea name="note" id="note" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('note', $form->note) }}</textarea>
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
    <a href="{{ route('backend.installreadyform.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
