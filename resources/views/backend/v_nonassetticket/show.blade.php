@extends('backend.v_layouts.app')

@section('content')
<div class="container mt-3">
    <h4 class="d-flex align-items-center">🔍 Detail Ticket #{{ $nonAssetTicket->ticket_number }}</h4>
    <hr>
    {{-- Informasi Pelapor --}}
    <div class="card mb-3">
        <div class="card-header">Informasi Pelapor</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Nama Pelapor</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->reporter_name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Departemen</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->department }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Kontak (Telp/WA)</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->contact }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ $nonAssetTicket->email }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Item Name</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->asset_name }}" readonly>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Masalah --}}
    <div class="card mb-3">
        <div class="card-header">Detail Masalah</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Kategori</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->category }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Subjek Masalah</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->subject }}" readonly>
                </div>

                {{-- Deskripsi & Lampiran di satu baris --}}
                <div class="col-md-6">
                    <label>Deskripsi</label>
                    <textarea class="form-control" style="height:100px" readonly>{{ $nonAssetTicket->description }}</textarea>
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div>
                        <label>Lampiran</label><br>
                        @if($nonAssetTicket->attachment)
                            <a href="{{ asset('storage/'.$nonAssetTicket->attachment) }}" target="_blank" class="btn btn-sm btn-outline-info">Lihat Lampiran</a>
                        @else
                            <p class="text-muted mt-2">Tidak ada lampiran</p>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Item Asset</label>
                    <input type="text" class="form-control" 
                        value="{{ optional($nonAssetTicket->asset)->item_name ?? '-' }}{{ optional($nonAssetTicket->asset)->room ? ' (' . $nonAssetTicket->asset->room . ')' : '' }}" 
                        readonly>
                </div>
                <div class="col-md-6">
                    <label>Kategori Asset</label>
                    <input type="text" class="form-control" value="{{ optional($nonAssetTicket->asset->kategori)->nama_kategori ?? '-' }}" readonly>
                </div>
            </div>
        </div>
    </div>

    {{-- Prioritas, Lokasi & Status --}}
    <div class="card mb-3">
        <div class="card-header">Prioritas, Lokasi & Status</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label>Prioritas</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->priority }}" readonly>
                </div>
                <div class="col-md-3">
                    <label>Jumlah User Terdampak</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->affected_users }}" readonly>
                </div>
                <div class="col-md-3">
                    <label>Lokasi</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->location }}" readonly>
                </div>
                <div class="col-md-3">
                    <label>Status Ticket</label>
                    <input type="text" class="form-control" value="{{ $nonAssetTicket->status }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('backend.nonassetticket.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
