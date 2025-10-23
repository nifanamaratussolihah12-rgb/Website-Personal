@extends('backend.v_layouts.app')

@section('title', 'Additional Goods')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Daftar Additional Goods</h4>
        <a href="{{ route('additional.create') }}" class="btn btn-primary btn-sm">+ Tambah Additional Goods</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Asset Type</th>
                    <th>Code</th>
                    <th>Asset Number</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Room</th>
                    <th>Floor</th>
                    <th>Merk</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th style="width: 170px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($additional as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $item->asset_type ?? '-' }}</td>
                        <td>{{ $item->code ?? '-' }}</td>
                        <td>{{ $item->asset_number ?? '-' }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->room ?? '-' }}</td>
                        <td>{{ $item->floor ?? '-' }}</td>
                        <td>{{ $item->merk ?? '-' }}</td>
                        <td>
                            {{ $item->tanggal_masuk ? \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') : '-' }}
                        </td>
                        <td>{{ $item->catatan ?? '-' }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
                            <a href="{{ route('additional.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('additional.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('additional.destroy', $item->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">Belum ada data Additional Goods</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
