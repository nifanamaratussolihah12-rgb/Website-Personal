@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir Permintaan Login Email / Internet</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <br>
                    <a href="{{ route('backend.loginrequest.cetak', session('login_request_id')) }}" target="_blank" class="btn btn-success mt-2">
                        Cetak Form
                    </a>
                </div>
            @endif

            <form action="{{ route('backend.loginrequest.store') }}" method="POST">
                @csrf

                {{-- Informasi Umum --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="cabang">Cabang</label>
                        <input type="text" name="cabang" id="cabang" class="form-control border border-dark">
                    </div>

                    {{-- Company --}}
                    <div class="col-md-6 mb-2">
                        <label for="is_abm_group">Company</label>
                        <select name="is_abm_group" id="is_abm_group" class="form-select border border-dark">
                            <option value="" selected>-- Pilih --</option>
                            <option value="1">ABM Group</option>
                            <option value="0">Other</option>
                        </select>
                    </div>

                    {{-- input untuk ABM Group --}}
                    <div class="col-md-6 mb-2 d-none" id="abm_wrapper">
                        <label for="company_abm">Nama Perusahaan (ABM Group)</label>
                        <input type="text" name="company_abm" id="company_abm" class="form-control border border-dark" placeholder="PT ______ / ABM Group">
                    </div>

                    {{-- input untuk Other --}}
                    <div class="col-md-6 mb-2 d-none" id="other_wrapper">
                        <label for="company_other">Nama Perusahaan (Other)</label>
                        <input type="text" name="company_other" id="company_other" class="form-control border border-dark" placeholder="Isi nama perusahaan">
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const select = document.getElementById('is_abm_group');
                        const abmWrapper = document.getElementById('abm_wrapper');
                        const otherWrapper = document.getElementById('other_wrapper');
                        const abmInput = document.getElementById('company_abm');
                        const otherInput = document.getElementById('company_other');

                        select.addEventListener('change', function () {
                            if (this.value === '1') {
                                abmWrapper.classList.remove('d-none');
                                otherWrapper.classList.add('d-none');
                                otherInput.value = ''; // reset other
                            } else if (this.value === '0') {
                                otherWrapper.classList.remove('d-none');
                                abmWrapper.classList.add('d-none');
                                abmInput.value = ''; // reset abm
                            } else {
                                // kalau belum pilih apa-apa, sembunyikan semua
                                abmWrapper.classList.add('d-none');
                                otherWrapper.classList.add('d-none');
                                abmInput.value = '';
                                otherInput.value = '';
                            }
                        });
                    });
                    </script>
                </div>

                {{-- Jenis Permintaan --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="jenis_permintaan">Jenis Permintaan</label>
                        <select name="jenis_permintaan" id="jenis_permintaan" class="form-select border border-dark">
                            <option value="" selected>-- Pilih --</option>
                            <option value="email">Email</option>
                            <option value="internet">Internet</option>
                        </select>
                    </div>

                    {{-- Sub jenis kalau pilih Email --}}
                    <div class="col-md-6 mb-2 d-none" id="email_wrapper">
                        <label for="sub_jenis_email">Sub Jenis (Email)</label>
                        <select name="sub_jenis_email" id="sub_jenis_email" class="form-select border border-dark">
                            <option value="" selected>-- Pilih Sub Jenis --</option>
                            <option value="new">New</option>
                            <option value="change">Change</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>

                    {{-- Input manual kalau pilih Internet --}}
                    <div class="col-md-6 mb-2 d-none" id="internet_wrapper">
                        <label for="sub_jenis_internet">Group</label>
                        <input type="text" name="sub_jenis_internet" id="sub_jenis_internet" class="form-control border border-dark" placeholder="Group">
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const selectJenis = document.getElementById('jenis_permintaan');
                        const emailWrapper = document.getElementById('email_wrapper');
                        const internetWrapper = document.getElementById('internet_wrapper');
                        const emailSelect = document.getElementById('sub_jenis_email');
                        const internetInput = document.getElementById('sub_jenis_internet');

                        selectJenis.addEventListener('change', function () {
                            if (this.value === 'email') {
                                emailWrapper.classList.remove('d-none');
                                internetWrapper.classList.add('d-none');
                                internetInput.value = ''; // reset internet
                            } else if (this.value === 'internet') {
                                internetWrapper.classList.remove('d-none');
                                emailWrapper.classList.add('d-none');
                                emailSelect.value = ''; // reset email
                            } else {
                                emailWrapper.classList.add('d-none');
                                internetWrapper.classList.add('d-none');
                                emailSelect.value = '';
                                internetInput.value = '';
                            }
                        });
                    });
                    </script>
                </div>

                    
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="nama_depan">Nama Depan</label>
                        <input type="text" name="nama_depan" id="nama_depan" class="form-control border border-dark">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nama_tengah">Nama Tengah</label>
                        <input type="text" name="nama_tengah" id="nama_tengah" class="form-control border border-dark">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nama_belakang">Nama Belakang</label>
                        <input type="text" name="nama_belakang" id="nama_belakang" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" id="nik" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="alamat_email">Alamat Email</label>
                        <input type="email" name="alamat_email" id="alamat_email" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="divisi">Divisi</label>
                        <input type="text" name="divisi" id="divisi" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="departemen">Departemen</label>
                        <input type="text" name="departemen" id="departemen" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="note">Catatan</label>
                        <textarea name="note" id="note" class="form-control border border-dark" rows="3"></textarea>
                    </div>
                </div>

                {{-- By IT / HCD --}}
                <h5 class="mt-4 text-decoration-underline">By IT / HCD</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="mengetahui">Mengetahui</label>
                        <input type="text" name="mengetahui" id="mengetahui" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_diterima">Tanggal Diterima</label>
                        <input type="date" name="tanggal_diterima" id="tanggal_diterima" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="alamat_email_login">Alamat Email</label>
                        <input type="email" name="alamat_email_login" id="alamat_email_login" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control border border-dark" 
                            placeholder="Masukkan password" 
                            value="{{ old('password') }}"
                        >
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_efektif">Tanggal Efektif</label>
                        <input type="date" name="tanggal_efektif" id="tanggal_efektif" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dibuat_oleh">Dibuat Oleh</label>
                        <input type="text" name="dibuat_oleh" id="dibuat_oleh" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dibuat">Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" class="form-control border border-dark">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="catatan">Catatan</label>
                        <textarea name="catatan" id="catatan" class="form-control border border-dark" rows="3"></textarea>
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
                        <label for="memo">Catatan</label>
                        <textarea name="memo" id="memo" rows="3" class="form-control border border-dark" placeholder="Tambahkan catatan jika ada"></textarea>
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
