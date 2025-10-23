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
                    <td style="text-align:center; font-size:10px; padding:4px; line-height:1.2; height:25px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">
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
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL : {{ $requestData->tanggal_dokumen ? strtoupper(\Carbon\Carbon::parse($requestData->tanggal_dokumen)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:28px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: {{ $requestData->tanggal_expired ? strtoupper(\Carbon\Carbon::parse($requestData->tanggal_expired)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; font-size:17px; font-family:'Calibri', sans-serif; color:#fff; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR PERMINTAAN ASSET IT
</div>

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
                            ASSET REQUEST FORM (IT)
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
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/RA.01/2025</td>
                        </tr>

                            <!-- untuk no dokument otomatis -->
                        <!-- <tr>
                            <td style="border:0.5px solid #000; padding:3px; width:50%; font-size:10px; font-weight:500;">NO. DOC</td>
                            <td style="border:0.5px solid #000; padding:3px; font-size:10px; font-weight:500;">
                                {{-- {{ 'ITSI-AKM/RA.' . str_pad($form->id, 2, '0', STR_PAD_LEFT) . '/' . date('Y', strtotime($form->tanggal)) }} --}}
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

    @if($requestData->new_asset_number)
    <table style="width:35%; border:1px solid #000; border-collapse:collapse; font-family:'Calibri', sans-serif; font-size:12px; margin-bottom:1px;">
        <tr>
            <td style="text-align:center; padding:6px;">
                {{ $requestData->new_asset_number }}
            </td>
        </tr>
    </table>
    @endif


    <!-- Bagian Asset -->
    <table style="width:100%; border-collapse:separate; border-spacing:0 6px; font-family:'Calibri', sans-serif; sans-serif; font-size:12px; margin-top:50px;">
        <tr>
            <td style="width:30%; padding:6px 0;">Tipe Request</td>
            <td style="width:30px; text-align:center; padding:6px 0;">:</td>
            <td style="padding:6px 0;">
                {{ $requestData->request_type ?? '-' }}
                @if(!empty($requestData->request_type_extra) && $requestData->request_type == 'Replacement ( refer to doc FP3IT)')
                    : {{ $requestData->request_type_extra }}
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding:6px 0;">Request Ref Num</td>
            <td style="text-align:center; padding:6px 0;">:</td>
            <td style="padding:6px 0;">{{ $requestData->request_ref_num ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding:6px 0;">NIK</td>
            <td style="text-align:center; padding:6px 0;">:</td>
            <td style="padding:6px 0;">{{ $requestData->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding:6px 0;">Departemen</td>
            <td style="text-align:center; padding:6px 0;">:</td>
            <td style="padding:6px 0;">{{ $requestData->dept ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding:6px 0;">Section</td>
            <td style="text-align:center; padding:6px 0;">:</td>
            <td style="padding:6px 0;">{{ $requestData->section ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding:6px 0;">Tipe Asset</td>
            <td style="text-align:center; padding:6px 0;">:</td>
            <td style="padding:6px 0;">{{ $requestData->asset_type ?? '-' }}</td>
        </tr>
        <!-- DETAIL REQUEST -->
        <tr>
            <td style="vertical-align:top; padding:6px 0;">Detail Request</td>
            <td style="width:30px; text-align:center; vertical-align:top; padding:6px 0;">:</td>
            <td style="padding:6px 0;">
            </td>
        </tr>
    </table>
    @if(!empty($requestData->details) && is_array($requestData->details))
            <table style="width:100%; border-collapse:collapse; font-family:'Calibri', sans-serif; sans-serif; font-size:12px; margin-top:5px;">
                <thead>
                    <tr>
                        <td colspan="2" style="border:1px solid #000; padding:6px; text-align:center;">Nama Asset</td>
                        <td rowspan="2" style="border:1px solid #000; padding:4px; text-align:center;">Qty</td>
                        <td rowspan="2" style="border:1px solid #000; padding:4px; text-align:center;">User / PIC</td>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000; padding:6px; text-align:center;">Brand</td>
                        <td style="border:1px solid #000; padding:6px; text-align:center;">Model</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requestData->details as $item)
                        <tr>
                            <td style="border:1px solid #000; padding:6px;">{{ $item['brand'] ?? '-' }}</td>
                            <td style="border:1px solid #000; padding:6px;">{{ $item['model'] ?? '-' }}</td>
                            <td style="border:1px solid #000; padding:6px; text-align:center;">{{ $item['qty'] ?? '-' }}</td>
                            <td style="border:1px solid #000; padding:6px;">{{ $item['user_pic'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            -
        @endif

        <!-- TANDA TANGAN TERPISAH -->
        <table style="width:100%; margin-top:100px; font-family:'Calibri', sans-serif; font-size:12px; text-align:center;">
            <tr>
                <!-- KOLOM 1 -->
                <td style="width:45%;">
                    <div style="margin-bottom:100px; font-weight:500;">Request By,</div>
                    <div style="margin-top:5px;">User</div>
                </td>

                <!-- KOLOM 2 -->
                <td style="width:45%;">
                    <div style="margin-bottom:100px; font-weight:500;">Responsible By,</div>
                    <div style="margin-top:5px;">Section Head</div>
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
    <a href="{{ asset('storage/pdf/Asset Request_' . $requestData->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
        Asset Request_{{ $requestData->id }}.pdf
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