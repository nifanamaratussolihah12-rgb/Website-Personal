@extends('backend.v_layouts.app')

@section('content')
<div class="card shadow-sm border-0">

    <div class="card mb-3">
        <div class="card-body">
            <h4>📝 Detail Formulir Permintaan Perbaikan Perangkat IT (F3PIT)</h4>
            <br>
            {{-- Status + Catatan --}}
             <h5 class="mt-3">Status + Catatan</h5>
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
            <p><strong>Catatan:</strong> {{ $form->catatan ?? '-' }}</p>

            <hr>
            {{-- TABEL SEBELAH KIRI --}}
            <p><strong>Departemen:</strong> {{ $form->departement ?? '-' }}</p>
            <p><strong>PIC:</strong> {{ $form->pic ?? '-' }}</p>
            <p><strong>Jabatan:</strong> {{ $form->jabatan ?? '-' }}</p>
            <p><strong>Kode Inventaris:</strong> {{ $form->kode_inventaris ?? '-' }}</p>
            <p><strong>Tahun Perolehan:</strong> {{ $form->tahun_perolehan ? \Carbon\Carbon::parse($form->tahun_perolehan)->translatedFormat('d F Y') : '-' }}</p>
            <p><strong>Jenis Inventaris:</strong> {{ $form->jenis_inventaris ?? '-' }}</p>
            <p><strong>Brand:</strong> {{ $form->brand ?? '-' }}</p>
            <p><strong>Tipe:</strong> {{ $form->tipe ?? '-' }}</p>
            <p><strong>S/N:</strong> {{ $form->sn ?? '-' }}</p>

            <h6 class="mt-3 text-decoration-underline">Sejarah Perbaikan</h6>
            <p><strong>Tanggal:</strong> {{ $form->sejarah_tanggal ? \Carbon\Carbon::parse($form->sejarah_tanggal)->translatedFormat('d F Y') : '-' }}</p>
            <p><strong>Keterangan:</strong> {{ $form->sejarah_keterangan ?? '-' }}</p>

            <h6 class="mt-1 text-decoration-underline">Deskripsi Permasalahan</h6>
            {{ $form->deskripsi_permasalahan ?? '-' }}

            <h6 class="mt-3 text-decoration-underline">Penyebab Kerusakan</h6>
            @if($form->penyebab_kerusakan_cetak && $form->penyebab_kerusakan_cetak != '-')
                            <ul style="margin:0; padding-left:8px;">
                                @foreach(explode(', ', $form->penyebab_kerusakan_cetak) as $item)
                                    <li style="margin-bottom:5px;">{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p style="margin:0;">-</p>
                        @endif
            @if($form->penyebab_kerusakan_notes)
            Notes: {{ $form->penyebab_kerusakan_notes }}
            @endif

            <h6 class="mt-3 text-decoration-underline">Langkah yang Sudah Dilakukan</h6>
            @if(!empty($form->langkah_dilakukan_cetak))
            @foreach($form->langkah_dilakukan_cetak as $item)
                @if(!empty($item['setuju']) || !empty($item['notes']))
                    <div class="mt-3 text-decoration-underline" style="font-size:13px; gap:5px;">
                        <span><strong>{{ $item['label'] }} :</strong></span>
                        <span>{{ $item['notes'] ?? '-' }}</span>
                    </div>
                @endif
            @endforeach
            @else
                <div style="font-weight:bold; font-family:Arial; margin-top:1px; margin-bottom:1px;">
                    Tidak ada langkah dilakukan
                </div>
                <table style="border-collapse:collapse; width:95%; font-family:Arial; margin-top:2px; margin-bottom:5px;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; min-height:50px;">-</td>
                    </tr>
                </table>
            @endif

            <hr>
            {{-- TABEL SEBELAH KANAN --}}
            <h6 class="mt-3 text-decoration-underline">Kondisi Fisik Penyerahan Perangkat</h6>
            <p>{{ $form->kondisi_fisik ?? '-' }}</p>
            <p><strong>Prioritas Pengerjaan:</strong> 
             @if(!empty($form->prioritas_pengerjaan))
                                @switch($form->prioritas_pengerjaan)
                                    @case('normal')
                                        Normal
                                        @break
                                    @case('urgent')
                                        Urgent
                                        @break
                                    @case('top_urgent')
                                        Top Urgent
                                        @break
                                    @default
                                        -
                                @endswitch
                            @else
                                -
                            @endif  
            </p>

            <p><strong>Pemohon:</strong> {{ $form->pemohon ?? '-' }}</p>
            <p><strong>Dep. Head:</strong> {{ $form->dep_head ?? '-' }}</p>

            <h6 class="mt-3 text-decoration-underline">** Bagian ini diisi oleh IT Dept.</h6>
            @if($form->kelengkapan_dokumen || $form->lampiran_formulir)
                                <ul style="margin:0; padding-left:12px;">
                                    @if($form->kelengkapan_dokumen)
                                        <li style="margin-bottom:5px;">Kelengkapan Dokumen</li>
                                    @endif
                                    @if($form->lampiran_formulir)
                                        <li style="margin-bottom:5px;">Lampiran Formulir</li>
                                    @endif
                                </ul>
                            @else
                                <p style="margin:0;">-</p>
                            @endif

            <p><strong>Diterima dan diperiksa fisik oleh:</strong> {{ $form->diterima_oleh ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->translatedFormat('d F Y') : '-' }}</p>
            <p><strong>Garansi Sebelumnya:</strong> {{ $form->garansi_sebelumnya ? \Carbon\Carbon::parse($form->garansi_sebelumnya)->translatedFormat('d F Y') : '-' }}</p>
            <p><strong>Pemeriksaan teknis Oleh:</strong> {{ $form->pemeriksaan_teknis_oleh ?? '-' }}</p>

            <p><strong> @if(!empty($form->diputuskan_internal_it['setuju']))
                        Diputuskan Internal IT, dengan penggantian komponen :</strong>
                        {{ $form->diputuskan_internal_it['nama'] ?? '-' }}
                    @endif </p>

            <p><strong>@if(!empty($form->diputuskan_vendor['setuju']))
                        Diputuskan diperbaiki ke Vendor : </strong>
                        {{ $form->diputuskan_vendor['nama'] ?? '-' }}
                    @endif</p>
            
            
            <p><strong>Hasil Perbaikan diperiksa oleh:</strong> {{ $form->hasil_diperiksa_oleh ?? '-' }}</p>
            <p><strong>Tgl:</strong> {{ $form->hasil_diperiksa_tgl ? \Carbon\Carbon::parse($form->hasil_diperiksa_tgl)->translatedFormat('d F Y') : '-' }}</p>

            @if($form->sn_sesuai || $form->bukti_penggantian)
                                <ul style="margin:0; padding-left:12px;">
                                    @if($form->sn_sesuai)
                                        <li style="margin-bottom:5px;">S/N Sesuai</li>
                                    @endif
                                    @if($form->bukti_penggantian)
                                        <li style="margin-bottom:5px;">Bukti Penggantian Material</li>
                                    @endif
                                </ul>
                            @else
                                <p style="margin:0;">-</p>
                            @endif
        </div>
    </div>
</div>
<a href="{{ route('backend.f3pit.index') }}" 
   class="btn btn-secondary mt-3 d-block mx-auto text-center" 
   style="width: 150px;">
   Kembali
</a>
@endsection