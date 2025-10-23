@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <h4>Detail Formulir Permintaan Asset IT</h4>

    {{-- Request By --}}
    <div class="card mb-3">
        <div class="card-body">
            <p>
                <strong>Tipe Request</strong> : 
                {{ $requestData->request_type ?? '-' }}
                @if(!empty($requestData->request_type_extra) && $requestData->request_type == 'Replacement ( refer to doc FP3IT)')
                    : {{ $requestData->request_type_extra }}
                @endif
            </p>
            <p><strong>Request Ref Num:</strong> {{ $requestData->request_ref_num ?? '-' }}</p>
            <p><strong>Nik:</strong> {{ $requestData->nik ?? '-' }}</p>
            <p><strong>Departemen:</strong> {{ $requestData->dept ?? '-' }}</p>
            <p><strong>Section:</strong> {{ $requestData->section ?? '-' }}</p>
            <p><strong>Tipe Asset:</strong> {{ $requestData->asset_type ?? '-' }}</p>

            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if($requestData->status == 'pending approval')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif($requestData->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif($requestData->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{ $requestData->catatan ?? '-' }}</p>

            {{-- Tanggal Dokumen --}}
            <p><strong>Tanggal Dokumen Diterbitkan:</strong> 
                {{ $requestData->tanggal_dokumen?->format('d F Y') ?? '-' }}
            </p>
            <p><strong>Tanggal Dokumen Expired:</strong> 
                {{ $requestData->tanggal_expired?->format('d F Y') ?? '-' }}
            </p>

            <p><strong>Detail Request:</strong></p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Qty</th>
                        <th>User / PIC</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($requestData->details) && is_array($requestData->details))
                        @foreach($requestData->details as $key => $detail)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $detail['brand'] ?? '-' }}</td>
                            <td>{{ $detail['model'] ?? '-' }}</td>
                            <td>{{ $detail['qty'] ?? '-' }}</td>
                            <td>{{ $detail['user_pic'] ?? '-' }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada detail asset.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('backend.assetrequest.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
