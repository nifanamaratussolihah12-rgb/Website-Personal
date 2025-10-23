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
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL : {{ $transfer->tanggal_dokumen ? strtoupper(\Carbon\Carbon::parse($transfer->tanggal_dokumen)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:28px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: {{ $transfer->tanggal_expired ? strtoupper(\Carbon\Carbon::parse($transfer->tanggal_expired)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; font-size:17px; font-family:'Calibri', sans-serif; color:#fff; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR PERALIHAN ASSET IT
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
                            FORM PERALIHAN ASSET
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
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/PL.01/2025</td>
                        </tr>
                        <!-- untuk no dokument otomatis -->
                                <!-- <tr>
                                    <td style="border:0.5px solid #000; padding:3px; width:50%; font-size:10px; font-weight:500;">NO. DOC</td>
                                    <td style="border:0.5px solid #000; padding:3px; font-size:10px; font-weight:500;">
                                       {{-- {{ 'ITSI-AKM/PL.' . str_pad($form->id, 2, '0', STR_PAD_LEFT) . '/' . date('Y', strtotime($form->tanggal)) }} --}}
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
    
    <br>

    <!-- DETAIL ASSET -->
    <table style="border:1px solid #000; border-collapse:collapse; width:100%; font-size:10px; font-family:'Calibri', sans-serif; margin-top:10px;">
        <tr>
            <td style="border:1px solid #000; padding:4px; width:30%; font-weight:500;">TAG ASSET</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->asset_tag ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">NAMA ASSET, BRAND/MODEL</td>
            <td style="border:1px solid #000; padding:4px;">
                {{ $transfer->asset_brand ?? '-' }} / {{ $transfer->asset_model ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">KATEGORI</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->category ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">NOMOR SERI</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->serial_number ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">TGL PEMBELIAN</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->purchase_date?->format('d-m-Y') ?? '-' }}</td>
        </tr>
        <tr>
           <td style="border:1px solid #000; padding:4px; font-weight:500;">HARGA PEMBELIAN</td>
            <td style="border:1px solid #000; padding:4px;">
                Rp. {{ number_format($transfer->purchase_price, 0, ',', '.') ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">STATUS GARANSI</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->warranty_status ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">TGL AKHIR GARANSI</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->warranty_end_date ? \Carbon\Carbon::parse($transfer->warranty_end_date)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
    </table>

    <!-- USER LAMA -->
    <table style="border:1px solid #000; border-collapse:collapse; width:100%; font-size:10px; font-family:'Calibri', sans-serif; margin-top:20px;">
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">DEPARTEMEN SEBELUMNYA</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->prev_department ?? '-' }}</td>
        </tr>    
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500; width:30%;">PENGGUNA SEBELUMNYA</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->prev_user ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">ALASAN PENGALIHAN</td>
            <td style="border:1px solid #000; padding:4px;">{{ $transfer->transfer_reason ?? '-' }}</td>
        </tr>
    </table>

    <!-- USER BARU -->
    <table style="border:1px solid #000; border-collapse:collapse; width:100%; font-size:10px; font-family:'Calibri', sans-serif; margin-top:20px;">
        <!-- Departemen Baru -->
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500; width:30%;">DEPARTEMEN BARU</td>
            <td style="border:1px solid #000; padding:4px;" colspan="2">{{ $transfer->new_department ?? '-' }}</td>
        </tr>

        <!-- Pengguna Baru -->
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">PENGGUNA BARU</td>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">{{ $transfer->new_user ?? '-' }}</td>
            <td style="border:1px solid #000; padding:20px; text-align:center; width:25%; position:relative;">
                <div style="position:absolute; top:2px; left:2px; font-size:7px; font-family:'Calibri', sans-serif; font-style:italic; color:#999;">SIGN HERE</div>
                &nbsp;
            </td>
        </tr>

        <!-- Tanggal Pengalihan -->
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">TANGGAL PENGALIHAN</td>
            <td style="border:1px solid #000; padding:4px;" colspan="2">{{ $transfer->transfer_date ? \Carbon\Carbon::parse($transfer->transfer_date)->translatedFormat('d F Y') : '-' }}</td>
        </tr>

        <!-- Lokasi Penempatan -->
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">LOKASI PENEMPATAN</td>
            <td style="border:1px solid #000; padding:4px;" colspan="2">{{ $transfer->placement_location ?? '-' }}</td>
        </tr>

        <!-- Kondisi Asset -->
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;">KONDISI ASSET</td>
            <td style="border:1px solid #000; padding:4px;" colspan="2">{{ $transfer->asset_condition ?? '-' }}</td>
        </tr>
    </table>

    <!-- TANDA TANGAN MENGGUNAKAN TABEL -->
    <table style="width:100%; margin:70px auto 0 auto; font-family:'Calibri', sans-serif; font-size:9px; border-collapse:collapse;">
        <tr>
            <!-- KOLOM 1 -->
            <td style="width:32%; text-align:center; vertical-align:top;">
                <div style="font-weight:500; margin-bottom:85px;">DEPT SEBELUMNYA</div>
                <div style="border-bottom:0.5px solid #000; height:5px; width:80%; margin:0 auto;"></div>
                <div style="margin-top:5px;">SECTION HEAD/SPV</div>
            </td>

            <!-- KOLOM 2 -->
            <td style="width:32%; text-align:center; vertical-align:top;">
                <div style="font-weight:500; margin-bottom:85px;">DEPT BARU</div>
                <div style="border-bottom:0.5px solid #000; height:5px; width:80%; margin:0 auto;"></div>
                <div style="margin-top:5px;">SECTION HEAD/SPV</div>
            </td>

            <!-- KOLOM 3 -->
            <td style="width:32%; text-align:center; vertical-align:top;">
                <div style="font-weight:500; margin-bottom:85px;">IT DEPT</div>
                <div style="border-bottom:0.5px solid #000; height:5px; width:80%; margin:0 auto;"></div>
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
    <a href="{{ asset('storage/pdf/Asset Transfer Form_' . $transfer->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
        Asset Transfer Form_{{ $transfer->id }}.pdf
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