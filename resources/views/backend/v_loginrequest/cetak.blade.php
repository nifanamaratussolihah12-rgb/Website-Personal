<!-- HEADER ATAS -->
<table style="width:100%; border-collapse:collapse; margin-bottom:5px;">
    <tr>
        <!-- Kolom Kiri (Logo + teks) -->
        <td style="width:25%; padding:0; vertical-align:top;">
            <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:100px;">
                <tr>
                    <td style="text-align:center; vertical-align:middle; border-bottom:1px solid #000; padding:4px; height:92px;">
                        <img src="{{ realpath('image/logo_AKM.png') }}" alt="Logo" style="height:80px; width:auto;">
                    </td>
                </tr>
            </table>
        </td>

        <!-- Kolom Tengah (SOP) -->
        <td style="width:50%; padding:0; vertical-align:top;">
            <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:100px;">
                <tr>
                    <td style="text-align:center; padding:8px 2px; font-weight:bold; font-size:15px; border-bottom:1px solid #000; height:50px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">
                        STANDARD OPERATING<br>
                        PROCEDURE<br>
                        IT &amp; SI DEPARTMENT
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-size:9px; padding:4px; height:25px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">
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
                    <td style="border:1px solid #000; padding:3px; height:27px; font-size:12px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">ITSI.AKM/SOP.01/2025</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:27px; font-size:10px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL: 
                        {{ $loginRequest->tanggal_dokumen ? strtoupper(\Carbon\Carbon::parse($loginRequest->tanggal_dokumen)->translatedFormat('d F Y')) : '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:25px; font-size:8px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: 
                        {{ $loginRequest->tanggal_expired ? strtoupper(\Carbon\Carbon::parse($loginRequest->tanggal_expired)->translatedFormat('d F Y')) : '-' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; color:#fff; font-size:17px; font-family:'Calibri', sans-serif; color:#fff; text-align:center; font-weight:bold; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR PERMINTAAN LOGIN EMAIL / INTERNET
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
                        <td style="text-align:center; padding:3px 2px; font-weight:bold; font-size:15px; font-family:'Calibri', sans-serif; border-bottom:0.5px solid #000; height:45px;">
                            FORM PERMINTAAN LOGIN EMAIL / INTERNET
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
                            <td style="border:1px solid #000; padding:3px; font-size:8px; font-weight:500;">ITSI-AKM/FPRL.01/2025</td>
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

    <!-- Bagian Atas -->
    <table style="width:100%; border:1px solid #000; border-collapse:collapse; height:85%;">
        <!-- Date/Tanggal -->
        <table style="border-collapse:collapse; width:90%; padding-top:15px; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:4px;">
            <tr>
                <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                    Date / Tanggal
                </td>
                <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                    {{ $loginRequest->tanggal ? \Carbon\Carbon::parse($loginRequest->tanggal)->translatedFormat('d F Y') : '-' }}
                </td>
            </tr>
            <tr>
                <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                    Branch / Cabang
                </td>
                <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                    {{ $loginRequest->cabang ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                    Company/Perusahaan
                </td>
                <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                    {{ $loginRequest->company_name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                    Type of Request /<br>Jenis Permintaan
                </td>
                <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
                <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                    @if($loginRequest->jenis_permintaan === 'email')
                        Email - {{ ucfirst($loginRequest->sub_jenis ?? '-') }}
                    @elseif($loginRequest->jenis_permintaan === 'internet')
                        Internet - {{ $loginRequest->sub_jenis ?? '-' }}
                    @else
                        -
                    @endif
                </td>
            </tr>
    </table>

    <br>

    <!-- Bagian tengah -->
    <table style=" border-collapse:collapse; width:90%; font-size:10px; font-family:'Calibri', sans-serif; margin-bottom:4px;">
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                First Name* / <br> Nama Depan*
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->nama_depan ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                Middle Name / <br> Nama Tengah
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->nama_tengah ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                Last Name* / <br> Nama Belakang*
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->nama_belakang ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                ID / NIK
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->nik ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                Email Address /<br> Alamat Email
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->alamat_email ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                Division / Divisi
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->divisi ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                Department
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->departemen ?? '-' }}
            </td>
        </tr>

        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                Note / Catatan
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="padding:1px 5px; font-weight:normal; vertical-align:top; font-size:9px;">
                briefly describe the purpose / use email / internet * (jelaskan secara singkat keperluan / menggunakan email / internet)
                <div style="border:1px solid #000; padding:2px; font-weight:normal; min-height:30px; margin-top:2px; font-size:9px;">
                    {{ $loginRequest->note ?? '-' }}
                </div>
            </td>
        </tr>
    </table>

    <!-- TTD (di luar tabel utama) -->
    <div style="width:100%; padding-top:1px; font-family:'Calibri', sans-serif; sans-serif; font-size:8px;">
        <table style="width:100%; border-collapse:collapse; text-align:center;">
            <tr>
                <!-- KIRI -->
                <td style="width:48%; vertical-align:top;">
                    <table style="width:100%; border-collapse:collapse; text-align:center;">
                        <tr>
                            <th style="border:1px solid #000; padding:2px;">Requested by<br>Pemohon oleh</th>
                            <th style="border:1px solid #000; padding:2px;">Approved by<br>Disetujui oleh</th>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; height:65px; vertical-align:bottom;">(__________________)</td>
                            <td style="border:1px solid #000; height:65px; vertical-align:bottom;">(__________________)</td>
                        </tr>
                    </table>
                </td>

                <!-- RENGGANG TENGAH -->
                <td style="width:4%;"></td>

                <!-- KANAN -->
                <td style="width:48%; vertical-align:top;">
                    <table style="width:100%; border-collapse:collapse; text-align:center;">
                        <tr>
                            <th style="border:1px solid #000; padding:2px;">Approved by<br>Disetujui oleh</th>
                            <th style="border:1px solid #000; padding:2px;">Approved by<br>Disetujui oleh</th>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; height:65px; vertical-align:bottom;">(__________________)</td>
                            <td style="border:1px solid #000; height:65px; vertical-align:bottom;">(__________________)</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Bagian bawah -->
    <table style="border-collapse:collapse; width:65%; font-size:9px; font-family:'Calibri', sans-serif; margin-bottom:2px; margin-top:-5px;">
            <h5 style="font-style: italic; font-family:'Calibri', sans-serif; color:#000000; margin-bottom:6px;">
                ** Bagian ini diisi IT staff
            </h5>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
                Acknowledge By /<br> Mengetahui
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:2px; font-weight:normal;">
                {{ $loginRequest->mengetahui ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
               Date Receipt/<br>Tanggal diterima
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->tanggal_diterima ? \Carbon\Carbon::parse($loginRequest->tanggal_diterima)->translatedFormat('d F Y') : '-' }}
            </td>
        </tr>
         <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
               Email Address /<br> Alamat Email
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->alamat_email_login ?? '-' }}
            </td>
        </tr>
        @php
            use Illuminate\Support\Str;
        @endphp
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
            Password<br>*Ganti untuk login
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->password ? Str::limit($loginRequest->password, 40, '...') : '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
               Effective Date /<br> Tanggal Effektif
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->tanggal_efektif ? \Carbon\Carbon::parse($loginRequest->tanggal_efektif)->translatedFormat('d F Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
               Created by /<br> Dibuat oleh
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->dibuat_oleh ?? '-' }}
            </td>
        </tr>
        <tr>
            <td style="width:100px; padding:2px 10px; font-weight:bold; text-align:right; vertical-align:top;">
               Created date /<br> Tanggal dibuat
            </td>
            <td style="width:20px; text-align:center; vertical-align:top; font-weight:bold;">:</td>
            <td style="border:1px solid #000; padding:4px; font-weight:normal;">
                {{ $loginRequest->tanggal_dibuat ? \Carbon\Carbon::parse($loginRequest->tanggal_dibuat)->translatedFormat('d F Y') : '-' }}
            </td>
        </tr>
    </table>
    <!-- Catatan IT Staff -->
    <div class="col-md-4 mb-2" style="margin-top: 1px; font-family:'Calibri', sans-serif;">
        <div style="width:62%; margin-left:21px;"> 
            <table style="width:100%; border:1px solid #000; border-collapse:collapse;">
                <tr>
                    <td style="border:1px solid #000; font-size:9px; height:30px; vertical-align:top; padding:5px;">
                        Note / Catatan : {{ $loginRequest->catatan ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Signature / Tanda Tangan IT Staff -->
    <div style="width:100%;">
        <div style="width:220px; margin-left:auto; text-align:center;">
            <div style="font-style: italic; font-size:10px; font-family:'Calibri', sans-serif; color:rgba(0,0,0,0.4); margin-bottom:2px;">
                Sign Here
            </div>
            <div style="position:relative; top:-4px; line-height:1;">
                (__________________)
            </div>
        </div>
    </div>
</table>
</div>

<!-- STRIP MERAH BAWAH -->
<div class="footer">
    IT & SI DEPARTMENT - PT.ADIJAYA KARYA MAKMUR 2025
</div>

{{-- Link sumber di luar footer --}}
<div style="position: fixed; font-size:10px; bottom:-12px; font-family:'Calibri', sans-serif;">
    <span>Sumber: </span>
    <a href="{{ asset('storage/pdf/Login Request_' . $loginRequest->id . '.pdf') }}" style="font-style:italic; color:blue; text-decoration:underline;">
        Login Request_{{ $loginRequest->id }}.pdf
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
    font-size: 12px;
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



<!-- HALAMAN 2 -->
   <!-- HEADER ATAS -->
<table style="width:100%; border-collapse:collapse; margin-bottom:5px;">
    <tr>
        <!-- Kolom Kiri (Logo + teks) -->
        <td style="width:25%; padding:0; vertical-align:top;">
            <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:100px;">
                <tr>
                    <td style="text-align:center; vertical-align:middle; border-bottom:1px solid #000; padding:4px; height:92px;">
                        <img src="{{ realpath('image/logo_AKM.png') }}" alt="Logo" style="height:80px; width:auto;">
                    </td>
                </tr>
            </table>
        </td>

        <!-- Kolom Tengah (SOP) -->
        <td style="width:50%; padding:0; vertical-align:top;">
            <table style="border:1px solid #000; width:100%; border-collapse:collapse; height:100px;">
                <tr>
                    <td style="text-align:center; padding:8px 2px; font-weight:bold; font-size:15px; border-bottom:1px solid #000; height:50px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">
                        STANDARD OPERATING<br>
                        PROCEDURE<br>
                        IT &amp; SI DEPARTMENT
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center; font-size:9px; padding:4px; height:25px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">
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
                    <td style="border:1px solid #000; padding:3px; height:27px; font-size:12px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">ITSI.AKM/SOP.01/2025</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:27px; font-size:11px; font-weight:bold; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">TANGGAL: 19 JANUARY 2025</td>
                </tr>
                <tr>
                    <td style="border:1px solid #000; padding:3px; height:25px; font-size:9px; line-height:1.1; font-family:'Calibri', sans-serif; color:#070744ff;">Document Expired: 19 JANUARY 2025</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- STRIP MERAH ATAS -->
<div style="background:#4a0404ff; color:#fff; text-align:center; font-weight:bold; font-family:'Calibri', sans-serif; padding:4px; margin:5px 0; 
            -webkit-print-color-adjust: exact; print-color-adjust: exact; height:25px;">
    FORMULIR PERMINTAAN LOGIN EMAIL / INTERNET
</div>


<!-- ISI SURAT PERNYATAAN -->
<div style="border:1px solid #000; font-family:'Calibri', sans-serif; font-size:10px; text-align:justify; padding:10px; line-height:1.4;">
    <div style="text-align:center; font-weight:bold; margin-bottom:5px; font-size:11px;">
        SURAT PERNYATAAN KEPAHUAN ATAS PERATURAN<br>
        DALAM PENGGUNAAN FASILITAS E-MAIL DAN INTERNET
    </div>

    Saya yang bertanda tangan di bawah ini menyatakan sudah mengerti dan memahami:

    <div style="padding-top:5px;"></div>

    <b>Peraturan Penggunaan Fasilitas E-mail dan Internet Yang Merupakan Bagian Dari Kebijakan Keamanan Informasi PT. ADIJAYA BERKAH MANDIRI Group yang isinya diantaranya :</b>
    <br>

    <ol style="margin:0; padding-left:20px;">
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Media dan jasa elektronik terutama digunakan untuk keperluan bisnis perusahaan. Penggunaan media
                elektronik (mengirim atau menerima) secara terbatas, kadang-kadang ataupun insidentil email digunakan
                untuk kepentingan pribadi, bukan untuk kepentingan bisnis dapat dimengerti dan diterima. Namun karyawan
                harus mempertimbangkan apakah tindakan tersebut dapat merusak reputasi ABM Group atau mempunyai konsekuensi
                hukum.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Segala pesan atau informasi yang dikirim dalam bentuk apapun, tidak boleh mengungkapkan kerahasiaan 
                atau kepemilikan ABM Group atau informasi pihak ketiga kecuali ada suatu persetujuan kerahasiaan yang ditandatangani antara 
                ABM Group dengan perusahaan penerima inform asli tersebut dan komunikasi tersebut adalah semata mata untuk keperluan bisnis.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Segala informasi yang dikirim atau diterima melalui internet atau email yang mengandung unsur 
                diskriminasi, pelecehan, pornografi, illegal, fitnah, atau bersifat ancaman, menghina terhadap 
                seseorang maupun kelompok, termasuk mengedarkan "Surat berantai" adalah sangat dilarang.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Media dan jasa elektronik tidak boleh digunakan untuk suatu tindakan yang menyebabkan 
                Trafik data atau kemacetan network/jaringan atau menghambat kemampuan orang lain untuk 
                mengakses dan menggunakan sistem. Karena besarnya volume data yang terkait dengan mengakses 
                suara atau gambar melalui internet (misalkan mendengarkan atau mendownload musik, melihat atau men-download gambar), 
                mengirimkan file besar (lebih dari 4-GB") melalui jaringan, kecuali ada pertimbangan bisnis yang spesifik atau mendapat 
                persetujuan tertulis dari managernya langsung. 
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Segala pesan atau informasi yang dikirimkan oleh seorang karyawan untuk satu orang atau lebih melalui 
                network/jaringan elektronik (misalnya email, internet, milis, online service) adalah pernyataan yang 
                dapat diindentifikasi dan dapat dikaitkan dengan ABM Group. Sekalipun beberapa user mencantumkan "penolakan" pribadi 
                dalam pesan elektroniknya, namun dapat dicatat akan tetap apa saja ada hubungannya dengan PT ABM Group, 
                dan pernyataannya masih memiliki hubungan secara hukum dengan ABM Group. Semua komunikasi yang dikirim kan oleh karyawan 
                lewat network/jaringan harus sesuai dengan hal ini dan Peraturan Perusahaan lainnya.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Segala usaha untuk membaca, melanggar privacy dan kerahasiaan email atau file staff ABM Group lainnya 
                Dengan cara membajak atau berusaha untuk menebak dan menggunakan password atau menggunakan login karyawan lain adalah DILARANG.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Penggunaan media elektronik ABM Group untuk keuntungan atau 
                memperoleh tambahan penghasilan pribadi, Adalah sangat DILARANG.    
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Setiap pelanggaran atas hal hal tersebut didalam peraturan keamanan informasi ini akan diberikan Surat Peringatan sesuai dengan 
                mekanisme besar kecilnya pelanggaran dengan mengacu kepada Peraturan Perusahaan Pasal tentang Pemberian Surat Peringatan.
            </li>
    </ol>

    <b>Pelanggaran yang ditatapkan berat</b><br>
    Dibawah ini adalah daftar pelanggaran yang dikatagorikan berat, 
    sehingga pelakunya dapat dikenakan pemutusan hubungan kerja:<br>

    <ol style="margin:0; padding-left:20px;">
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Melakukan Hacking/pembobolan informasi
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Penghapusan, penyebaran file/database/daftar pelanggan yang berkaitan langsung dengan bisnis.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Pengiriman/penyebaran informasi sensitif kepada pihak 
                lain yang tidak seharusnya menerima tanpa izin pimpinan perusahaan.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Penghasutan, menggunakan jasa pihak lain untuk melaksanakan tujuannya, 
                yang tidak bersesuaian dengan norma norma yang wajar
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Kelalaian yang mengakibatkan masuk dan menyebamnya Virus Komputer
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Dengan sengaja atau tidak sengaja menghilangkan File yang berisi 
                informasi sensitif atau penting bagi kegiatan Perusahaan
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Akses yang Tidak Semestinya oleh orang lain di PC/Laptop/Gadged anda ke situs Internet 
                yang berisi hal-hal yang merupakan pornografi, illegal, pelecehan, diskriminasi, 
                finah atau bersifat ancaman termasuk surat berantai.
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Meneruskan atau menyebarkan email yang berisi 
                pornografi, pelecehan, diskriminasi, fitnah atau bersifat ancaman, termasuk surat berantai
            </li>
            <li style="margin-bottom:6px; padding-left:5px; text-indent:-5px;">
                Menjalankan atau meng-Install Software/Hardware tanpa Izin dai IT, terutama Software 
                yang di ambil dari penyedia Download-Software Cuma-Cuma atau berbayar 
                (tidak mandapatkan konfirmasi dari IT terhadap Situs yang di Bolehkan untuk di Download)
            </li>
    </ol>

    Saya menandatangani surat pernyataan ini sebagai tanda saya sudah m engerti 
    konsekuensi yang akan saya dapatkan apabila saya melanggar peraturan tertulis ini.<br>

    <!-- Bagian tanda tangan -->
    <table style="width:100%; border:none; margin-top:1px;">
        <tr>
        <td style="border:none; text-align:left; padding-right:-90px;">
                ____________________<br>
                Tempat, Tanggal
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border:none; text-align:left; padding-top:25px;">
                ____________________________<br>
                Nama &amp; Jabatan
            </td>
        </tr>
    </table>
</div>