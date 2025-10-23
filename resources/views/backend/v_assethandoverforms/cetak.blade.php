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
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL : {{ $form->tanggal_dokumen ? strtoupper(\Carbon\Carbon::parse($form->tanggal_dokumen)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:28px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: {{ $form->tanggal_expired ? strtoupper(\Carbon\Carbon::parse($form->tanggal_expired)->translatedFormat('d F Y')) : '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; font-size:17px; font-family:'Calibri', sans-serif; color:#fff; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR SERAH TERIMA ASSET IT
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
                        <td style="text-align:center; vertical-align:middle; border-bottom:0.5px solid #000; padding:3px; height:45px; line-height:1.1;">
                            <img src="{{ realpath('image/logo_AKM.png') }}" alt="Logo" style="height:45px; width:auto; transform:scale(1.1);">
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Kolom Tengah -->
            <td style="width:50%; padding:0; vertical-align:top;">
                <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:45px;">
                    <tr>
                        <td style="text-align:center; padding:3px 2px; font-weight:bold; font-size:15px; font-family:'Calibri', sans-serif; border-bottom:0.5px solid #000; height:45px; line-height:1.1; font-family:'Calibri', sans-serif;">
                            SERAH TERIMA ASSET IT
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Kolom Kanan -->
            <td style="width:25%; padding:0; vertical-align:top;">
                <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:45px;">
                    <tr>
                        <td style="text-align:center; font-weight:bold; font-size:15px; font-family:'Calibri', sans-serif; padding:3px; height:45px; line-height:1.1; font-family:'Calibri', sans-serif;">
                            IT <br> SI
                        </td>
                    </tr>
                </table>
            </td>
            </tr> <!-- Tutup baris header -->

            <!-- Baris baru untuk tabel informasi -->
            <tr>
                <td colspan="3" style="padding:0; vertical-align:top;">
                    <table style="border:1px solid #000; border-collapse:collapse; font-size:13px; width:25%; margin-left:auto; line-height:1.1; font-family:'Calibri', sans-serif;">
                        <tr>
                            <td style="border:1px solid #000; padding:3px; width:35%; font-size:8px; font-weight:500;">NO. DOC</td>
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/ST.01/2025</td>
                        </tr>
                        <!-- untuk no dokument otomatis -->
                                <!-- <tr>
                                    <td style="border:0.5px solid #000; padding:3px; width:50%; font-size:10px; font-weight:500;">NO. DOC</td>
                                    <td style="border:0.5px solid #000; padding:3px; font-size:10px; font-weight:500;">
                                      {{-- {{ 'ITSI-AKM/ST.' . str_pad($form->id, 2, '0', STR_PAD_LEFT) . '/' . date('Y', strtotime($form->tanggal)) }} --}}
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
    <!-- Teks EULA di bawah tabel -->
    <div style="width:100%; text-align:right; margin-top:3px;">
        <div style="display:inline-block; text-align:left; font-size:9px; font-family:'Calibri', sans-serif; font-style:italic; color: rgba(0,0,0,0.7);">
            **Saya bersedia tunduk dan patuh<br>
            dengan EULA Asset Management System<br>
            (Terlampir)
        </div>
    </div>

    <!-- Bagian User -->
    <h5 style="font-style: italic; font-size:10px; font-family:'Calibri', sans-serif; color: rgba(0,0,0,0.3); margin-bottom:3px;">
        **Bagian ini di isi oleh user
    </h5>
        <table style="width:100%; border-collapse:collapse; font-family:'Calibri', sans-serif; sans-serif; font-size:12px;">
            <tr style="line-height:2;">
                <td style="width:25%; padding:4px 8px;">Nama</td>
                <td style="width:30px; text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->nama_user }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">NIK</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->nik_user }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Dept</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->dept }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Section</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->section }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Tanggal</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">
                    {{ \Carbon\Carbon::parse($form->tanggal)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

    <!-- Signature / Tanda Tangan User -->
    <div style="width:100%; display:flex; margin-bottom:10px;">
        <div style="text-align:center; width:150px; margin-left:auto;">
            <!-- Tulisan Sign Here -->
            <div style="font-style: italic; font-size:10px; font-family:'Calibri', sans-serif; color: rgba(0,0,0,0.3); margin-bottom:3px;">
                Sign Here
            </div>
            <!-- Garis tanda tangan -->
            <div style="border-bottom:1px solid #000; height:1px;"></div>
        </div>
    </div>


    <!-- Bagian IT Staff -->
    <div class="section">
        <h5 style="font-style: italic; font-size:10px; margin-top:70px; font-family:'Calibri', sans-serif; color: rgba(0,0,0,0.3); margin-bottom:3px;">
            **Bagian ini di isi IT staff
        </h5>
        <table style="width:100%; border-collapse:collapse; font-family:'Calibri', sans-serif; sans-serif; font-size:12px;">
            <!-- Tipe Asset -->
            <tr style="line-height:2;">
                <td style="width:25%; padding:4px 8px;">Tipe Asset</td>
                <td style="width:30px; text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">
                    {{ $form->tipe_asset }}
                </td>
            </tr>

            <!-- Tipe Penyerahan -->
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Tipe Penyerahan</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">
                    {{ $form->handover_type }}
                </td>
            </tr>

            <!-- Data Asset Lainnya -->
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Nama Asset</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">
                    <span>Brand: {{ $form->brand_asset }}</span>
                    <span style="margin-left:15px;">Model: {{ $form->model_asset }}</span>
                </td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Tag Asset</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->asset_tag }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">S/N</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->asset_sn }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Referensi RL Acumatica</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->ref_rl_acumatica }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Diserahkan Oleh</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->handover_by }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">NIK</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">{{ $form->handover_by_nik }}</td>
            </tr>
            <tr style="line-height:2;">
                <td style="padding:4px 8px;">Tanggal Diserahkan</td>
                <td style="text-align:center; padding:4px 8px;">:</td>
                <td style="padding:4px 8px;">
                    {{ $form->handover_date ? \Carbon\Carbon::parse($form->handover_date)->translatedFormat('d F Y') : '-' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Signature / Tanda Tangan IT Staff -->
    <div style="width:100%; display:flex; margin-bottom:10px;">
        <div style="text-align:center; width:150px; margin-left:auto;">
            <div style="font-style: italic; font-size:10px; font-family:'Calibri', sans-serif; color: rgba(0,0,0,0.3); margin-bottom:3px;">
                Sign Here
            </div>
            <div style="border-bottom:1px solid #000; height:1px;"></div>
        </div>
    </div>
</div>

<!-- STRIP MERAH BAWAH -->
<div class="footer">
    IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
</div>

{{-- Link sumber di luar footer --}}
<div style="position: fixed; font-size:11px; bottom:-12px; font-family:'Calibri', sans-serif;">
    <span>Sumber: </span>
    <a href="{{ asset('storage/pdf/Asset Handover Form_' . $form->id . '.pdf') }}" 
       style="font-style:italic; color:blue; text-decoration:underline;">
        Asset Handover Form_{{ $form->id }}.pdf
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
        /* Hapus position absolute supaya footer mengikuti konten terakhir */
        width: 100%;
    }

    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
</style>
