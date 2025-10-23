@extends('backend.v_layouts.app') 
@section('content')
<!-- contentAwal -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.user.update', $edit->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="card-body">
                        <h4 class="card-title"> ✏️ {{$judul}} </h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>
                                    {{-- View Image --}}
                                    @if ($edit->foto)
                                        <img src="{{ asset('storage/img-user/' . $edit->foto) }}" class="foto-preview" width="100%">
                                        <p></p>
                                    @else
                                        <img src="{{ asset('storage/img-user/img-default.jpg') }}" class="foto-preview" width="100%">
                                        <p></p>
                                    @endif
                                    {{-- File Foto --}}
                                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" onchange="previewFoto()">
                                    @error('foto')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
 
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Hak Akses</label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                                        <option value="" {{ old('role', $edit->role) == '' ? 'selected' : '' }}>- Pilih Hak Akses -</option>

                                        @php
                                            $userRole = auth()->user()->role;
                                        @endphp

                                        @if($userRole == 0) {{-- Super Admin bisa semua --}}
                                            <option value="0" {{ old('role', $edit->role) == '0' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="1" {{ old('role', $edit->role) == '1' ? 'selected' : '' }}>Admin IT</option>
                                            <option value="2" {{ old('role', $edit->role) == '2' ? 'selected' : '' }}>Admin GA</option>
                                            <option value="3" {{ old('role', $edit->role) == '3' ? 'selected' : '' }}>Staff</option>
                                        @elseif(in_array($userRole, [1])) {{-- IT hanya bisa pilih IT --}}
                                            <option value="1" {{ old('role', $edit->role) == '1' ? 'selected' : '' }}>Admin IT</option>
                                        @elseif(in_array($userRole, [2])) {{-- GA hanya bisa pilih GA --}}
                                            <option value="2" {{ old('role', $edit->role) == '2' ? 'selected' : '' }}>Admin GA</option>
                                        @endif
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="nama" value="{{ old('nama', $edit->nama) }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama">
                                    @error('nama')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ old('email', $edit->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email">
                                    @error('email')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>HP</label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" name="hp" value="{{ old('hp', $edit->hp) }}" class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan Nomor HP">
                                    @error('hp')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Kolom Baru --}}
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" name="nik" value="{{ old('nik', $edit->nik) }}" class="form-control @error('nik') is-invalid @enderror" placeholder="Masukkan NIK">
                                    @error('nik')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Divisi</label>
                                    <input type="text" name="divisi" value="{{ old('divisi', $edit->divisi) }}" class="form-control @error('divisi') is-invalid @enderror" placeholder="Masukkan Divisi">
                                    @error('divisi')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Site</label>
                                    <input type="text" name="site" value="{{ old('site', $edit->site) }}" class="form-control @error('site') is-invalid @enderror" placeholder="Masukkan Site">
                                    @error('site')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Date of Receive</label>
                                    <input type="date" name="date_of_receive" value="{{ old('date_of_receive', $edit->date_of_receive) }}" class="form-control @error('date_of_receive') is-invalid @enderror">
                                    @error('date_of_receive')
                                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Kosongkan jika tidak ingin mengganti password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-target="password" style="cursor:pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback alert-danger d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Ulangi password baru">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-target="password_confirmation" style="cursor:pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback alert-danger d-block" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <script>
                                document.querySelectorAll('.toggle-password').forEach(item => {
                                    item.addEventListener('click', function () {
                                        const targetId = this.getAttribute('data-target');
                                        const input = document.getElementById(targetId);
                                        const icon = this.querySelector('i');

                                        if (input.type === 'password') {
                                            input.type = 'text';
                                            icon.classList.replace('fa-eye', 'fa-eye-slash');
                                        } else {
                                            input.type = 'password';
                                            icon.classList.replace('fa-eye-slash', 'fa-eye');
                                        }
                                    });
                                });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Perbaharui</button>
                            <a href="{{ route('backend.user.index') }}">
                                <button type="button" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- contentAkhir -->
@endsection
