@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">

    {{-- Pemilik Sebelumnya --}}
    <div class="card mb-3">
        <div class="card-body">
            <h4>📝 Detail Formulir Peralihan Asset IT</h4>
            <br>
            <h5 class="mt-3">Pemilik Sebelumnya</h5>
            <p><strong>Departemen:</strong> {{ $transfer->prev_user ?? '-' }}</p>
            <p><strong>Pengguna:</strong> {{ $transfer->prev_department ?? '-' }}</p>
            <p><strong>Alasan Pengalihan:</strong> {{ $transfer->transfer_reason ?? '-' }}</p>

            <br>
            <h5 class="mt-3">Pemilik Baru</h5>
            <p><strong>Departemen:</strong> {{ $transfer->new_department ?? '-' }}</p>
            <p><strong>Pengguna:</strong> {{ $transfer->new_user ?? '-' }}</p>
            <p><strong>Tanggal Peralihan:</strong> {{ $transfer->transfer_date ? $transfer->transfer_date->translatedFormat('d F Y') : '-' }}</p>
            <p><strong>Lokasi Penempatan:</strong> {{ $transfer->placement_location ?? '-' }}</p>
            <p><strong>Kondisi Asset:</strong> {{ $transfer->asset_condition ?? '-' }}</p>
            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if($transfer->status == 'pending approval')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif($transfer->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif($transfer->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{ $transfer->catatan ?? '-' }}</p>

            <br>
            {{-- Detail Asset --}}
    <h5 class="mt-3">Detail Asset</h5>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Tag Asset</th>
                <td>{{ $transfer->asset_tag ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Asset</th>
                <td>Brand: {{ $transfer->asset_brand ?? '-' }}</td>
                <td>Model: {{ $transfer->asset_model ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $transfer->category ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nomor Seri</th>
                <td>{{ $transfer->serial_number ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tgl Pembelian</th>
                <td>{{ $transfer->purchase_date ? $transfer->purchase_date->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Harga Pembelian</th>
                <td>
                    @if($transfer->purchase_price)
                        Rp. {{ number_format($transfer->purchase_price, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Status Garansi</th>
                <td>{{ $transfer->warranty_status ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tgl Akhir Garansi</th>
                <td>{{ $transfer->warranty_end_date ? $transfer->warranty_end_date->translatedFormat('d F Y') : '-' }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    {{-- Status + Catatan --}}
    <h5 class="mt-3">Status + Catatan</h5>
            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if($transfer->status == 'pending approvla')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif($transfer->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif($transfer->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{ $transfer->catatan ?? '-' }}</p>
    </div>
</div>
</div>
<a href="{{ route('backend.assettransfer.index') }}" 
   class="btn btn-secondary mt-3 d-block mx-auto text-center" 
   style="width: 150px;">
   Kembali
</a>
@endsection
