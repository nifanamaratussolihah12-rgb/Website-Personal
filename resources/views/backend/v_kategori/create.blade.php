@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-11">
            <div class="card shadow-sm rounded-3">
                <form action="{{ route('backend.kategori.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">

                        <!-- Judul -->
                        <h4 class="card-title mb-4">
                            <i class="fas fa-tags me-2 text-primary"></i> Tambah Kategori Aset
                        </h4>

                        <!-- Input Nama Kategori -->
                        <div class="mb-4">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   placeholder="Contoh: Fixed Asset - Electronics IT">
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Prefix -->
                        <div class="form-group mb-4">
                            <label>Kode Prefix (wajib) <span class="text-muted">*</span></label>
                            <small class="form-text text-muted d-block mb-1">
                                * F = Fixed Asset (5 tahun) | S = Small Asset (1-3 tahun)
                            </small>
                            <input type="text" 
                                   name="kategori_prefix" 
                                   value="{{ old('kategori_prefix', $edit->kategori_prefix ?? '') }}" 
                                   class="form-control @error('kategori_prefix') is-invalid @enderror" 
                                   placeholder="Contoh: F01, S01">
                            @error('kategori_prefix')
                                <div class="invalid-feedback alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dropdown Jenis Aset -->
                        <div class="form-group mb-4">
                            <label for="asset_kind">Jenis Aset</label>
                            <select name="asset_kind" id="asset_kind" 
                                    class="form-control @error('asset_kind') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Aset --</option>
                                <option value="physical" {{ old('asset_kind') == 'physical' ? 'selected' : '' }}>
                                    Aset Fisik
                                </option>
                                <option value="service" {{ old('asset_kind') == 'service' ? 'selected' : '' }}>
                                    Layanan / Non-Fisik
                                </option>
                            </select>
                            @error('asset_kind')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan & Kembali -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                            <a href="{{ route('backend.asset.index') }}" 
                            onclick="localStorage.setItem('activeAssetTab', '#kategori')" 
                            class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
