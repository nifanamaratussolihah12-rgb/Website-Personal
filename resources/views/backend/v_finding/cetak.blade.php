<!-- HEADER ATAS -->
<table style="width:100%; border-collapse:collapse; margin-bottom:5px;">
    <tr>
        <!-- Kolom Kiri (Logo + teks) -->
        <td style="width:25%; padding:0; vertical-align:top;">
            <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:100px;">
                <tr>
                    <td style="text-align:center; vertical-align:middle; border-bottom:1px solid #000; padding:4px; height:100px;">
                        <img src="{{ realpath('image/logo_AKM.png') }}" alt="Logo" style="height:80px; width:auto;">
                    </td>
                </tr>
            </table>
        </td>

        <!-- Kolom Tengah (SOP) -->
        <td style="width:50%; padding:0; vertical-align:top;">
            <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:100px;">
                <tr>
                    <td style="text-align:center; padding:8px 2px; font-weight:bold; font-size:17px; border-bottom:1px solid #000; height:58px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">
                        STANDARD OPERATING <br>
                        PROCEDURE<br>
                        IT &amp; SI DEPARTMENT
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-size:10px; padding:4px; height:25px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">
                        Dilarang memperbanyak dan/atau mempergunakan dokumen ini<br>
                        tanpa ijin tertulis dari PT. Adijaya Karya Makmur
                    </td>
                </tr>
            </table>
        </td>

        <!-- Kolom Kanan (Kode Dokumen) -->
        <td style="width:25%; padding:0; vertical-align:top;">
            <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:100px;">
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:12px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">ITSI.AKM/SOP.01/2025</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL : {{ $finding->tanggal_dokumen ? strtoupper(\Carbon\Carbon::parse($finding->tanggal_dokumen)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:28px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: {{ $finding->tanggal_expired ? strtoupper(\Carbon\Carbon::parse($finding->tanggal_expired)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; color:#fff; font-size:17px; font-family:'Calibri', sans-serif; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR FINDING
</div>

<!-- CONTAINER HEADER + DETAIL ASSET -->
<div style="width:90%; margin:auto;">
    <!-- HEADER FORMULIR -->
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <!-- Kolom Kiri -->
            <td style="width:25%; padding:0; vertical-align:top;">
                <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:45px;">
                    <tr>
                        <td style="text-align:center; vertical-align:middle; border-bottom:0.5px solid #000; padding:3px; height:45px;">
                            <img src="{{ realpath('image/logo_AKM.png') }}" alt="Logo" style="height:45px; width:auto; transform:scale(1.1);">
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Kolom Tengah -->
            <td style="width:50%; padding:0; vertical-align:top;">
                <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:45px;">
                    <tr>
                        <td style="text-align:center; padding:3px 2px; font-weight:bold; font-size:15px; font-family:'Calibri', sans-serif; border-bottom:0.5px solid #000; height:45px;">
                            FINDING FORM
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Kolom Kanan -->
            <td style="width:25%; padding:0; vertical-align:top;">
                <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:45px;">
                    <tr>
                        <td style="text-align:center; font-weight:bold; font-size:15px; font-family:'Calibri', sans-serif; padding:3px; height:45px;">
                            IT <br> SI
                        </td>
                    </tr>
                </table>
            </td>
            </tr> <!-- Tutup baris header -->

            <!-- Baris baru untuk tabel informasi -->
            <tr>
                <td colspan="3" style="padding:0; vertical-align:top;">
                    <table style="border:1px solid #000; border-collapse:collapse; font-size:13px; font-family:'Calibri', sans-serif; width:25%; margin-left:auto;">
                        <tr>
                            <td style="border:1px solid #000; padding:3px; width:35%; font-size:8px; font-weight:500;">NO. DOC</td>
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/FD.01/2025</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">EXPIRED</td>
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">EX-2029</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">TANGGAL</td>
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tr>
    </table>

    <br>

    <!-- NAMA DEPARTEMEN -->
    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="width:30%; padding:2px; font-weight:bold;">NAMA DEPARTEMEN</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                {{ $finding->nama_departemen ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- LOKASI TEMUAN -->
    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="width:30%; padding:2px; font-weight:bold;">LOKASI TEMUAN</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                {{ $finding->lokasi_temuan ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- TANGGAL PENEMUAN -->
    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="width:30%; padding:2px; font-weight:bold;">TANGGAL PENEMUAN</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                {{ $finding->tanggal_penemuan ? \Carbon\Carbon::parse($finding->tanggal_penemuan)->translatedFormat('d F Y') : '-' }}
            </td>
        </tr>
    </table>

<div style="margin-bottom:10px;"></div>

    <!-- JUDUL TEMUAN -->
    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">JUDUL TEMUAN</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ $finding->judul_temuan ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- DESKRIPSI TEMUAN -->
    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">DESKRIPSI TEMUAN</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:40px; font-weight:normal; vertical-align:top;">
                {{ $finding->deskripsi_temuan ?? '-' }}
            </td>
        </tr>
    </table>

<div style="margin-bottom:10px;"></div>

<!-- FORM READINESS TERKAIT -->
<table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">FORM READINESS TERKAIT</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; font-weight:normal; vertical-align:top;">
            {{ $finding->form_readiness_terkait ?? '-' }}
        </td>
    </tr>
</table>

<!-- TANGGAL FORM READINESS -->
<table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">TANGGAL FORM READINESS</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; font-weight:normal; vertical-align:top;">
            {{ $finding->tanggal_form_readiness ? \Carbon\Carbon::parse($finding->tanggal_form_readiness)->translatedFormat('d F Y') : '-' }}
        </td>
    </tr>
</table>

<!-- BUKTI TEMUAN -->
<table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">BUKTI TEMUAN</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="padding:0; font-weight:normal; vertical-align:top;">
            <table style="border-collapse:collapse; width:100%; font-size:9px; font-family:'Calibri', sans-serif;">
                <tr style="background-color:#000; color:#fff; font-weight:bold; text-align:center;">
                    <td style="border:1px solid #000; text-align:center; width:50%;">FOTO</td>
                    <td style="border:1px solid #000; text-align:center; width:50%;">TEKS</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; height:65px; text-align:center; vertical-align:middle; background:#fff; color:#000;">
                        @if($finding->bukti_temuan_foto)
                            <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                                @php
                                    $fileName = basename($finding->bukti_temuan_foto); // ambil nama file saja
                                @endphp
                                <a href="{{ asset('storage/' . $finding->bukti_temuan_foto) }}" target="_blank" style="font-size:8px;">
                                    {{ $fileName }}
                                </a>
                            </div>
                        @else 
                            -
                        @endif
                    </td>
                    <td style="border:1px solid #000; padding:4px; vertical-align:top; font-weight:normal; background:#fff; color:#000;">
                        {{ $finding->bukti_temuan_text ?? '-' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div style="margin-bottom:10px;"></div>

<!-- ANALISIS TEMUAN -->
<table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">ANALISIS TEMUAN</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="padding:0; vertical-align:top;">
            <table style="border-collapse:collapse; width:100%; font-size:9px; font-family:'Calibri', sans-serif;">
                <tr style="background:#000; color:#fff; font-weight:bold; text-align:center;">
                    <td style="border:1px solid #000; width:50%;">PENYEBAB</td>
                    <td style="border:1px solid #000; width:50%;">DAMPAK</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:6px; vertical-align:top; font-weight:normal; height:65px; background:#fff; color:#000;">
                        {{ $finding->analisis_penyebab ?? '-' }}
                    </td>
                    <td style="border:1px solid #000; padding:6px; vertical-align:top; font-weight:normal; height:65px; background:#fff; color:#000;">
                        {{ $finding->analisis_dampak ?? '-' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div style="margin-bottom:10px;"></div>

<!-- TINDAKAN SEMENTARA -->
<table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">TINDAKAN SEMENTARA</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; height:40px; font-weight:normal; vertical-align:top;">
            {{ $finding->tindakan_sementara ?? '-' }}
        </td>
    </tr>
</table>

<!-- TINDAKAN PERBAIKAN -->
<table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">TINDAKAN PERBAIKAN</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; height:40px; font-weight:normal; vertical-align:top;">
            {{ $finding->tindakan_perbaikan ?? '-' }}
        </td>
    </tr>
</table>

<!-- PENANGGUNG JAWAB TINDAKAN -->
<table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">PENANGGUNG JAWAB TINDAKAN</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; font-weight:normal; vertical-align:top;">
            {{ $finding->penanggung_jawab_tindakan ?? '-' }}
        </td>
    </tr>
</table>

<!-- TARGET WAKTU PENYELESAIAN -->
 <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">TARGET WAKTU PENYELESAIAN</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; font-weight:normal; vertical-align:top;">
            {{ $finding->target_waktu_penyelesaian ? \Carbon\Carbon::parse($finding->target_waktu_penyelesaian)->translatedFormat('d F Y') : '-' }}
        </td>
    </tr>
</table>

<div style="margin-bottom:10px;"></div>

<!-- STATUS FOLLOW-UP -->
 <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">STATUS FOLLOW-UP</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; font-weight:normal; vertical-align:top;">
            {{ ucfirst($finding->status_follow_up) ?? '-' }}
        </td>
    </tr>
</table>

<!-- TANGGAL VERIFIKASI -->
 <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">TANGGAL VERIFIKASI</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; font-weight:normal; vertical-align:top;">
            {{ $finding->tanggal_verifikasi ? \Carbon\Carbon::parse($finding->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}
        </td>
    </tr>
</table>

<!-- HASIL VERIFIKASI -->
 <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
    <tr>
        <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">HASIL VERIFIKASI</td>
        <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
        <td style="border:1px solid #000; padding:6px; font-weight:normal; vertical-align:top;">
            {{ $finding->hasil_verifikasi ?? '-' }}
        </td>
    </tr>
</table>
</div>

<!-- STRIP MERAH BAWAH -->
<div class="footer">
    IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
</div>

{{-- Link sumber di luar footer --}}
<div style="position: fixed; font-size:11px; bottom:-12px; font-family:'Calibri', sans-serif;">
    <span>Sumber: </span>
    <a href="{{ asset('storage/pdf/Finding Form_' . $finding->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
        Finding Form_{{ $finding->id }}.pdf
    </a>
</div>

<style>
    .footer {
    position: fixed;
    bottom: 5px; /* beri jarak dari bawah supaya link tidak tertutup */
    left: 0;
    width: 100%;
    background: #4a0404ff;
    color: #fff;
    text-align: center;
    font-weight: bold;
    padding: 4px;
    font-size: 14px;
    font-family:'Calibri', sans-serif;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}

    @media print {
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>