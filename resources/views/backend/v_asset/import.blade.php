@extends('backend.v_layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <!-- Notice / Warning -->
        <div class="alert alert-danger fs-6 mb-4">
            <i class="fas fa-exclamation-circle"></i> 
            Import ini hanya berlaku untuk <strong>Asset Fisik</strong>. 
            Pastikan file Excel berisi data asset fisik sesuai format template yang diberikan.
        </div>

        <!-- Card Import -->
        <div class="card shadow-lg rounded-3 mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">📂 Import Data Asset</h4>
                <a href="{{ route('backend.asset.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">

                <!-- Info Template -->
                <div class="mb-4">
                    <a href="{{ asset('template.xlsx') }}" 
                       class="btn btn-info btn-sm fw-bold">
                        <i class="fas fa-download"></i> Download Template Excel
                    </a>
                    <small class="text-muted d-block mt-1">
                        ⚠️ Pastikan menggunakan template ini sebelum mengimpor file.
                    </small>
                </div>

                <!-- Error Handling -->
                @if ($errors->any())
                    <div class="alert alert-danger fs-6">
                        <i class="fas fa-times-circle"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Success / Warning / Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success fs-6">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning fs-6">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ session('warning') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger fs-6">
                        <i class="fas fa-times-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Form Import -->
                <form action="{{ route('backend.asset.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file" class="form-label fw-bold fs-5">Pilih File Asset</label>
                        <input type="file" name="file" id="file" 
                               class="form-control border border-dark fs-6 py-2" required>
                        <small class="text-muted">Hanya mendukung format: .xlsx, .csv</small>
                    </div>
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="mdi mdi-file-import"></i> Import
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
