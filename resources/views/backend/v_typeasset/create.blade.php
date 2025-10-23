@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-11"> <!-- card lebih lebar -->
            <div class="card shadow-sm rounded-3">
                <form action="{{ route('backend.typeasset.store') }}" method="POST">
                    @csrf
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body p-4">
                        <!-- Judul -->
                        <h4 class="card-title mb-4">
                            <i class="fas fa-boxes me-2 text-primary"></i> {{ $judul }}
                        </h4>

                        <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label>Nama Type Asset</label>
                            <input type="text" name="nama_type" value="{{ old('nama_type') }}" class="form-control @error('nama_type') is-invalid @enderror" placeholder="Contoh: Infrastruktur IT, Furniture GA">
                            @error('nama_type')
                                <div class="invalid-feedback alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                        <label>Kode Prefix (wajib) <span class="text-muted">*</span></label>
                        <small class="form-text" style="color: #495057; margin-top: 2px; display: block;">
                            * IT = INFRANSTRUKTUR IT | GA = FURNITURE GA
                        </small>
                        <input type="text" 
                                name="type_prefix" 
                                value="{{ old('type_prefix', $edit->type_prefix ?? '') }}" 
                                class="form-control @error('type_prefix') is-invalid @enderror" 
                                placeholder="Contoh: IT01, GA01">
                        @error('type_prefix')
                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                        @enderror
                        </div>

                        <!-- Tombol Simpan & Kembali -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                            <a href="{{ route('backend.asset.index') }}" 
                            onclick="localStorage.setItem('activeAssetTab', '#type')" 
                            class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                    </div> <!-- /.card-body -->
                </form>
            </div> <!-- /.card -->
        </div> <!-- /.col -->
    </div> <!-- /.row -->
</div> <!-- /.container-fluid -->
@endsection
