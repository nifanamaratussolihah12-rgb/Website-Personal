@extends('backend.v_layouts.app')

@section('content')
<div class="container">
    <h4>Detail Formulir Memo</h4>

    {{-- Bagian Disposisi --}}
    <h6 class="mt-3">Disposisi</h6>
    <div class="card mb-3" style="font-size:12px;">
        <div class="card-body">
            <p><strong>TGL & No. Surat:</strong> {{ $memo->tgl_no_surat ?? '-' }}</p>
            @php
                $perihals = is_array($memo->perihal) ? $memo->perihal : json_decode($memo->perihal, true);
            @endphp
            <p><strong>Perihal:</strong> {{ implode(', ', $perihals) }}</p>
            <p><strong>Lampiran:</strong> {{ $memo->lampiran ?? '-' }}</p>
            <p><strong>Dari:</strong> {{ $memo->dari_disposisi ?? '-' }}</p>
            <p><strong>Tanggal Disposisi:</strong> 
                {{ $memo->tanggal_disposisi ? \Carbon\Carbon::parse($memo->tanggal_disposisi)->format('d-m-Y') : '-' }}
            </p>

            <table style="width:100%; border:1px solid black; border-collapse: collapse; margin-top:-1px;">
                <thead>
                    <tr>
                        <th style="border:1px solid black; padding:5px; text-align:center; font-weight: normal; font-size:13px;">TUJUAN</th>
                        <th style="border:1px solid black; padding:5px; text-align:center; font-weight: normal; font-size:12px;"></th>
                        <th style="border:1px solid black; padding:5px; text-align:center; font-weight: normal; font-size:13px;">KETERANGAN</th>
                    </tr>
                </thead>
                @php
                    // pastikan disposisi selalu array
                    $disposisi = is_array($memo->disposisi) ? $memo->disposisi : json_decode($memo->disposisi, true);
                @endphp

                <tbody>
                    {{-- Disposisi Atas --}}
                    @if(!empty($disposisi['atas']))
                        @foreach($disposisi['atas'] as $row)
                            <tr>
                                <td style="border:1px solid black; padding:5px; width:32%;">{{ $row['tujuan'] ?? '' }}</td>
                                <td style="border:1px solid black; padding:5px; text-align:center; width:8%;">{{ $row['status'] ?? '' }}</td>
                                <td style="border:1px solid black; padding:5px; width:60%;">{{ $row['keterangan'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif

                    {{-- Baris DITERUSKAN --}}
                    <tr>
                        <th colspan="3" style="border:1px solid black; padding:5px; font-weight: normal; font-size:13px; text-align: left;">
                            DITERUSKAN
                        </th>
                    </tr>

                    {{-- Disposisi Bawah --}}
                    @if(!empty($disposisi['bawah']))
                        @foreach($disposisi['bawah'] as $row)
                            <tr>
                                <td style="border:1px solid black; padding:5px; width:32%;">{{ $row['tujuan'] ?? '' }}</td>
                                <td style="border:1px solid black; padding:5px; text-align:center; width:8%;">{{ $row['status'] ?? '' }}</td>
                                <td style="border:1px solid black; padding:5px; width:60%;">{{ $row['keterangan'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bagian Memo --}}
    <h6 class="mt-4">Memo</h6>
    <div class="card mb-3" style="font-size:12px;">
        <div class="card-body">
            <p><strong>Tempat:</strong> {{ $memo->lokasi_memo ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $memo->tanggal_memo ? \Carbon\Carbon::parse($memo->tanggal_memo)->format('d-m-Y') : '-' }}</p>
            <p><strong>Nomor Memo:</strong> {{ $memo->nomor ?? '-' }}</p>
            <p><strong>Kepada:</strong> {{ $memo->kepada ?? '-' }}</p>
            <p><strong>Dari:</strong> {{ $memo->dari_memo ?? '-' }}</p>
            <p><strong>Perihal Memo:</strong> {!! nl2br(e($memo->perihal_memo)) !!}</p>
            <p><strong>Isi Memo:</strong><br> {!! $memo->isi !!}</p>
        </div>
    </div>

    {{-- Bagian TTD --}}
    <h6 class="mt-4">Tanda Tangan</h6>
    <div class="card mb-3" style="font-size:12px;">
        <div class="card-body">
            <p><strong>Disusun Oleh:</strong> {{ $memo->ttd_disusun_nama ?? '-' }} ({{ $memo->ttd_disusun_jabatan ?? '-' }})</p>
            <p><strong>Diperiksa Oleh:</strong> {{ $memo->ttd_diperiksa_nama ?? '-' }} ({{ $memo->ttd_diperiksa_jabatan ?? '-' }})</p>
            <p><strong>Disetujui Oleh:</strong> {{ $memo->ttd_disetujui_nama ?? '-' }} ({{ $memo->ttd_disetujui_jabatan ?? '-' }})</p>
        </div>
    </div>

    {{-- Status + Catatan --}}
    <h6 class="mt-4">Status & Catatan</h6>
    <div class="card mb-3" style="font-size:12px;">
        <div class="card-body">
            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if($memo->status == 'pending approval')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif($memo->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif($memo->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{ $memo->catatan ?? '-' }}</p>
        </div>
    </div>



    <a href="{{ route('backend.memo.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
