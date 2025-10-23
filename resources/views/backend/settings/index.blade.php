@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Pengaturan</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('backend.asset-history.applyRetention') }}">
            @csrf
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="globalRetention" class="col-form-label fw-bold d-flex align-items-center">
                        <i class="mdi mdi-history text-primary" style="font-size:20px; margin-right:10px;"></i>
                        Hapus otomatis history lebih dari:
                    </label>
                </div>
                <div class="col-auto">
                    <select name="retention" id="globalRetention" class="form-select form-select-sm">
                        <option value="3" {{ $retention && $retention->value == 3 ? 'selected' : '' }}>3 hari</option>
                        <option value="7" {{ $retention && $retention->value == 7 ? 'selected' : '' }}>1 minggu</option>
                        <option value="30" {{ $retention && $retention->value == 30 ? 'selected' : '' }}>1 bulan</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
