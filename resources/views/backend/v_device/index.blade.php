@extends('backend.v_layouts.app')

@section('content')
    <h1>Data Fixed Asset</h1>

    <a href="{{ route('fixed.create') }}" style="display: inline-block; margin-bottom: 15px;">+ Tambah Fixed Asset</a>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Type Asset</th>
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
                <th>Foto</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fixed as $fixed)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    {{-- Tampilkan nama kategori dari relasi kategori --}}
                    <td>{{ $fixed->kategori->nama_kategori ?? '-' }}</td>

                    <td>{{ $fixed->asset_type }}</td>
                    <td>{{ $fixed->code }}</td>
                    <td>{{ $fixed->asset_number }}</td>
                    <td>{{ $fixed->item_name }}</td>
                    <td>{{ $fixed->qty }}</td>
                    <td>{{ $fixed->room }}</td>
                    <td>{{ $fixed->floor }}</td>
                    <td>{{ $fixed->merk }}</td>
                    <td>{{ $fixed->tanggal_masuk }}</td>
                    <td>{{ $fixed->catatan ?? '-' }}</td>
                    <td>{{ ucfirst($fixed->status) }}</td>
                    <td>
                        @if ($fixed->foto)
                            <img src="{{ asset('storage/img-asset/' . $fixed->foto) }}" alt="Foto" width="80">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('fixed.edit', $fixed->id) }}">Edit</a> |
                        <form action="{{ route('fixed.destroy', $fixed->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($fixed->isEmpty())
                <tr>
                    <td colspan="14" style="text-align:center;">Data Fixed Asset belum tersedia</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
