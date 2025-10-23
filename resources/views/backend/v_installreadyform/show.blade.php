@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <h4>Detail Formulir Readiness/Kesiapan Instalasi</h4>

    {{-- Informasi Utama --}}
    <div class="card mb-3" style="font-size:12px;">
        <div class="card-body" style="font-size:12px;">
            <p><strong>Project:</strong> {{ $form->project ?? '-' }}</p>
            <p><strong>Lokasi:</strong> {{ $form->lokasi ?? '-' }}</p>
            <p><strong>Tim Pelaksana:</strong> {{ $form->tim_pelaksana ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->format('d-m-Y') : '-' }}</p>
        </div>
    </div>

    {{-- Status + Catatan --}}
    <h5 class="mt-3">Status + Catatan</h5>
    <div class="card mb-3">
        <div class="card-body">
            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if($form->status == 'pending approval')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif($form->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif($form->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{ $form->note ?? '-' }}</p>
        </div>
    </div>

    {{-- Persiapan Awal --}}
    <h7 class="mt-3" style="font-size:12px;">1. PERSIAPAN AWAL</h7>
    <div class="card mb-3">
        <div class="card-body" style="font-size:12px;">
            @if(!empty($form->persiapan_awal))
                <ul>
                    @foreach($form->persiapan_awal as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada data persiapan awal.</p>
            @endif
        </div>
    </div>

    {{-- K3 --}}
    <h7 class="mt-3" style="font-size:12px;">2. KESEHATAN & KESELAMATAN KERJA ( K3 )</h7>
    <div class="card mb-3">
        <div class="card-body" style="font-size:12px;">
            @if(!empty($form->k3))
                <ul>
                    @foreach($form->k3 as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada data K3.</p>
            @endif
        </div>
    </div>

    {{-- Aspek Teknis --}}
    <h7 class="mt-3" style="font-size:12px;">3. ASPEK TEKNIS</h7>
    <div class="card mb-3">
        <div class="card-body" style="font-size:12px;">
            @if(!empty($form->aspek_teknis))
                <ul>
                    @foreach($form->aspek_teknis as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada data aspek teknis.</p>
            @endif
        </div>
    </div>

    {{-- Manajemen Object --}}
    <h7 class="mt-3" style="font-size:12px;">4. MANAJEMEN PROJECT</h7>
    <div class="card mb-3">
        <div class="card-body" style="font-size:12px;">
            @if(!empty($form->manajemen))
                <ul>
                    @foreach($form->manajemen as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada data manajemen object.</p>
            @endif
        </div>
    </div>

    {{-- Pasca Object --}}
    <h7 class="mt-3" style="font-size:12px;">5. PASCA PROJECT</h7>
    <div class="card mb-3">
        <div class="card-body" style="font-size:12px;">
            @if(!empty($form->pasca))
                <ul>
                    @foreach($form->pasca as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada data pasca object.</p>
            @endif
        </div>
    </div>

    {{-- Informasi Tambahan --}}
    <div class="card mb-3" style="font-size:12px;">
        <div class="card-body" style="font-size:12px;">
            <p><strong>Catatan Tambahan:</strong> {{ $form->catatan ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ route('backend.installreadyform.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection