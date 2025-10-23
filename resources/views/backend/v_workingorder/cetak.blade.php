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
                        PROCEDURE <br>
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
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL : {{ $order->tanggal_dokumen ? strtoupper(\Carbon\Carbon::parse($order->tanggal_dokumen)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:28px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: {{ $order->tanggal_expired ? strtoupper(\Carbon\Carbon::parse($order->tanggal_expired)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; font-size:17px; font-family:'Calibri', sans-serif; color:#fff; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR WORKING ORDER
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
                            INSTALASI & IMPLEMENTASI DOCUMENT
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
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/WO.01/2025</td>
                        </tr>
                            <!-- untuk no dokument otomatis -->
                        <!-- <tr>
                            <td style="border:0.5px solid #000; padding:3px; width:50%; font-size:10px; font-weight:500;">NO. DOC</td>
                            <td style="border:0.5px solid #000; padding:3px; font-size:10px; font-weight:500;">
                                {{--  {{ 'ITSI-AKM/WO.' . str_pad($form->id, 2, '0', STR_PAD_LEFT) . '/' . date('Y', strtotime($form->tanggal)) }}  --}}
                            </td>
                        </tr> -->
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

    <!-- DETAIL WORKING ORDER - USER -->
    <table style="border:1px solid #000; border-collapse:collapse; width:100%; font-size:11px; font-family:'Calibri', sans-serif; margin-top:10px;">
        <tr>
            <td style="border:1px solid #000; padding:6px; width:30%; font-weight:500;">NAMA</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">DIVISI</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->divisi ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">SECTION</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->section ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">PERMINTAAN</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->permintaan ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">JENIS PEKERJAAN</td>
            <td style="border:1px solid #000; padding:6px;">{{ ucfirst($order->jenis_pekerjaan) ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">LOKASI</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">DETAILS</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->details ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">DOKUMEN DITERIMA</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->dokumen_diterima ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; font-weight:500;">TARGET PENGERJAAN</td>
            <td style="border:1px solid #000; padding:6px;">{{ $order->target_pengerjaan ? \Carbon\Carbon::parse($order->target_pengerjaan)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
    </table>

    <!-- STRIP HITAM TENGAH -->
    <div style="background:#000000; color:#fff; text-align:center; font-weight:bold; padding:4px; margin:10px 0; 
            font-size:13px; font-family:'Calibri', sans-serif; /* ukuran lebih kecil */
            -webkit-print-color-adjust: exact; print-color-adjust: exact;">
    IT & SI PREPARATION CHECKLIST
    </div>

    <!-- IT & SI Preparation Checklist -->
    <table style="border:1px solid #000; border-collapse:collapse; width:100%; font-size:11px; font-family:'Calibri', sans-serif; margin-top:10px; text-align:center;">
        <thead>
            <tr>
                <th style="border:1px solid #000; padding:4px; width:40%;">TASK</th>
                <th style="border:1px solid #000; padding:4px; width:15%;">STATUS</th>
                <th style="border:1px solid #000; padding:4px; width:25%;">REASON</th>
                <th style="border:1px solid #000; padding:4px; width:20%;">SIGN</th>
            </tr>
        </thead>
        <tbody>
            {{-- 1. Kesiapan instalasi listrik --}}
            <tr>
                <td style="border:1px solid #000; padding:4px; text-align:left;">
                    Kesiapan instalasi listrik & ke-stabilan listrik
                </td>
                <td style="border:1px solid #000; padding:4px;">{{ ucfirst($order->status_kesiapan_listrik) ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->reason_kesiapan_listrik ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->sign_kesiapan_listrik ?? '-' }}</td>
            </tr>

            {{-- 2. Tiang --}}
            <tr>
                <td style="border:1px solid #000; padding:4px; text-align:left;">Tiang</td>
                <td style="border:1px solid #000; padding:4px;">{{ ucfirst($order->status_tiang) ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->reason_tiang ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->sign_tiang ?? '-' }}</td>
            </tr>

            {{-- 3. CCTV / Radio / Perangkat Jaringan --}}
            <tr>
                <td style="border:1px solid #000; padding:4px; text-align:left;">
                    {{ ucfirst($order->task_perangkat) ?? '-' }}
                </td>
                <td style="border:1px solid #000; padding:4px;">{{ ucfirst($order->status_perangkat) ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->reason_perangkat ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->sign_perangkat ?? '-' }}</td>
            </tr>

            {{-- 4. Panel --}}
            <tr>
                <td style="border:1px solid #000; padding:4px; text-align:left;">Panel</td>
                <td style="border:1px solid #000; padding:4px;">{{ ucfirst($order->status_panel) ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->reason_panel ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->sign_panel ?? '-' }}</td>
            </tr>

            @if(!empty($order->task_keselamatan))
            {{-- Baris pertama: Keselamatan Kerja --}}
            <tr>
                <td style="border:1px solid #000; padding:4px; text-align:left;">Keselamatan Kerja</td>
                <td style="border:1px solid #000; padding:4px;">{{ ucfirst($order->status_keselamatan[0] ?? '-') }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->reason_keselamatan[0] ?? '-' }}</td>
                <td style="border:1px solid #000; padding:4px;">{{ $order->sign_keselamatan[0] ?? '-' }}</td>
            </tr>

            {{-- Baris manual 1, 2, 3... --}}
            @foreach(($order->task_keselamatan ?? []) as $index => $task)
                <tr>
                    <td style="border:1px solid #000; padding:4px; text-align:left;">{{ ($index+1).'. '.$task }}</td>
                    <td style="border:1px solid #000; padding:4px;">{{ ucfirst($order->status_keselamatan[$index+1] ?? '-') }}</td>
                    <td style="border:1px solid #000; padding:4px;">{{ $order->reason_keselamatan[$index+1] ?? '-' }}</td>
                    <td style="border:1px solid #000; padding:4px;">{{ $order->sign_keselamatan[$index+1] ?? '-' }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <br>

     <!-- TABEL TANDA TANGAN TERPISAH -->
    <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:12px; text-align:center;">

        <!-- Header Panjang -->
        <tr>
            <td colspan="4" style="font-weight:bold; padding:2px; font-size:10px; font-family:'Calibri', sans-serif; border:1px solid #000; background:#fff;">
                Prepare & Approvals
            </td>
        </tr>
            <!-- Header tengah -->
            <tr style="height:100px;">
            <td style="width:25%; border:1px solid #000; vertical-align:top; text-align:center; padding-top:90px; font-size:10px;">
                <div style="font-weight:normal; font-family:'Calibri', sans-serif;">Pemohon,</div>
            </td>
            <td style="width:25%; border:1px solid #000; vertical-align:top; text-align:center; padding-top:90px; font-size:10px;">
                <div style="font-weight:normal; font-family:'Calibri', sans-serif;">IT Dept,</div>
            </td>
            <td style="width:25%; border:1px solid #000; vertical-align:top; text-align:center; padding-top:90px; font-size:10px;">
                <div style="font-weight:normal; font-family:'Calibri', sans-serif;">PJO,</div>
            </td>
            <td style="width:25%; border:1px solid #000; vertical-align:top; text-align:center; padding-top:90px; font-size:10px;">
                <div style="font-weight:normal; font-family:'Calibri', sans-serif;">Mengetahui,</div>
            </td>
    </table>
</div>

<!-- STRIP MERAH BAWAH -->
<div class="footer">
    IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
</div>

{{-- Link sumber di luar footer --}}
<div style="position: fixed; font-size:11px; bottom:-12px; font-family:'Calibri', sans-serif;">
    <span>Sumber: </span>
    <a href="{{ asset('storage/pdf/Working Order_' . $order->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
        Working Order_{{ $order->id }}.pdf
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