@extends('backend.v_layouts.app')

@section('content')
    <h1>Aset dengan Kategori: {{ $kategori->nama_kategori }}</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Aset</th>
                <th>Serial Number</th>
                <!-- kolom lainnya -->
            </tr>
        </thead>
        <tbody>
        @foreach ($asset as $asset)
            <tr>
                <td>{{ $asset->nama }}</td>
                <td>{{ $asset->asset_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
