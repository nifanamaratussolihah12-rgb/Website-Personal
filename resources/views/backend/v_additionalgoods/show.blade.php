@extends('backend.v_layouts.app')

@section('title', 'Detail Additional Goods')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Additional Goods</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Kategori</th>
                <td>{{ $additional->kategori->nama_kategori ?? '-' }}</td>
            </tr>
            <tr>
                <th>Asset Type</th>
                <td>{{ $additional->asset_type ?? '-' }}</td>
            </tr>
            <tr>
                <th>Code</th>
                <td>{{ $additional->code ?? '-' }}</td>
            </tr>
            <tr>
                <th>Asset Number</th>
                <td>{{ $additional->asset_number ?? '-' }}</td>
            </tr>
            <tr>
                <th>Item Name</th>
                <td>{{ $additional->item_name }}</td>
            </tr>
            <tr>
                <th>Qty</th>
                <td>{{ $additional->qty }}</td>
            </tr>
            <tr>
                <th>Room</th>
                <td>{{ $additional->room ?? '-' }}</td>
            </tr>
            <tr>
                <th>Floor</th>
                <td>{{ $additional->floor ?? '-' }}</td>
            </tr>
            <tr>
                <th>Merk</th>
                <td>{{ $additional->merk ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td>
                    {{ $additional->tanggal_masuk ? \Carbon\Carbon::parse($additional->tanggal_masuk)->translatedFormat('d F Y') : '-' }}
                </td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td>{{ $additional->catatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($additional->status) }}</td>
            </tr>
            <tr>
                <th>Foto</th>
                <td>
                    @if($additional->foto)
                        <img src="{{ asset('storage/'.$additional->foto) }}" alt="foto" width="150">
                    @else
                        Tidak ada foto
                    @endif
                </td>
            </tr>
        </table>
        <a href="{{ route('additional.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
