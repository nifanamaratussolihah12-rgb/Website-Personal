@extends('backend.layouts.app')

@section('content')
    <h1>Aset dengan Tipe: {{ $type->nama_type }}</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Aset</th>
                <th>Prefix</th>
                <th>Serial Number</th>
                <!-- kolom lainnya -->
            </tr>
        </thead>
        <tbody>
        @foreach ($asset as $asset)
            <tr>
                <td>{{ $asset->nama }}</td>
                <td>{{ $asset->type_prefix }}</td>
                <td>{{ $asset->serial_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
