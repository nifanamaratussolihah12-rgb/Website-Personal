@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">

    <div class="card mb-3">
        <div class="card-body">
            <h4>📝 Detail Formulir Serah Terima Asset IT</h4>
            <br>
            <h5>Diajukan Oleh</h5>
            <p><strong>Nama :</strong> {{ $handover->nama_user }}</p>
            <p><strong>Nik:</strong> {{ $handover->nik_user }}</p>
            <p><strong>Departemen:</strong> {{ $handover->dept ?? '-' }}</p>
            <p><strong>Section:</strong> {{ $handover->section ?? '-' }}</p>
            <p><strong>Tanggal:</strong> 
                {{ $handover->tanggal ? $handover->tanggal->translatedFormat('d F Y') : '-' }}
            </p>
            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if($handover->status == 'pending approval')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif($handover->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif($handover->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{ $handover->catatan ?? '-' }}</p>
            <br>
            <h5>Detail Asset</h5>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Tipe Asset</th>
                <td>{{ $handover->tipe_asset }}</td>
            </tr>
            <tr>
                <th>Tipe Penyerahan</th>
                <td>{{ $handover->handover_type }}</td>
            </tr>
            <tr>
                <th>Nama Asset</th>
                <td>Brand : {{ $handover->brand_asset ?? '-' }}</td>
                <td>Model : {{ $handover->model_asset ?? '-' }}</td>
            </tr>
                <th>Asset Tag</th>
                <td>{{ $handover->asset_tag ?? '-' }}</td>
            </tr>
            <tr>
                <th>Serial Number</th>
                <td>{{ $handover->asset_sn ?? '-' }}</td>
            </tr>
            <tr>
                <th>Ref RL Acumatica</th>
                <td>{{ $handover->ref_rl_acumatica ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <h5>Diserahkan Oleh</h5>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $handover->handover_by }}</p>
            <p><strong>NIK:</strong> {{ $handover->handover_by_nik ?? '-' }}</p>
            <p><strong>Tanggal Serah:</strong> 
                {{ $handover->handover_date ? $handover->handover_date->translatedFormat('d F Y') : '-' }}
            </p>
        </div>
    </div>
    </div>
    </div>
</div>
<a href="{{ route('backend.assethandoverforms.index') }}" 
   class="btn btn-secondary mt-3 d-block mx-auto text-center" 
   style="width: 150px;">
   Kembali
</a>
@endsection
