@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <h4>Detail Formulir Working Order</h4>

    {{-- Informasi Utama --}}
    <h5 class="mt-3">Informasi Utama</h5>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $order->nama ?? '-' }}</p>
            <p><strong>Divisi:</strong> {{ $order->divisi ?? '-' }}</p>
            <p><strong>Section:</strong> {{ $order->section ?? '-' }}</p>
            <p><strong>Permintaan:</strong> {{ $order->permintaan ?? '-' }}</p>
            <p><strong>Jenis Pekerjaan:</strong> {{ ucfirst($order->jenis_pekerjaan) ?? '-' }}</p>
            <p><strong>Lokasi:</strong> {{ $order->lokasi ?? '-' }}</p>
            <p><strong>Details:</strong> {{ $order->details ?? '-' }}</p>
            <p><strong>Dokumen Di Terima:</strong> {{ $order->dokumen_diterima ?? '-' }}</p>
            <p><strong>Target Pengerjaan:</strong> {{ $order->target_pengerjaan ? \Carbon\Carbon::parse($order->target_pengerjaan)->format('d-m-Y') : '-' }}</p>
            <p><strong>Tanggal Dibuat:</strong> {{ $order->tanggal ? \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') : '-' }}</p>
            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if($order->status == 'pending approval')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif($order->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif($order->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{ $order->catatan ?? '-' }}</p>
        </div>
    </div>

    {{-- IT & SI Preparation Checklist --}}
<h5 class="mt-3">IT & SI Preparation Checklist</h5>
<table style="border:0.5px solid #000; border-collapse:collapse; width:100%; font-size:12px; margin-top:10px; text-align:center;">
    <thead>
        <tr>
            <th style="border:0.5px solid #000; padding:4px; width:40%;">TASK</th>
            <th style="border:0.5px solid #000; padding:4px; width:15%;">STATUS</th>
            <th style="border:0.5px solid #000; padding:4px; width:25%;">REASON</th>
            <th style="border:0.5px solid #000; padding:4px; width:20%;">SIGN</th>
        </tr>
    </thead>
    <tbody>
        {{-- 1. Kesiapan instalasi listrik --}}
        <tr>
            <td style="border:0.5px solid #000; padding:4px; text-align:left;">
                Kesiapan instalasi listrik & ke-stabilan listrik
            </td>
            <td style="border:0.5px solid #000; padding:4px;">{{ ucfirst($order->status_kesiapan_listrik) ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->reason_kesiapan_listrik ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->sign_kesiapan_listrik ?? '-' }}</td>
        </tr>

        {{-- 2. Tiang --}}
        <tr>
            <td style="border:0.5px solid #000; padding:4px; text-align:left;">Tiang</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ ucfirst($order->status_tiang) ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->reason_tiang ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->sign_tiang ?? '-' }}</td>
        </tr>

        {{-- 3. CCTV / Radio / Perangkat Jaringan --}}
        <tr>
            <td style="border:0.5px solid #000; padding:4px; text-align:left;">
                {{ ucfirst($order->task_perangkat) ?? '-' }}
            </td>
            <td style="border:0.5px solid #000; padding:4px;">{{ ucfirst($order->status_perangkat) ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->reason_perangkat ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->sign_perangkat ?? '-' }}</td>
        </tr>

        {{-- 4. Panel --}}
        <tr>
            <td style="border:0.5px solid #000; padding:4px; text-align:left;">Panel</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ ucfirst($order->status_panel) ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->reason_panel ?? '-' }}</td>
            <td style="border:0.5px solid #000; padding:4px;">{{ $order->sign_panel ?? '-' }}</td>
        </tr>

        @if(!empty($order->task_keselamatan))
            {{-- Baris pertama: Keselamatan Kerja --}}
            <tr>
                <td style="border:0.5px solid #000; padding:4px; text-align:left;">Keselamatan Kerja</td>
                <td style="border:0.5px solid #000; padding:4px;">{{ ucfirst($order->status_keselamatan[0] ?? '-') }}</td>
                <td style="border:0.5px solid #000; padding:4px;">{{ $order->reason_keselamatan[0] ?? '-' }}</td>
                <td style="border:0.5px solid #000; padding:4px;">{{ $order->sign_keselamatan[0] ?? '-' }}</td>
            </tr>

            {{-- Baris manual 1, 2, 3... --}}
            @foreach(($order->task_keselamatan ?? []) as $index => $task)
                <tr>
                    <td style="border:0.5px solid #000; padding:4px; text-align:left;">{{ ($index+1).'. '.$task }}</td>
                    <td style="border:0.5px solid #000; padding:4px;">{{ ucfirst($order->status_keselamatan[$index+1] ?? '-') }}</td>
                    <td style="border:0.5px solid #000; padding:4px;">{{ $order->reason_keselamatan[$index+1] ?? '-' }}</td>
                    <td style="border:0.5px solid #000; padding:4px;">{{ $order->sign_keselamatan[$index+1] ?? '-' }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
    <a href="{{ route('backend.workingorder.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
