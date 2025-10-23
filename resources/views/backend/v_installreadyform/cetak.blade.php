<!-- HALAMAN 1 -->
<div class="page" style="position: relative; min-height: 287mm; box-sizing: border-box;">
    <!-- HEADER HALAMAN 1 -->
    <table class="print-header" style="width:100%; border-collapse:collapse; margin-bottom:5px;">
        <!-- HEADER ATAS -->
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
        FORMULIR READINESS/KESIAPAN INSTALASI IT
    </div>

    <!-- Konten HALAMAN 1 -->
    <div class="page-content" style="margin-top:10px; width:90%; margin:auto; page-break-after: always;">
    <!-- HEADER FORMULIR -->
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <!-- Kolom Kiri -->
             <td style="width:25%; padding:0; vertical-align:top;">
                <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:70px;"> <!-- Tinggi sama -->
                    <tr>
                        <td style="text-align:center; vertical-align:middle; border-bottom:0.5px solid #000; padding:3px; height:55px;">
                            <img src="{{ realpath('image/logo_AKM.png') }}" alt="Logo" style="height:45px; width:auto;  transform:scale(1.1);">
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Kolom Tengah -->
            <td style="width:50%; padding:0; vertical-align:top;">
                <table style="border:1.5px solid #000; width:100%; border-collapse:collapse; height:25px;">
                    <tr>
                        <td style="text-align:center; padding:3px 2px; font-weight:bold; font-size:15px; font-family:'Calibri', sans-serif; border-bottom:1.5px solid #000; height:30px;">
                            FORMULIR KESIAPAN INSTALASI IT
                        </td>
                    </tr>
                    <!-- Bagian catatan kecil di bawah -->
                        <tr>
                            <td style="text-align:center; font-size:9px; font-family:'Calibri', sans-serif; font-style: italic; padding:4px; line-height:1.2; height:15px;">
                                <strong>( READINESS FORM FOR IT INSTALLATION )</strong>
                            </td>
                        </tr>
                </table>
            </td>

            <!-- Kolom Kanan -->
            <td style="width:25%; padding:0; vertical-align:top;">
                <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:70px;">
                    <tr>
                        <td style="text-align:center; font-weight:bold; font-size:15px; font-family:'Calibri', sans-serif; padding:3px; height:55px;">
                            IT <br> SI
                        </td>
                    </tr>
                </table>
            </td>
            </tr> <!-- Tutup baris header -->

            <!-- Baris baru untuk tabel informasi -->
            <tr>
                <td colspan="3" style="padding:0; vertical-align:top;">
                    <table style="border:1px solid #000; border-collapse:collapse; font-size:13px; font-family:'Calibri', sans-serif; width:25%; margin-left:auto; margin-top:-6;">
                        <tr>
                            <td style="border:1px solid #000; padding:3px; width:35%; font-size:8px; font-weight:500;">NO. DOC</td>
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/RD.01/2025</td>
                        </tr>
                        <!-- untuk no dokument otomatis -->
                                <!-- <tr>
                                    <td style="border:0.5px solid #000; padding:3px; width:50%; font-size:10px; font-weight:500;">NO. DOC</td>
                                    <td style="border:0.5px solid #000; padding:3px; font-size:10px; font-weight:500;">
                                       {{-- {{ 'ITSI-AKM/RD.' . str_pad($form->id, 2, '0', STR_PAD_LEFT) . '/' . date('Y', strtotime($form->tanggal)) }} --}}
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

    <div style="margin-bottom:30px;"></div>

    <!-- Bagian Proyek -->
    <table style="border:1px solid #000; border-collapse:collapse; width:75%; font-size:11px; font-family:'Calibri', sans-serif; margin:10px 0;">
        <tr>
            <td style="border:1px solid #000; padding:4px; width:40%; font-weight:500;"><strong>PROJECT</strong></td>
            <td style="border:1px solid #000; padding:4px;"><strong>{{ $form->project ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;"><strong>LOKASI</strong></td>
            <td style="border:1px solid #000; padding:4px;"><strong>{{ $form->lokasi ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;"><strong>TANGGAL</strong></td>
            <td style="border:1px solid #000; padding:4px;">
                <strong>{{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->translatedFormat('d F Y') : '-' }}</strong>
            </td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:4px; font-weight:500;"><strong>TIM PELAKSANA</strong></td>
            <td style="border:1px solid #000; padding:4px;"><strong>{{ $form->tim_pelaksana ?? '-' }}</strong></td>
        </tr>
    </table>

    <!-- Checklist -->
    <div style="width:75%; font-family:'Calibri', sans-serif; font-size:11px; margin-top:20px; line-height:1.3;">
        <!-- Persiapan Awal -->
        <div style="margin-bottom:20px;"> <!-- Tambah jarak antar blok -->
            <strong style="display:block; margin-bottom:8px;">1. PERSIAPAN AWAL</strong>
            <div style="border:1px solid #000; min-height:80px; padding:10px; margin-top:5px; border-radius:4px;">
                @if(!empty($form->persiapan_awal))
                    <ul style="margin:0; padding-left:20px;">
                        @foreach($form->persiapan_awal as $task)
                            <li style="margin-bottom:5px;">{{ $task }}</li> <!-- Tambah jarak antar item -->
                        @endforeach
                    </ul>
                @else
                    <p style="margin:0;">-</p>
                @endif
            </div>
        </div>

        <!-- K3 -->
        <div style="margin-bottom:20px;">
            <strong style="display:block; margin-bottom:8px;">2. KESEHATAN & KESELAMATAN KERJA (K3)</strong>
            <div style="border:1px solid #000; min-height:80px; padding:10px; margin-top:5px; border-radius:4px;">
                @if(!empty($form->k3))
                    <ul style="margin:0; padding-left:20px;">
                        @foreach($form->k3 as $task)
                            <li style="margin-bottom:5px;">{{ $task }}</li>
                        @endforeach
                    </ul>
                @else
                    <p style="margin:0;">-</p>
                @endif
            </div>
        </div>

        <!-- Aspek Teknis -->
        <div style="margin-bottom:5px;">
            <strong style="display:block; margin-bottom:8px;">3. ASPEK TEKNIS</strong>
            <div style="border:1px solid #000; min-height:80px; padding:10px; margin-top:5px; border-radius:4px;">
                @if(!empty($form->aspek_teknis))
                    <ul style="margin:0; padding-left:20px;">
                        @foreach($form->aspek_teknis as $task)
                            <li style="margin-bottom:5px;">{{ $task }}</li>
                        @endforeach
                    </ul>
                @else
                    <p style="margin:0;">-</p>
                @endif
            </div>
        </div>
    </div>
    {{-- Footer merah + link --}}
    <div style="position:absolute; bottom:3; left:0; width:100%;">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="background:#4a0404ff; color:#fff; text-align:center; font-weight:bold; font-family:'Calibri', sans-serif; font-size:14px; padding:4px;">
                    IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
                </td>
            </tr>
        </table>

        {{-- Link sumber di bawah footer --}}
        <div style="text-align:left; font-size:11px; margin-top:5px; font-family:'Calibri', sans-serif;">
            <span>Sumber: </span>
            <a href="{{ asset('storage/pdf/Install Ready Form_' . $form->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
                Install Ready Form_{{ $form->id }}.pdf
            </a>
        </div>
    </div>
</div> 



    <!-- HALAMAN 2 -->
   <div class="page" style="display:flex; flex-direction:column; justify-content:space-between; box-sizing:border-box;">
        <!-- HEADER HALAMAN 2 -->
        <div class="page-content">
            <table class="print-header" style="width:100%; border-collapse:collapse; margin-bottom:5px;">
            <!-- HEADER ATAS -->
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
                            <td style="border:1px solid #000; padding:3px; height:30px; font-size:11px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL: 19 JANUARY 2025</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; padding:3px; height:28px; font-size:9px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: 19 JANUARY 2025</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- STRIP MERAH ATAS -->
        <div style="background:#4a0404ff; color:#fff; font-size:17px; text-align:center; font-weight:bold; font-family:'Calibri', sans-serif; padding:4px; margin:5px 0; 
                    -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
            FORMULIR READINESS/KESIAPAN INSTALASI IT
        </div>

        <!-- KONTEN HALAMAN KE 2 -->
        <div style="width:90%; margin:auto;">
            <!-- Checklist -->
            <div style="width:75%; font-family:'Calibri', sans-serif; font-size:11px; margin-top:70px; line-height:1.3;">
                <!-- Manajemen Project -->
                    <div style="margin-bottom:20px;">
                        <strong style="display:block; margin-bottom:8px;">4. MANAJEMEN PROJECT</strong>
                        <div style="border:1px solid #000; min-height:80px; padding:10px; margin-top:5px; border-radius:4px;">
                            @if(!empty($form->manajemen))
                                <ul style="margin:0; padding-left:20px;">
                                    @foreach($form->manajemen as $task)
                                        <li style="margin-bottom:5px;">{{ $task }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p style="margin:0;">-</p>
                            @endif
                        </div>
                    </div>

                    <!-- Pasca Project -->
                    <div style="margin-bottom:30px;">
                        <strong style="display:block; margin-bottom:8px;">5. PASCA PROJECT</strong>
                        <div style="border:1px solid #000; min-height:80px; padding:10px; margin-top:5px; border-radius:4px;">
                            @if(!empty($form->pasca))
                                <ul style="margin:0; padding-left:20px;">
                                    @foreach($form->pasca as $task)
                                        <li style="margin-bottom:5px;">{{ $task }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p style="margin:0;">-</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- TANDA TANGAN MENGGUNAKAN TABEL -->
                <table style="width:100%; margin:50px auto 0 auto; font-family:'Calibri', sans-serif; font-size:9px; border-collapse:collapse; text-align:center;">
                    <tr>
                        <!-- KOLOM 1 -->
                        <td style="width:22%;">
                            <div style="font-weight:500; margin-bottom:75px; width:80%;">IT DEPT</div>
                            <div style="border-bottom:1px solid #000; height:5px; width:80%;"></div>
                        </td>

                        <!-- KOLOM 2 -->
                        <td style="width:22%;">
                            <div style="font-weight:500; margin-bottom:75px; width:80%;">PLANT MTC/ELECTRICAL</div>
                            <div style="border-bottom:1px solid #000; height:5px; width:80%;"></div>
                        </td>

                        <!-- KOLOM 3 -->
                        <td style="width:22%;">
                            <div style="font-weight:500; margin-bottom:75px; width:80%;">HSE</div>
                            <div style="border-bottom:1px solid #000; height:5px; width:80%;"></div>
                        </td>

                        <!-- KOLOM 4 -->
                        <td style="width:22%;">
                            <div style="font-weight:500; margin-bottom:75px; width:80%;">SCM</div>
                            <div style="border-bottom:1px solid #000; height:5px; width:80%;"></div>
                        </td>
                    </tr>
                </table>

                <div class="col-md-12 mb-2" style="text-align: center; margin-top: 65px; font-family:'Calibri', sans-serif;">
                    <div style="display: inline-block; width:85%; text-align: center;"> <!-- ubah dari 60% ke 80% -->
                        <table style="width:100%; border:1px solid #000; border-collapse:collapse;">
                            <tr>
                                <td style="border:1px solid #000; font-size:9px; height:100px; vertical-align:top; padding:5px;">
                                    CATATAN TAMBAHAN: {{ $form->catatan ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>   
        </div> 
        {{-- Footer merah + link --}}
        <div style="position:absolute; bottom:3; left:0; width:100%;">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="background: #4a0404ff; color:#fff; text-align:center; font-weight:bold; font-family:'Calibri', sans-serif; font-size:14px; padding:4px;">
                        IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
                    </td>
                </tr>
            </table>

            {{-- Link sumber di bawah footer --}}
            <div style="text-align:left; font-size:11px; margin-top:5px; font-family:'Calibri', sans-serif;">
                <span>Sumber: </span>
                <a href="{{ asset('storage/pdf/Install Ready Form_' . $form->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
                    Install Ready Form_{{ $form->id }}.pdf
                </a>
            </div>
        </div>
    </div>

