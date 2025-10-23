@extends('v_layouts.backend')

@section('content')
<div class="container">
    <h1>Detail Consumable Goods</h1>
    <table class="table table-bordered">
        <tr>
            <th>Type Asset</th>
            <td>{{ $consumable->typeAsset->nama_type ?? '-' }}</td>
        </tr>

        <tr>
            <th>Item Name</th>
            <td>{{ $consumable->item_name }}</td>
        </tr>
        <tr>
            <th>Qty</th>
            <td>{{ $consumable->qty }}</td>
        </tr>
        <tr>
            <th>Merk</th>
            <td>{{ $consumable->merk }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $consumable->tanggal_masuk }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($consumable->status) }}</td>
        </tr>
        <tr>
            <th>Foto</th>
            <td>
                @if($consumable->foto)
                    <img src="{{ asset('storage/' . $consumable->foto) }}" alt="Foto Asset" width="150">
                @else
                    -
                @endif
            </td>
        </tr>
    </table>
</div>
@endsection
