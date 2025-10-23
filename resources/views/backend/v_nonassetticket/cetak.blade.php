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
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL : 15 OKTOBER 2025</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:28px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: 15 OKTOBER 2025</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; color:#fff; font-size:17px; font-family:'Calibri', sans-serif; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR PERMINTAAN LAYANAN
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
                            SERVICE REQUEST FORM
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
        </tr>
    </table>

    <br>
    <br>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="width:30%; padding:2px; font-weight:bold;">NAMA</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                {{ $nonAssetTicket->reporter_name ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="width:30%; padding:2px; font-weight:bold;">DEPARTEMEN</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                {{ $nonAssetTicket->department ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">LOKASI</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ $nonAssetTicket->location ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">KONTAK (TELP/WA)</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ $nonAssetTicket->contact ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">EMAIL</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ $nonAssetTicket->email ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="width:30%; padding:2px; font-weight:bold;">TANGGAL</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                {{ \Carbon\Carbon::parse($nonAssetTicket->reported_at)->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <br>
    <br>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">KATEGORI</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ $nonAssetTicket->category ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">SUBJEK</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ $nonAssetTicket->subject ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">DESKRIPSI</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:40px; font-weight:normal; vertical-align:top;">
                {{ $nonAssetTicket->description ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    @php
        $attachment = $nonAssetTicket->attachment 
            ? asset('storage/'.$nonAssetTicket->attachment) 
            : null;

        $filename = $nonAssetTicket->attachment 
            ? basename($nonAssetTicket->attachment) 
            : '-';
    @endphp

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">LAMPIRAN</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                @if ($attachment)
                    <a href="{{ $attachment }}" target="_blank" style="color:#0000EE; text-decoration:underline;">
                        {{ $filename }}
                    </a>
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <br>
    <br>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">ITEM NAME</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ optional($nonAssetTicket->asset)->item_name ?? '-' }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">JUMLAH USER TERDAMPAK</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
                {{ $nonAssetTicket->affected_users }}
            </td>
        </tr>
    </table>

    <div style="margin-bottom:5px;"></div>

    <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
        <tr>
            <td style="padding:2px; vertical-align:top; width:30%; font-weight:bold;">PRIORITAS</td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:6px; height:5px; font-weight:normal;">
               @switch($nonAssetTicket->priority)
                    @case('Critical')
                        Critical
                        @break
                    @case('High')
                        High
                        @break
                    @case('Medium')
                        Medium
                        @break
                    @case('Low')
                        Low
                        @break
                    @default
                        -
                @endswitch
        </td>
        </tr>
    </table>

<!-- STRIP MERAH BAWAH -->
<div class="footer">
    IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
</div>

{{-- Link sumber di luar footer --}}
<div style="position: fixed; font-size:11px; bottom:-12px; font-family:'Calibri', sans-serif;">
    <span>Sumber: </span>
    <a href="{{ asset('storage/pdf/Non Asset Ticket Form_' . $nonAssetTicket->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
        Non Asset Ticket Form_{{ $nonAssetTicket->id }}.pdf
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