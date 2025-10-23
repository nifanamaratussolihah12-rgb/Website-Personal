@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">📄 Detail Formulir Permintaan Login Email / Internet</h4>
        </div>
        <div class="card-body">

            {{-- Informasi Umum --}}
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Tanggal</label>
                    <p class="form-control border border-dark">{{ $loginRequest->tanggal?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Cabang</label>
                    <p class="form-control border border-dark">{{ $loginRequest->cabang ?? '-' }}</p>
                </div>

                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Company</label>
                    <p class="form-control border border-dark">
                        {{ $loginRequest->is_abm_group ? 'ABM Group' : 'Other' }}
                    </p>
                </div>

                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Nama Perusahaan</label>
                    <p class="form-control border border-dark">{{ $loginRequest->company_name ?? '-' }}</p>
                </div>
            </div>

            {{-- Jenis Permintaan --}}
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Jenis Permintaan</label>
                    <p class="form-control border border-dark">{{ ucfirst($loginRequest->jenis_permintaan) ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Sub Jenis</label>
                    <p class="form-control border border-dark">{{ $loginRequest->sub_jenis ?? '-' }}</p>
                </div>
            </div>

            {{-- Data User --}}
            <h5 class="mt-3 text-decoration-underline">Data User</h5>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="fw-bold">Nama Depan</label>
                    <p class="form-control border border-dark">{{ $loginRequest->nama_depan ?? '-' }}</p>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="fw-bold">Nama Tengah</label>
                    <p class="form-control border border-dark">{{ $loginRequest->nama_tengah ?? '-' }}</p>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="fw-bold">Nama Belakang</label>
                    <p class="form-control border border-dark">{{ $loginRequest->nama_belakang ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">NIK</label>
                    <p class="form-control border border-dark">{{ $loginRequest->nik ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Alamat Email</label>
                    <p class="form-control border border-dark">{{ $loginRequest->alamat_email ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Divisi</label>
                    <p class="form-control border border-dark">{{ $loginRequest->divisi ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Departemen</label>
                    <p class="form-control border border-dark">{{ $loginRequest->departemen ?? '-' }}</p>
                </div>
                <div class="col-md-12 mb-2">
                    <label class="fw-bold">Catatan</label>
                    <p class="form-control border border-dark">{{ $loginRequest->note ?? '-' }}</p>
                </div>
            </div>

            {{-- By IT / HCD --}}
            <h5 class="mt-4 text-decoration-underline">By IT / HCD</h5>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Mengetahui</label>
                    <p class="form-control border border-dark">{{ $loginRequest->mengetahui ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Tanggal Diterima</label>
                    <p class="form-control border border-dark">{{ $loginRequest->tanggal_diterima?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Alamat Email Login</label>
                    <p class="form-control border border-dark">{{ $loginRequest->alamat_email_login ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Password</label>
                    <div class="input-group">
                        <input 
                            type="password" 
                            id="password_show" 
                            class="form-control border border-dark bg-light" 
                            value="{{ $loginRequest->password_plain ?? '********' }}" 
                            readonly
                        >
                        <button type="button" class="btn btn-outline-secondary" id="togglePasswordShow" title="Tampilkan / Sembunyikan">
                            👁
                        </button>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Tanggal Efektif</label>
                    <p class="form-control border border-dark">{{ $loginRequest->tanggal_efektif?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Dibuat Oleh</label>
                    <p class="form-control border border-dark">{{ $loginRequest->dibuat_oleh ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Tanggal Dibuat</label>
                    <p class="form-control border border-dark">{{ $loginRequest->tanggal_dibuat?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Catatan Tambahan</label>
                    <p class="form-control border border-dark">{{ $loginRequest->catatan ?? '-' }}</p>
                </div>
            </div>

            {{-- Dokumen --}}
            <h5 class="mt-4 text-decoration-underline">Informasi Dokumen</h5>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Tanggal Dokumen Diterbitkan</label>
                    <p class="form-control border border-dark">{{ $loginRequest->tanggal_dokumen?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Tanggal Dokumen Expired</label>
                    <p class="form-control border border-dark">{{ $loginRequest->tanggal_expired?->format('d-m-Y') ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Status</label>
                    <p class="form-control border border-dark text-capitalize">{{ $loginRequest->status ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="fw-bold">Memo / Catatan</label>
                    <p class="form-control border border-dark">{{ $loginRequest->memo ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="text-center mt-3">
    <a href="{{ route('backend.loginrequest.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('togglePasswordShow');
    const input = document.getElementById('password_show');
    
    if (toggleBtn && input) {
        toggleBtn.addEventListener('click', function () {
            if (input.type === 'password') {
                input.type = 'text';
                this.innerText = '🙈';
            } else {
                input.type = 'password';
                this.innerText = '👁';
            }
        });
    }
});
</script>
@endpush

@endsection
