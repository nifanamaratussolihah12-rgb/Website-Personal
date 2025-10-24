@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">

    <div class="card mb-3">
        <div class="card-body" style="font-size:13px;">
            <h4>📝 Detail Formulir Finding</h4>

            <br>
            {{-- Informasi Umum --}}
            <h5 class="mt-3 text-decoration-underline">Informasi Umum</h5>
            <p><strong>Nama Departemen:</strong> {{ $finding->nama_departemen ?? '-' }}</p>
            <p><strong>Lokasi Temuan:</strong> {{ $finding->lokasi_temuan ?? '-' }}</p>
            <p><strong>Tanggal Penemuan:</strong> 
                {{ $finding->tanggal_penemuan ? \Carbon\Carbon::parse($finding->tanggal_penemuan)->translatedFormat('d F Y') : '-' }}
            </p>
            <p><strong>Judul Temuan:</strong> {{ $finding->judul_temuan ?? '-' }}</p>
            <p><strong>Deskripsi Temuan:</strong> {{ $finding->deskripsi_temuan ?? '-' }}</p>
            {{-- Status + Catatan --}}
            <p>
                <strong>Status:</strong> 
                @if( $finding->status == 'pending approval')
                    <span class="badge bg-warning text-dark">Pending Approval</span>
                @elseif( $finding->status == 'approval')
                    <span class="badge bg-info text-dark">Approval</span>
                @elseif( $finding->status == 'done')
                    <span class="badge bg-success">Done</span>
                @else
                    <span class="badge bg-secondary">-</span>
                @endif
            </p>
            <p><strong>Catatan:</strong> {{  $finding->catatan ?? '-' }}</p>
            <br>
            {{-- Form Readiness --}}
            <h5 class="mt-3 text-decoration-underline">Form Readiness</h5>
            <p><strong>Form Readiness Terkait:</strong> {{ $finding->form_readiness_terkait ?? '-' }}</p>
            <p><strong>Tanggal Form Readiness:</strong> 
                {{ $finding->tanggal_form_readiness ? \Carbon\Carbon::parse($finding->tanggal_form_readiness)->translatedFormat('d F Y') : '-' }}
            </p>
            <br>
            {{-- Bukti Temuan --}}
            <h5 class="mt-3 text-decoration-underline">Bukti Temuan</h5>
            <p><strong>Keterangan Bukti:</strong> {{ $finding->bukti_temuan_text ?? '-' }}</p>
            <p style="font-size:12px; font-family:Arial;">
                <strong>Foto Bukti:</strong>
                @if($finding->bukti_temuan_foto)
                    @php
                        $fileName = basename($finding->bukti_temuan_foto); // ambil nama file saja
                    @endphp
                    <a href="{{ asset('storage/' . $finding->bukti_temuan_foto) }}" 
                    target="_blank" 
                    style="font-size:12px; margin-left:5px; word-break:break-all;">
                    {{ $fileName }}
                    </a>
                @else
                    Tidak ada foto bukti.
                @endif
            </p>
            <br>
            {{-- Analisis Temuan --}}
            <h5 class="mt-3 text-decoration-underline">Analisis Temuan</h5>
            <p><strong>Penyebab:</strong> {{ $finding->analisis_penyebab ?? '-' }}</p>
            <p><strong>Dampak:</strong> {{ $finding->analisis_dampak ?? '-' }}</p>
            <br>
            {{-- Tindakan --}}
            <h5 class="mt-3 text-decoration-underline">Tindakan</h5>
            <p><strong>Tindakan Sementara:</strong> {{ $finding->tindakan_sementara ?? '-' }}</p>
            <p><strong>Tindakan Perbaikan:</strong> {{ $finding->tindakan_perbaikan ?? '-' }}</p>
            <p><strong>Penanggung Jawab Tindakan:</strong> {{ $finding->penanggung_jawab_tindakan ?? '-' }}</p>
            <p><strong>Target Waktu Penyelesaian:</strong> 
                {{ $finding->target_waktu_penyelesaian ? \Carbon\Carbon::parse($finding->target_waktu_penyelesaian)->translatedFormat('d F Y') : '-' }}
            </p>
            <br>
            {{-- Status Follow Up --}}
            <h5 class="mt-3 text-decoration-underline">Status Follow Up</h5>
            <p><strong>Status:</strong> {{ ucfirst($finding->status_follow_up ?? '-') }}</p>
            <p><strong>Tanggal Verifikasi:</strong> 
                {{ $finding->tanggal_verifikasi ? \Carbon\Carbon::parse($finding->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}
            </p>
            <p><strong>Hasil Verifikasi:</strong> {{ $finding->hasil_verifikasi ?? '-' }}</p>
        </div>
    </div>
</div>
<a href="{{ route('backend.finding.index') }}" 
   class="btn btn-secondary mt-3 d-block mx-auto text-center" 
   style="width: 150px;">
   Kembali
</a>
@endsection
