@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card shadow rounded-3">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">✏️ Edit Formulir Permintaan Login Email / Internet</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.loginrequest.update', $loginRequest->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informasi Umum --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="tanggal">{!! fieldLabel('Tanggal', $loginRequest->tanggal) !!}</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control border border-dark"
                               value="{{ old('tanggal', $loginRequest->tanggal?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="cabang">{!! fieldLabel('Cabang', $loginRequest->cabang) !!}</label>
                        <input type="text" name="cabang" id="cabang" class="form-control border border-dark"
                               value="{{ old('cabang', $loginRequest->cabang) }}">
                    </div>

                    {{-- Company --}}
                    <div class="col-md-6 mb-2">
                        <label for="is_abm_group">{!! fieldLabel('Company', $loginRequest->company_name) !!}</label>
                        <select name="is_abm_group" id="is_abm_group" class="form-select border border-dark">
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ old('is_abm_group', $loginRequest->is_abm_group) == '1' ? 'selected' : '' }}>ABM Group</option>
                            <option value="0" {{ old('is_abm_group', $loginRequest->is_abm_group) == '0' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    {{-- input untuk ABM Group --}}
                    <div class="col-md-6 mb-2 {{ old('is_abm_group', $loginRequest->is_abm_group) == '1' ? '' : 'd-none' }}" id="abm_wrapper">
                        <label for="company_abm">Nama Perusahaan (ABM Group)</label>
                        <input type="text" name="company_abm" id="company_abm" class="form-control border border-dark"
                               value="{{ old('company_abm', str_replace(['PT ', ' / ABM Group'], '', $loginRequest->company_name)) }}">
                    </div>

                    {{-- input untuk Other --}}
                    <div class="col-md-6 mb-2 {{ old('is_abm_group', $loginRequest->is_abm_group) == '0' ? '' : 'd-none' }}" id="other_wrapper">
                        <label for="company_other">Nama Perusahaan (Other)</label>
                        <input type="text" name="company_other" id="company_other" class="form-control border border-dark"
                               value="{{ old('company_other', $loginRequest->company_name) }}">
                    </div>
                </div>

                {{-- Jenis Permintaan --}}
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="jenis_permintaan">{!! fieldLabel('Jenis Permintaan', $loginRequest->jenis_permintaan) !!}</label>
                        <select name="jenis_permintaan" id="jenis_permintaan" class="form-select border border-dark">
                            <option value="">-- Pilih --</option>
                            <option value="email" {{ old('jenis_permintaan', $loginRequest->jenis_permintaan) == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="internet" {{ old('jenis_permintaan', $loginRequest->jenis_permintaan) == 'internet' ? 'selected' : '' }}>Internet</option>
                        </select>
                    </div>

                    {{-- Sub jenis kalau pilih Email --}}
                    <div class="col-md-6 mb-2 {{ old('jenis_permintaan', $loginRequest->jenis_permintaan) == 'email' ? '' : 'd-none' }}" id="email_wrapper">
                        <label for="sub_jenis_email">Sub Jenis (Email)</label>
                        <select name="sub_jenis_email" id="sub_jenis_email" class="form-select border border-dark">
                            <option value="">-- Pilih Sub Jenis --</option>
                            <option value="new" {{ old('sub_jenis_email', $loginRequest->sub_jenis) == 'new' ? 'selected' : '' }}>New</option>
                            <option value="change" {{ old('sub_jenis_email', $loginRequest->sub_jenis) == 'change' ? 'selected' : '' }}>Change</option>
                            <option value="delete" {{ old('sub_jenis_email', $loginRequest->sub_jenis) == 'delete' ? 'selected' : '' }}>Delete</option>
                        </select>
                    </div>

                    {{-- Input manual kalau pilih Internet --}}
                    <div class="col-md-6 mb-2 {{ old('jenis_permintaan', $loginRequest->jenis_permintaan) == 'internet' ? '' : 'd-none' }}" id="internet_wrapper">
                        <label for="sub_jenis_internet">Group</label>
                        <input type="text" name="sub_jenis_internet" id="sub_jenis_internet" class="form-control border border-dark"
                               value="{{ old('sub_jenis_internet', $loginRequest->sub_jenis) }}">
                    </div>
                </div>

                {{-- Data User --}}
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="nama_depan">{!! fieldLabel('Nama Depan', $loginRequest->nama_depan) !!}</label>
                        <input type="text" name="nama_depan" id="nama_depan" class="form-control border border-dark"
                               value="{{ old('nama_depan', $loginRequest->nama_depan) }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nama_tengah">{!! fieldLabel('Nama Tengah', $loginRequest->nama_tengah) !!}</label>
                        <input type="text" name="nama_tengah" id="nama_tengah" class="form-control border border-dark"
                               value="{{ old('nama_tengah', $loginRequest->nama_tengah) }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="nama_belakang">{!! fieldLabel('Nama Belakang', $loginRequest->nama_belakang) !!}</label>
                        <input type="text" name="nama_belakang" id="nama_belakang" class="form-control border border-dark"
                               value="{{ old('nama_belakang', $loginRequest->nama_belakang) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="nik">{!! fieldLabel('NIK', $loginRequest->nik) !!}</label>
                        <input type="text" name="nik" id="nik" class="form-control border border-dark"
                               value="{{ old('nik', $loginRequest->nik) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="alamat_email">{!! fieldLabel('Alamat Email', $loginRequest->alamat_email) !!}</label>
                        <input type="email" name="alamat_email" id="alamat_email" class="form-control border border-dark"
                               value="{{ old('alamat_email', $loginRequest->alamat_email) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="divisi">{!! fieldLabel('Divisi', $loginRequest->divisi) !!}</label>
                        <input type="text" name="divisi" id="divisi" class="form-control border border-dark"
                               value="{{ old('divisi', $loginRequest->divisi) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="departemen">{!! fieldLabel('Departemen', $loginRequest->departemen) !!}</label>
                        <input type="text" name="departemen" id="departemen" class="form-control border border-dark"
                               value="{{ old('departemen', $loginRequest->departemen) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="note">{!! fieldLabel('Catatan', $loginRequest->note) !!}</label>
                        <textarea name="note" id="note" class="form-control border border-dark" rows="3">{{ old('note', $loginRequest->note) }}</textarea>
                    </div>
                </div>

                {{-- By IT / HCD --}}
                <h5 class="mt-4 text-decoration-underline">By IT / HCD</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="mengetahui">{!! fieldLabel('Mengetahui', $loginRequest->mengetahui) !!}</label>
                        <input type="text" name="mengetahui" id="mengetahui" class="form-control border border-dark"
                               value="{{ old('mengetahui', $loginRequest->mengetahui) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_diterima">{!! fieldLabel('Tanggal Diterima', $loginRequest->tanggal_diterima) !!}</label>
                        <input type="date" name="tanggal_diterima" id="tanggal_diterima" class="form-control border border-dark"
                               value="{{ old('tanggal_diterima', $loginRequest->tanggal_diterima?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="alamat_email_login">{!! fieldLabel('Alamat Email Login', $loginRequest->alamat_email_login) !!}</label>
                        <input type="email" name="alamat_email_login" id="alamat_email_login" class="form-control border border-dark"
                               value="{{ old('alamat_email_login', $loginRequest->alamat_email_login) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control border border-dark" 
                                placeholder="Masukkan password" 
                                value="{{ old('password', $loginRequest->password_plain ?? '') }}"
                                autocomplete="new-password"
                            >
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" title="Tampilkan / Sembunyikan">
                                👁
                            </button>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tambah script show/hide (letakkan di bawah page atau di section scripts) -->
                    <script>
                    document.getElementById('togglePassword')?.addEventListener('click', function() {
                        const input = document.getElementById('password');
                        if (!input) return;
                        if (input.type === 'password') {
                            input.type = 'text';
                            this.innerText = '🙈';
                        } else {
                            input.type = 'password';
                            this.innerText = '👁';
                        }
                    });
                    </script>

                    <div class="col-md-6 mb-2">
                        <label for="tanggal_efektif">{!! fieldLabel('Tanggal Efektif', $loginRequest->tanggal_efektif) !!}</label>
                        <input type="date" name="tanggal_efektif" id="tanggal_efektif" class="form-control border border-dark"
                               value="{{ old('tanggal_efektif', $loginRequest->tanggal_efektif?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="dibuat_oleh">{!! fieldLabel('Dibuat Oleh', $loginRequest->dibuat_oleh) !!}</label>
                        <input type="text" name="dibuat_oleh" id="dibuat_oleh" class="form-control border border-dark"
                               value="{{ old('dibuat_oleh', $loginRequest->dibuat_oleh) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="tanggal_dibuat">{!! fieldLabel('Tanggal Dibuat', $loginRequest->tanggal_dibuat) !!}</label>
                        <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" class="form-control border border-dark"
                               value="{{ old('tanggal_dibuat', $loginRequest->tanggal_dibuat?->format('Y-m-d')) }}">
                    </div>
                     <div class="col-md-6 mb-2">
                        <label for="catatan">{!! fieldLabel('Catatan', $loginRequest->catatan) !!}</label>
                        <textarea name="catatan" id="catatan" class="form-control border border-dark" rows="3">{{ old('catatan', $loginRequest->catatan) }}</textarea>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="tanggal_dokumen" class="form-label">{!! fieldLabel('Tanggal Dokumen Diterbitkan', $loginRequest->tanggal_dokumen) !!}</label>
                    <input type="date" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control border border-dark" 
                        value="{{ old('tanggal_dokumen', $loginRequest->tanggal_dokumen?->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="tanggal_expired" class="form-label">{!! fieldLabel('Tanggal Dokumen Expired', $loginRequest->tanggal_expired) !!}</label>
                    <input type="date" name="tanggal_expired" id="tanggal_expired" class="form-control border border-dark" 
                        value="{{ old('tanggal_expired', $loginRequest->tanggal_expired?->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-2">
                        <label for="status" class="form-label">{!! fieldLabel('Status', $loginRequest->status) !!}</label>
                        <select name="status" id="status" class="form-select border border-dark">
                            <option value="">-- Pilih Item --</option>
                            <option value="pending approval" {{ old('status', $loginRequest->status) == 'pending approval' ? 'selected' : '' }}>Pending Approval</option>
                            <option value="approval" {{ old('status', $loginRequest->status) == 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="done" {{ old('status', $loginRequest->status) == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="memo" class="form-label">{!! fieldLabel('Catatan', $loginRequest->memo) !!}</label>
                        <textarea name="memo" id="memo" rows="3" class="form-control border border-dark"
                            placeholder="Tambahkan catatan jika ada">{{ old('catatan', $loginRequest->memo) }}</textarea>
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
    <a href="{{ route('backend.loginrequest.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
