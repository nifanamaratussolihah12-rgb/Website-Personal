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
                    <td style="border:1px solid #000; padding:3px; height:30px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL : 
                        {{ $form->tanggal_dokumen ? strtoupper(\Carbon\Carbon::parse($form->tanggal_dokumen)->translatedFormat('d F Y')) : '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:28px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: 
                        {{ $form->tanggal_expired ? strtoupper(\Carbon\Carbon::parse($form->tanggal_expired)->translatedFormat('d F Y')) : '-' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; color:#fff; font-size:17px; font-family:'Calibri', sans-serif; color:#fff; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR PERMINTAAN PERBAIKAN PERANGKAT IT (F3PIT)
</div>

<!-- CONTAINER HEADER + DETAIL ASSET -->
<div style="width:100%; margin:auto;">
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
                        <td style="text-align:center; padding:3px 2px; font-weight:bold; font-size:14px; font-family:'Calibri', sans-serif; border-bottom:0.5px solid #000; height:45px;">
                            FORM PERMINTAAN PERBAIKAN PERANGKAT <br>
                            IT (F3PIT)
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
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/F3.01/2025</td>
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

    <table style="border-collapse: collapse; width:100%;">
    <tr>
        {{-- ================== TABEL SEBELAH KIRI ================== --}}
        <td style="width:70%; vertical-align: top; border:1px solid #000;">

        <div style="margin-bottom:15px;"></div>

            <!-- NAMA DEPARTEMEN -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">DEPARTEMEN</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->departement ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- PIC -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">PIC</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->pic ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- JABATAN -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">JABATAN</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->jabatan ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- KODE INVENTARIS -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">KODE INVENTARIS</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->kode_inventaris ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- TAHUN PEROLEHAN -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">TAHUN PEROLEHAN</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->tahun_perolehan ? \Carbon\Carbon::parse($form->tahun_perolehan)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
            </table>

            <!-- JENIS INVENTARIS -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">JENIS INVENTARIS</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->jenis_inventaris ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- BRAND / TIPE -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">BRAND / TIPE</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->brand ?? '-' }} / {{ $form->tipe ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- S/N -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">S/N</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:6px; font-weight:normal;">
                        {{ $form->sn ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- SEJARAH PERBAIKAN -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">SEJARAH PERBAIKAN</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <!-- Inner table untuk isi -->
                    <table style="border-collapse:collapse; width:100%; font-size:10px;">
                        <tr>
                            <td style="border:1px solid #000; font-size:8px; padding:4px; font-weight:bold; width:17%; text-align:center;">TANGGAL</td>
                            <td style="border:1px solid #000; font-size:8px; padding:4px; font-weight:bold; width:28%; text-align:center;">KETERANGAN</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                                {{ $form->sejarah_tanggal ? \Carbon\Carbon::parse($form->sejarah_tanggal)->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                                {{ $form->sejarah_keterangan ?? '-' }}
                            </td>
                        </tr>
                    </table>
                </tr>
            </table>

            <!-- DESKRIPSI PERMASALAHAN -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">DESKRIPSI PERMASALAHAN</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:4px; font-size:10px; font-weight:normal; vertical-align:top; min-height:80px;">
                        {{ $form->deskripsi_permasalahan ?? '-' }}
                    </td>
                </tr>
            </table>

            <!-- PENYEBAB KERUSAKAN -->
            <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:1px;">
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;">PENYEBAB KERUSAKAN</td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                        @if($form->penyebab_kerusakan_cetak && $form->penyebab_kerusakan_cetak != '-')
                            <ul style="margin:0; padding-left:8px;">
                                @foreach(explode(', ', $form->penyebab_kerusakan_cetak) as $item)
                                    <li style="margin-bottom:5px;">{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p style="margin:0;">-</p>
                        @endif
                    </td>
                </tr>

                @if($form->penyebab_kerusakan_notes)
                <tr>
                    <td style="width:33%; padding:2px; font-weight:bold; vertical-align:top;"></td>
                    <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                    <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top;">
                        Notes: {{ $form->penyebab_kerusakan_notes }}
                    </td>
                </tr>
                @endif
            </table>

            <div style="margin-bottom:1px;"></div>

            <!-- LANGKAH YANG SUDAH DILAKUKAN -->
            <div style="margin-top:1px; font-size:10px; font-family:'Calibri', sans-serif;">
                <div style="margin-bottom:5px; font-weight:bold;">LANGKAH YANG SUDAH<br>DILAKUKAN</div>
                <table style="border-collapse:collapse; width:95%; font-size:10px; font-family:'Calibri', sans-serif; margin-top:1px; margin-bottom:10px;">
                    @if(!empty($form->langkah_dilakukan_cetak))
                        @foreach($form->langkah_dilakukan_cetak as $item)
                            @if(!empty($item['setuju']) || !empty($item['notes']))
                                <!-- Label -->
                                <div style="font-weight:bold; font-family:'Calibri', sans-serif; margin-top:1px; margin-bottom:1px;">
                                    {{ $item['label'] }} :
                                </div>

                                <!-- Table berisi notes -->
                                <table style="border-collapse:collapse; width:95%; font-family:'Calibri', sans-serif; margin-top:2px; margin-bottom:5px;">
                                    <tr>
                                        <td style="border:1px solid #000; padding:4px; min-height:50px;">
                                            {{ $item['notes'] ?? '-' }}
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        @endforeach
                    @else
                        <div style="font-weight:bold; font-family:'Calibri', sans-serif; margin-top:1px; margin-bottom:1px;">
                            Tidak ada langkah dilakukan
                        </div>
                        <table style="border-collapse:collapse; width:95%; font-family:'Calibri', sans-serif; margin-top:2px; margin-bottom:5px;">
                            <tr>
                                <td style="border:1px solid #000; padding:4px; min-height:50px;">-</td>
                            </tr>
                        </table>
                    @endif
                </table>
            </div>
        </td>

        {{-- ================== TABEL SEBELAH KANAN ================== --}}
        <td style="width:30%; vertical-align: top; border:1px solid #000;">
            <table style="width: 100%; border-collapse: collapse; margin-top:15px; font-size:10px; font-family:'Calibri', sans-serif;">
                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    Kondisi Fisik Penyerahan Perangkat
                </div>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                            {{ $form->kondisi_fisik ?? '' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:5px;"></div>

                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    Prioritas Pengerjaan
                </div>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
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
                        </td>
                    </tr>
                </table>
                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif; padding-top:2px;">
                    Dengan ini pemohon, dan Dept. Head <br>
                    menyatakan bahwa kondisi yang <br>
                    dituliskan adalah sesuai dengan kondisi
                </div>

                <div style="margin-bottom:5px;"></div>

                <table style="width:100%; border-collapse: collapse; margin-top:5px; font-size:10px; font-family:'Calibri', sans-serif;">
                    <tr>
                        <td style="font-weight:bold; width:20%; padding-right:5px;">
                            Pemohon
                        </td>
                        <td style="border:1px solid #000; padding:4px 8px; font-weight:normal; vertical-align:top;">
                            {{ $form->pemohon ?? '' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:5px;"></div>

                <table style="width:100%; border-collapse: collapse; margin-top:5px; font-size:10px; font-family:'Calibri', sans-serif;">
                    <tr>
                        <td style="font-weight:bold; width:20%; padding-right:5px;">
                            Dept. Head
                        </td>
                        <td style="border:1px solid #000; padding:4px 8px; font-weight:normal; vertical-align:top; width:45%;">
                            {{ $form->dep_head ?? '' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:30px;"></div>

                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    ** Bagian ini diisi oleh IT Dept.
                </div>
                <br>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
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
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:10px;"></div>

                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    Diterima dan diperiksa fisik oleh :
                </div>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                            {{ $form->diterima_oleh ?? '' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:2px;"></div>

                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    Tanggal :
                </div>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                            {{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->translatedFormat('d F Y') : '-' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:2px;"></div>

                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    Garansi Sebelumnya :
                </div>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                            {{ $form->garansi_sebelumnya ? \Carbon\Carbon::parse($form->garansi_sebelumnya)->translatedFormat('d F Y') : '-' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:10px;"></div>

                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    Pemeriksaan teknis oleh :
                </div>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                            {{ $form->pemeriksaan_teknis_oleh ?? '' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:2px;"></div>

                @if(!empty($form->diputuskan_internal_it['setuju']))
                    <div style="font-weight:bold; margin-bottom:0px; font-family:'Calibri', sans-serif; margin-top:1px;">
                        Diputuskan Internal IT, dengan penggantian komponen :
                    </div>
                    <table style="border-collapse:collapse; width:95%; font-family:'Calibri', sans-serif; margin-bottom:1px; margin-top:2px;">
                        <tr>
                            <td style="border:1px solid #000; padding:4px; min-height:50px;">
                                {{ $form->diputuskan_internal_it['nama'] ?? '-' }}
                            </td>
                        </tr>
                    </table>
                @endif
                    
                @if(!empty($form->diputuskan_vendor['setuju']))
                    <div style="font-weight:bold; font-family:'Calibri', sans-serif; margin-top:1px; margin-bottom:2px; padding:0;">
                        Diputuskan diperbaiki ke Vendor :
                    </div>
                    <table style="border-collapse:collapse; width:95%; font-family:'Calibri', sans-serif; margin-bottom:10px; margin-top:2px;">
                        <tr>
                            <td style="border:1px solid #000; padding:4px; min-height:50px;">
                                {{ $form->diputuskan_vendor['nama'] ?? '-' }}
                            </td>
                        </tr>
                    </table>
                @endif

                <div style="margin-bottom:1px;"></div>

                <div style="margin-bottom:4px; font-weight:bold; font-family:'Calibri', sans-serif;">
                    Hasil Perbaikan diperiksa fisik oleh :
                </div>
                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                            {{ $form->hasil_diperiksa_oleh ?? '' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:2px;"></div>

                <table style="width:100%; border-collapse: collapse; margin-top:5px; font-size:10px; font-family:'Calibri', sans-serif;">
                    <tr>
                        <td style="font-weight:bold; width:20%; padding-right:5px;">
                            Tgl :
                        </td>
                        <td style="border:1px solid #000; padding:4px 8px; font-weight:normal; vertical-align:top;">
                            {{ $form->hasil_diperiksa_tgl ? \Carbon\Carbon::parse($form->hasil_diperiksa_tgl)->translatedFormat('d F Y') : '-' }}
                        </td>
                    </tr>
                </table>

                <div style="margin-bottom:2px;"></div>

                <table style="width:100%; border-collapse: collapse;">
                    <tr>
                        <td style="border:1px solid #000; padding:4px; font-weight:normal; vertical-align:top; min-height:80px;">
                            @if($form->sn_sesuai || $form->bukti_penggantian)
                                <ul style="margin:0; padding-left:12px;">
                                    @if($form->sn_sesuai)
                                        <li style="margin-bottom:5px;">S/N Sesuai</li>
                                    @endif
                                    @if($form->bukti_penggantian)
                                        <li style="margin-bottom:5px;">Ada Bukti Penggantian Komponen</li>
                                    @endif
                                </ul>
                            @else
                                <p style="margin:0;">-</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </table>
        </td>
    </tr>
</table>
    
</div>

<!-- STRIP MERAH BAWAH -->
<div class="footer">
    IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
</div>

{{-- Link sumber di luar footer --}}
<div style="position: fixed; font-size:10px; bottom:-12px; font-family:'Calibri', sans-serif;">
    <span>Sumber: </span>
    <a href="{{ asset('storage/pdf/F3PIT_' . $form->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
        F3PIT_{{ $form->id }}.pdf
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