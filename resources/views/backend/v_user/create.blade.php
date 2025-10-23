@extends('backend.v_layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('backend.user.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row">
        {{-- FOTO --}}
        <div class="col-md-4">
          <div class="form-group">
            <label>Foto</label>
            <img class="foto-preview">
            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
              onchange="previewFoto()">
            @error('foto')
              <div class="invalid-feedback alert-danger">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- FORM DATA --}}
        <div class="col-md-8">
          {{-- ROLE --}}
          <div class="form-group">
              <label>Hak Akses</label>
              <select name="role" class="form-control @error('role') is-invalid @enderror">
                  <option value="" {{ old('role') == '' ? 'selected' : '' }}>- Pilih Hak Akses -</option>

                  @php
                      $userRole = auth()->user()->role;
                  @endphp

                  @if($userRole == 0) {{-- Super Admin bisa semua --}}
                      <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Super Admin</option>
                      <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin IT</option>
                      <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Admin GA</option>
                      <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>Staff</option>
                  @elseif(in_array($userRole, [1])) {{-- IT hanya bisa buat Admin/Staff IT --}}
                      <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin IT</option>
                  @elseif(in_array($userRole, [2])) {{-- GA hanya bisa buat Admin/Staff GA --}}
                      <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Admin GA</option>
                  @endif
              </select>
              @error('role')
                  <span class="invalid-feedback alert-danger">{{ $message }}</span>
              @enderror
          </div>

          {{-- NIK --}}
          <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" value="{{ old('nik') }}" 
              onkeypress="return hanyaAngka(event)"
              class="form-control @error('nik') is-invalid @enderror" placeholder="Masukkan NIK">
            @error('nik')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- NAMA --}}
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}"
              class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama">
            @error('nama')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- EMAIL --}}
          <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email">
            @error('email')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- HP --}}
          <div class="form-group">
            <label>HP</label>
            <input type="text" name="hp" value="{{ old('hp') }}"
              onkeypress="return hanyaAngka(event)"
              class="form-control @error('hp') is-invalid @enderror" placeholder="Masukkan HP">
            @error('hp')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- DIVISI --}}
          <div class="form-group">
            <label>Divisi</label>
            <input type="text" name="divisi" value="{{ old('divisi') }}"
              class="form-control @error('divisi') is-invalid @enderror" placeholder="Masukkan Divisi">
            @error('divisi')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- SITE --}}
          <div class="form-group">
            <label>Site</label>
            <input type="text" name="site" value="{{ old('site') }}"
              class="form-control @error('site') is-invalid @enderror" placeholder="Masukkan Site">
            @error('site')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- DATE OF RECEIVE --}}
          <div class="form-group">
            <label>Date of Receive</label>
            <input type="date" name="date_of_receive" value="{{ old('date_of_receive') }}"
              class="form-control @error('date_of_receive') is-invalid @enderror">
            @error('date_of_receive')
              <span class="invalid-feedback alert-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- PASSWORD --}}
          <div class="form-group">
              <label>Password</label>
              <div class="input-group">
                  <input type="password" name="password"
                      class="form-control toggle-password @error('password') is-invalid @enderror"
                      placeholder="Masukkan Password">
                  <div class="input-group-append">
                      <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                      </span>
                  </div>
              </div>
              @error('password')
                  <span class="invalid-feedback alert-danger">{{ $message }}</span>
              @enderror
          </div>

          {{-- KONFIRMASI PASSWORD --}}
          <div class="form-group">
              <label>Konfirmasi Password</label>
              <div class="input-group">
                  <input type="password" name="password_confirmation"
                      class="form-control toggle-password @error('password_confirmation') is-invalid @enderror"
                      placeholder="Konfirmasi Password">
                  <div class="input-group-append">
                      <span class="input-group-text toggle-password-icon" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                      </span>
                  </div>
              </div>
              @error('password_confirmation')
                  <span class="invalid-feedback alert-danger">{{ $message }}</span>
              @enderror
          </div>

          <script>
          document.querySelectorAll('.toggle-password-icon').forEach(icon => {
              icon.addEventListener('click', function() {
                  const input = this.closest('.input-group').querySelector('.toggle-password');
                  const eye = this.querySelector('i');
                  if (input.type === 'password') {
                      input.type = 'text';
                      eye.classList.replace('fa-eye', 'fa-eye-slash');
                  } else {
                      input.type = 'password';
                      eye.classList.replace('fa-eye-slash', 'fa-eye');
                  }
              });
          });
          </script>

      {{-- BUTTON --}}
      <div class="row mt-3">
        <div class="col-md-12 text-center">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="{{ route('backend.user.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection
