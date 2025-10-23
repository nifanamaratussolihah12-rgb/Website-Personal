@extends('backend.v_layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

            {{-- RIGHT COLUMN: Detail Maintenance --}}
            <div class="col-md-12">
                {{-- Item Asset --}}
                <div class="form-group mb-2">
                    <label>Item Asset</label>
                    <input type="text" class="form-control" readonly
                        value="{{ $maintenance->asset->item_name ?? '-' }}">
                </div>

                {{-- Tanggal Isu --}}
                <div class="form-group mb-2">
                    <label>Tanggal Isu</label>
                    <input type="text" class="form-control" readonly
                        value="{{ $maintenance->issue_date ? \Carbon\Carbon::parse($maintenance->issue_date)->translatedFormat('d F Y') : '-' }}">
                </div>

                {{-- Jenis Maintenance --}}
                <div class="form-group mb-2">
                    <label>Jenis Maintenance</label>
                    <input type="text" class="form-control" readonly
                        value="{{ ucfirst($maintenance->maintenance_type ?? '-') }}">
                </div>

               {{-- Penjadwalan --}}
                <div class="form-group mb-2">
                    <label>Penjadwalan</label>
                    <input type="text" class="form-control" readonly
                        value="{{ $maintenance->schedule_date ? \Carbon\Carbon::parse($maintenance->schedule_date)->translatedFormat('d F Y') : '-' }}">
                </div>

                {{-- Biaya --}}
                <div class="form-group mb-2">
                    <label>Biaya</label>
                    <input type="text" class="form-control" readonly
                        value="{{ $maintenance->cost ? number_format($maintenance->cost,0,',','.') : '-' }}">
                </div>

                {{-- Priority --}}
                <div class="form-group mb-2">
                    <label>Priority</label>
                    <input type="text" class="form-control" readonly
                        value="{{ ucfirst($maintenance->priority ?? '-') }}">
                </div>

                {{-- Status --}}
                <div class="form-group mb-2">
                    <label>Status</label>
                    <input type="text" class="form-control" readonly
                        value="{{ ucfirst($maintenance->status ?? '-') }}">
                </div>

                {{-- Ditangani Oleh --}}
                <div class="form-group mb-2">
                    <label>Ditangani Oleh</label>
                    <input type="text" class="form-control" readonly
                        value="{{ $maintenance->handledBy->nama ?? '-' }}">
                </div>

                {{-- Terakhir Maintenance --}}
                <div class="form-group mb-2">
                    <label>Terakhir Maintenance</label>
                    <input type="text" class="form-control" readonly
                        value="{{ $maintenance->status === 'done'
                                    ? ($maintenance->schedule_date 
                                        ? \Carbon\Carbon::parse($maintenance->schedule_date)->translatedFormat('d F Y') 
                                        : '-')
                                    : '-' }}">
                </div>
                
                {{-- Catatan --}}
                <div class="form-group mb-2">
                    <label>Catatan</label>
                    <textarea class="form-control" rows="3" readonly>{{ $maintenance->notes ?? '-' }}</textarea>
                </div>

                {{-- Button --}}
                <div class="text-end mt-3">
                    <a href="{{ route('backend.asset-maintenance.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
