@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Readiness/Kesiapan Instalasi</h4>
        </div>
        <div class="card-body">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.installreadyform.cetak', session('installreadyform_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.installreadyform.store') }}" method="POST">
                @csrf

                {{-- Bagian Proyek --}}
                <div class="row" style="font-size: 12px;"> {{-- Mengatur ukuran font untuk semua teks dalam row --}}
                    <div class="col-md-6 mb-2">
                        <label for="project" style="font-size: 12px;">PROJECT</label>
                        <input type="text" name="project" id="project" class="form-control form-control-sm border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="lokasi" style="font-size: 12px;">LOKASI</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control form-control-sm border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal" style="font-size: 12px;">TANGGAL</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control form-control-sm border border-dark" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tim_pelaksana" style="font-size: 12px;">TIM PELAKSANA</label>
                        <input type="text" name="tim_pelaksana" id="tim_pelaksana" class="form-control form-control-sm border border-dark" required>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="catatan" style="font-size: 11px;">*CATATAN TAMBAHAN</label>
                        <textarea name="catatan" id="catatan" class="form-control form-control-sm border border-dark" rows="3" style="width: 50%;"></textarea>
                    </div>
                </div>

                {{-- Persiapan Awal --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label style="font-size: 12px;"><strong>1. PERSIAPAN AWAL</strong></label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="persiapan_awal[]" value="INVENTARISASI PERANGKAT YANG AKAN DIPASANG" id="persiapan1">
                        <label class="form-check-label" for="persiapan1" style="font-size: 12px;">INVENTARISASI PERANGKAT YANG AKAN DIPASANG</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="persiapan_awal[]" value="KETERSEDIAAN INSTALASI LISTRIK DAN ARUS LISTRIK STABIL" id="persiapan2">
                        <label class="form-check-label" for="persiapan2" style="font-size: 12px;">KETERSEDIAAN INSTALASI LISTRIK DAN ARUS LISTRIK STABIL</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="persiapan_awal[]" value="PENJADWALAN INSTALASI" id="persiapan3">
                        <label class="form-check-label" for="persiapan3" style="font-size: 12px;">PENJADWALAN INSTALASI</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="persiapan_awal[]" value="KOORDINASI DENGAN DEPT. TERKAIT ( ELECTRICAL/PLANT MTC, SCM, HSE )" id="persiapan4">
                        <label class="form-check-label" for="persiapan4" style="font-size: 12px;">KOORDINASI DENGAN DEPT. TERKAIT ( ELECTRICAL/PLANT MTC, SCM, HSE )</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="persiapan_awal[]" value="PERSIAPAN ALAT DAN MATERIAL YANG DIBUTUHKAN" id="persiapan5">
                        <label class="form-check-label" for="persiapan5" style="font-size: 12px;">PERSIAPAN ALAT DAN MATERIAL YANG DIBUTUHKAN</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="persiapan_awal[]" value="PERENCANAAN RUANG/LAYOUT" id="persiapan6">
                        <label class="form-check-label" for="persiapan6" style="font-size: 12px;">PERENCANAAN RUANG/LAYOUT</label>
                    </div>
                </div>

                {{-- K3 --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label style="font-size: 12px;"><strong>2. KESEHATAN & KESELAMATAN KERJA (K3)</strong></label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="k3[]" value="PENGGUNAAN APD" id="k31">
                        <label class="form-check-label" for="k31" style="font-size: 12px;">PENGGUNAAN APD</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="k3[]" value="KONDISI KESEHATAN TIM PELAKSANA" id="k32">
                        <label class="form-check-label" for="k32" style="font-size: 12px;">KONDISI KESEHATAN TIM PELAKSANA</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="k3[]" value="TIANG INSTALASI TELAH TERSEDIA DAN DI COR" id="k33">
                        <label class="form-check-label" for="k33" style="font-size: 12px;">TIANG INSTALASI TELAH TERSEDIA DAN DI COR</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="k3[]" value="ANAK TANGGA PADA TIANG INSTALASI TELAH TERSEDIA DAN AMAN" id="k34">
                        <label class="form-check-label" for="k34" style="font-size: 12px;">ANAK TANGGA PADA TIANG INSTALASI TELAH TERSEDIA DAN AMAN</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="k3[]" value="LOKASI TIANG DAN SEKITARNYA TELAH DINYATAKAN AMAN OLEH TEAM HSE" id="k35">
                        <label class="form-check-label" for="k35" style="font-size: 12px;">LOKASI TIANG DAN SEKITARNYA TELAH DINYATAKAN AMAN OLEH TEAM HSE</label>
                    </div>
                </div>

                {{-- Aspek Teknis --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label style="font-size: 12px;"><strong>3. ASPEK TEKNIS</strong></label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aspek_teknis[]" value="KONFIGURASI PERANGKAT KERAS" id="teknis1">
                        <label class="form-check-label" for="teknis1" style="font-size: 12px;">KONFIGURASI PERANGKAT KERAS</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aspek_teknis[]" value="PENGATURAN JARINGAN/KONEKSI" id="teknis2">
                        <label class="form-check-label" for="teknis2" style="font-size: 12px;">PENGATURAN JARINGAN/KONEKSI</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aspek_teknis[]" value="PEMASANGAN KONFIGURASI PERANGKAT LUNAK" id="teknis3">
                        <label class="form-check-label" for="teknis3" style="font-size: 12px;">PEMASANGAN KONFIGURASI PERANGKAT LUNAK</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aspek_teknis[]" value="PENGUJIAN FUNGSI DAN KINERJA PERANGKAT" id="teknis4">
                        <label class="form-check-label" for="teknis4" style="font-size: 12px;">PENGUJIAN FUNGSI DAN KINERJA PERANGKAT</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aspek_teknis[]" value="INTEGRASI DENGAN SISTEM EXISTING" id="teknis5">
                        <label class="form-check-label" for="teknis5" style="font-size: 12px;">INTEGRASI DENGAN SISTEM EXISTING</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="aspek_teknis[]" value="DOKUMENTASI TEKNIS DAN PROSEDUR OPERASIONAL" id="teknis6">
                        <label class="form-check-label" for="teknis6" style="font-size: 12px;">DOKUMENTASI TEKNIS DAN PROSEDUR OPERASIONAL</label>
                    </div>
                </div>

                {{-- Manajemen Project --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label style="font-size: 12px;"><strong>4. MANAJEMEN PROJECT</strong></label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manajemen[]" value="PENUNJUKAN KOORDINATOR LAPANGAN" id="manajemen1">
                        <label class="form-check-label" for="manajemen1" style="font-size: 12px;">PENUNJUKAN KOORDINATOR LAPANGAN</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manajemen[]" value="PEMANTAUAN KEMAJUAN INSTALASI/PEMASANGAN" id="manajemen2">
                        <label class="form-check-label" for="manajemen2" style="font-size: 12px;">PEMANTAUAN KEMAJUAN INSTALASI/PEMASANGAN</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manajemen[]" value="PENANGANAN ISU DAN KENDALA" id="manajemen3">
                        <label class="form-check-label" for="manajemen3" style="font-size: 12px;">PENANGANAN ISU DAN KENDALA</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manajemen[]" value="KOORDINASI DENGAN VENDOR/PIHAK EKSTERNAL" id="manajemen4">
                        <label class="form-check-label" for="manajemen4" style="font-size: 12px;">KOORDINASI DENGAN VENDOR/PIHAK EKSTERNAL</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manajemen[]" value="PENYEDIAAN LAPORAN KEMAJUAN KEPADA MANAJEMEN" id="manajemen5">
                        <label class="form-check-label" for="manajemen5" style="font-size: 12px;">PENYEDIAAN LAPORAN KEMAJUAN KEPADA MANAJEMEN</label>
                    </div>
                </div>

                {{-- Pasca Project --}}
                <div class="mb-3" style="font-size: 12px;">
                    <label style="font-size: 12px;"><strong>5. PASCA PROJECT</strong></label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pasca[]" value="PELATIHAN PENGGUNA" id="pasca1">
                        <label class="form-check-label" for="pasca1" style="font-size: 12px;">PELATIHAN PENGGUNA</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pasca[]" value="PEMBUATAN DOKUMENTASI PENGGUNAAN DAN PEMELIHARAAN" id="pasca2">
                        <label class="form-check-label" for="pasca2" style="font-size: 12px;">PEMBUATAN DOKUMENTASI PENGGUNAAN DAN PEMELIHARAAN</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pasca[]" value="PENYIAPAN DUKUNGAN TEKNIS" id="pasca3">
                        <label class="form-check-label" for="pasca3" style="font-size: 12px;">PENYIAPAN DUKUNGAN TEKNIS</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pasca[]" value="EVALUASI KINERJA SISTEM" id="pasca4">
                        <label class="form-check-label" for="pasca4" style="font-size: 12px;">EVALUASI KINERJA SISTEM</label>
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
                        <label for="note">Catatan</label>
                        <textarea name="note" id="note" rows="3" class="form-control border border-dark" placeholder="Tambahkan catatan jika ada"></textarea>
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