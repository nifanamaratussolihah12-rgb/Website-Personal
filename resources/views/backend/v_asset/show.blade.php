@extends('backend.v_layouts.app')
@section('content')

<div class="card shadow-sm border-0">    
    <div class="card-body">
        <h4 class="card-title">🔍 Detail Data Asset</h4>
        <hr>
        <style>
            /* Table styling */
            .table-detail th {
                font-weight: 600;
                width: 25%;
                vertical-align: middle;
                background-color: #e3f2fd;
            }
            .table-detail td {
                width: 25%;
                background-color: #fff;
            }
            .table-detail tr:nth-child(even) th,
            .table-detail tr:nth-child(even) td {
                background-color: #f8fbff;
            }
            .table-detail th, .table-detail td {
                border: 1px solid #dee2e6;
                padding: .5rem .75rem;
            }

            .table-detail {
                min-width: 900px;
            }

            /* Scroll container */
            .asset-container {
                display: flex;
                flex-direction: row;
                align-items: flex-start;
                overflow-x: auto;
                gap: 1.5rem;
                padding-bottom: 1rem;
            }
            .asset-container::-webkit-scrollbar {
                height: 8px;
            }
            .asset-container::-webkit-scrollbar-thumb {
                background: #b0bec5;
                border-radius: 10px;
            }
            .asset-container::-webkit-scrollbar-thumb:hover {
                background: #90a4ae;
            }
        </style>

        <div class="asset-container">
            <!-- FOTO DI KIRI -->
            <div class="text-center d-flex flex-column align-items-center" style="flex: 0 0 280px;">
                <h5 class="mb-2 text-black">Foto Asset</h5>
                @if($asset->foto)
                    <img src="{{ asset('img-asset/'.$asset->foto) }}" 
                         class="img-thumbnail shadow-sm rounded-3" 
                         style="max-width: 250px;">
                @else
                    <div class="text-muted fst-italic mt-3">Tidak ada foto</div>
                @endif
            </div>

            <!-- TABEL DETAIL -->
            <div class="flex-grow-1 table-responsive" style="min-width: 900px; overflow-x: auto;">
                <table class="table table-sm table-detail mb-3 align-middle w-100">
                    <tr>
                        <th>Kategori</th><td>{{ $asset->kategori->nama_kategori ?? '-' }}</td>
                        <th>Type Asset</th><td>{{ $asset->asset_type ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Code</th><td>{{ $asset->code ?? '-' }}</td>
                        <th>Nama Asset</th><td>{{ $asset->item_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Asset Number</th><td>{{ $asset->asset_number ?? '-' }}</td>
                        <th>Qty</th><td>{{ $asset->qty ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>User</th><td>{{ $asset->user ?? '-' }}</td>
                        <th>Departemen</th><td>{{ $asset->departemen ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ruang</th><td>{{ $asset->room ?? '-' }}</td>
                        <th>Lantai</th><td>{{ $asset->floor ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Site</th><td>{{ $asset->site ?? '-' }}</td>
                        <th>Merk</th><td>{{ $asset->merk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Model</th><td>{{ $asset->model ?? '-' }}</td>
                        <th>Spek</th><td>{{ $asset->spek ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>
                            @if($asset->kondisi == 'baik')
                                <span class="badge bg-success">Baik</span>
                            @elseif($asset->kondisi == 'layak pakai')
                                <span class="badge bg-warning text-dark">Layak Pakai</span>
                            @elseif($asset->kondisi == 'rusak')
                                <span class="badge bg-danger">Rusak</span>
                            @else
                                -
                            @endif
                        </td>
                        <th>Tanggal</th>
                        <td>{{ $asset->tanggal ? \Carbon\Carbon::parse($asset->tanggal)->translatedFormat('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Seri</th><td>{{ $asset->serial_number ?? '-' }}</td>
                        <th>History</th><td>{{ $asset->history ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Masa Garansi</th>
                        <td>{{ $asset->warranty_expiry ? \Carbon\Carbon::parse($asset->warranty_expiry)->translatedFormat('d F Y') : '-' }}</td>
                        <th>Official Store</th><td>{{ $asset->official_store ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Reseller</th><td>{{ $asset->reseller ?? '-' }}</td>
                        <th>Harga Beli</th><td>Rp {{ number_format($asset->harga_beli ?? 0, 0, ',', '.') }}</td>
                    </tr>
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
                        <th>Catatan</th><td>{{ $asset->catatan ?? '-' }}</td>
                    </tr>
                </table>
                <!-- Tombol di bawah tabel sebelah kanan -->
                <div class="text-end mt-3">
                    <a href="{{ route('backend.asset.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
