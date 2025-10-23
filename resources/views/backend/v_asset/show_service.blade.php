@extends('backend.v_layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">🔍 {{ $judul ?? 'Detail Service Item' }}</h4>
                    <hr>

                    <style>
                        /* Alternating row colors: odd = biru muda, even = putih */
                        .table-detail th {
                            font-weight: 600;
                            width: 35%;
                            vertical-align: middle;
                        }
                        .table-detail tr:nth-child(odd) th,
                        .table-detail tr:nth-child(odd) td {
                            background-color: #e3f2fd; /* biru muda */
                        }
                        .table-detail tr:nth-child(even) th,
                        .table-detail tr:nth-child(even) td {
                            background-color: #ffffff; /* putih */
                        }

                        /* Hover effect */
                        .table-detail tr:hover th,
                        .table-detail tr:hover td {
                            background-color: #d8eefc; /* sedikit lebih gelap saat hover */
                            transition: background-color .12s ease-in-out;
                        }

                        /* Pastikan border dan padding tetap rapi */
                        .table-detail th,
                        .table-detail td {
                            border: 1px solid #dee2e6;
                            padding: .45rem .6rem;
                        }
                    </style>

                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6 mb-3">
                            <table class="table table-sm table-detail">
                                <tr><th>Kategori</th><td>{{ $asset->kategori->nama_kategori ?? '-' }}</td></tr>
                                <tr><th>Type Service</th><td>{{ $asset->asset_type ?? '-' }}</td></tr>
                                <tr><th>Code</th><td>{{ $asset->code ?? '-' }}</td></tr>
                                <tr><th>Nama Service</th><td>{{ $asset->item_name ?? '-' }}</td></tr>
                                <tr><th>Service Number</th><td>{{ $asset->asset_number ?? '-' }}</td></tr>
                                <tr><th>Qty</th><td>{{ $asset->qty ?? 0 }}</td></tr>
                                <tr><th>User</th><td>{{ $asset->user ?? '-' }}</td></tr>
                                <tr><th>Departemen</th><td>{{ $asset->departemen ?? '-' }}</td></tr>
                                <tr><th>Site</th><td>{{ $asset->site ?? '-' }}</td></tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $asset->tanggal ? \Carbon\Carbon::parse($asset->tanggal)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6 mb-3">
                            <table class="table table-sm table-detail">
                                <tr><th>Service ID</th><td>{{ $asset->serial_number ?? '-' }}</td></tr>
                                <tr>
                                    <th>Masa Garansi</th>
                                    <td>{{ $asset->warranty_expiry ? \Carbon\Carbon::parse($asset->warranty_expiry)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                                <tr><th>Official Store</th><td>{{ $asset->official_store ?? '-' }}</td></tr>
                                <tr><th>Reseller</th><td>{{ $asset->reseller ?? '-' }}</td></tr>
                                <tr><th>Harga Beli</th><td>Rp {{ number_format($asset->harga_beli ?? 0, 0, ',', '.') }}</td></tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($asset->status == 'new')
                                            <span class="badge bg-success">Baru</span>
                                        @elseif ($asset->status == 'active')
                                            <span class="badge bg-primary">Aktif</span>
                                        @elseif ($asset->status == 'reclaimed')
                                            <span class="badge bg-warning text-dark">Reclaimed</span>
                                        @elseif ($asset->status == 'damaged')
                                            <span class="badge bg-danger">Rusak</span>
                                        @elseif ($asset->status == 'lost')
                                            <span class="badge bg-dark">Hilang</span>
                                        @elseif ($asset->status == 'disposed')
                                            <span class="badge bg-secondary">Dibuang</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ ucfirst($asset->status ?? '-') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr><th>Catatan</th><td>{{ $asset->catatan ?? '-' }}</td></tr>
                            </table>
                        </div>
                    </div>

                    <a href="{{ route('backend.asset.index') }}" class="btn btn-secondary mt-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
