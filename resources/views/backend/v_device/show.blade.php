@extends('v_layouts.backend')

@section('content')
<div class="container">
    <h4>Detail Fixed Asset</h4>
    <table class="table table-bordered">
        <tr><th>Item Name</th><td>{{ $fixed->item_name }}</td></tr>
        <tr><th>Asset Type</th><td>{{ $fixed->asset_type }}</td></tr>
        <tr><th>Code</th><td>{{ $fixed->code }}</td></tr>
        <tr><th>Asset Number</th><td>{{ $fixed->asset_number }}</td></tr>
        <tr><th>Qty</th><td>{{ $fixed->qty }}</td></tr>
        <tr><th>Room</th><td>{{ $fixed->room }}</td></tr>
        <tr><th>Floor</th><td>{{ $fixed->floor }}</td></tr>
        <tr><th>Merk</th><td>{{ $fixed->merk }}</td></tr>
        <tr><th>Tanggal</th><td>{{ $fixed->tanggal_masuk }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($fixed->status) }}</td></tr>
        <tr>
            <th>Foto</th>
            <td>
                @if($fixed->foto)
                    <img src="{{ asset('storage/img-asset/' . $fixed->foto) }}" style="max-height:150px;">
                @else
                    <em>Tidak ada foto</em>
                @endif
            </td>
        </tr>
    </table>
    <a href="{{ route('fixed.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
