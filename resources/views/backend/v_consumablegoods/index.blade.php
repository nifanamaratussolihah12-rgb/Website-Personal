@extends('v_layouts.backend')

@section('content')
<div class="container">
    <h1>Data Consumable Goods</h1>
    <a href="{{ route('consumable.create') }}" class="btn btn-primary mb-3">Tambah Consumable</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Type Asset</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Room</th>
                <th>Floor</th>
                <th>Merk</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consumables as $key => $consumable)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $consumable->typeAsset->nama_type ?? '-' }}</td>
                <td>{{ $consumable->item_name }}</td>
                <td>{{ $consumable->qty }}</td>
                <td>{{ $consumable->room }}</td>
                <td>{{ $consumable->floor }}</td>
                <td>{{ $consumable->merk }}</td>
                <td>{{ $consumable->tanggal_masuk }}</td>
                <td>{{ ucfirst($consumable->status) }}</td>
                <td>
                    <a href="{{ route('consumable.show', $consumable->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('consumable.edit', $consumable->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('consumable.destroy', $consumable->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin hapus data ini?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
