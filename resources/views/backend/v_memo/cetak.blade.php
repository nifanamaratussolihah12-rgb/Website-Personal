<div class="container" style="font-family: 'Times New Roman'; font-size: 11;">

    {{-- ========== LEMBAR PERTAMA: DISPOSISI ========== --}}
    <div class="page-break">
    <table style="width:100%; border:1px solid black; border-collapse: collapse;">
        <tr>
            <td style="border:1px solid black; text-align:center; font-weight:bold; padding:5px;">
                LEMBAR DISPOSISI
            </td>
        </tr>
        <tr>
            <td style="border:1px solid black; padding:15px 10px 10px 10px; position:relative;">
                <!-- Tanggal di kanan atas -->
                <div style="position:absolute; top:10px; right:10px; white-space:nowrap;">
                    TANGGAL : {{ \Carbon\Carbon::parse($memo->tanggal_disposisi)->format('d F Y') }}
                </div>

                <!-- Info di kiri -->
                <table style="border-collapse: collapse; margin-top:25px;">
                    <tr>
                        <td style="width:150px; padding:4px 5px;">TGL & NO. SURAT</td>
                        <td style="width:10px; padding:4px 5px;">:</td>
                        <td style="padding:4px 5px;">{{ $memo->tgl_no_surat }}</td>
                    </tr>
                    @php
                        $perihals = is_array($memo->perihal) ? $memo->perihal : json_decode($memo->perihal, true);
                    @endphp

                    <tr>
                        <td style="padding:4px 5px; vertical-align: top;">PERIHAL</td>
                        <td style="padding:4px 5px; vertical-align: top;">:</td>
                        <td style="padding:4px 5px;">
                            @foreach($perihals as $index => $p)
                                @if($index == 0)
                                    {{ $p }}
                                @else
                                    <br>{{ $p }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:4px 5px;">LAMPIRAN</td>
                        <td style="padding:4px 5px;">:</td>
                        <td style="padding:4px 5px;">{{ $memo->lampiran }}</td>
                    </tr>
                    <tr>
                        <td style="padding:4px 5px;">DARI</td>
                        <td style="padding:4px 5px;">:</td>
                        <td style="padding:4px 5px;">{{ $memo->dari_disposisi }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width:100%; border:1px solid black; border-collapse: collapse; margin-top:-1px;">
        <thead>
            <tr>
                <th style="border:1px solid black; padding:5px; text-align:center; font-weight: normal; font-size:13px;">TUJUAN</th>
                <th style="border:1px solid black; padding:5px; text-align:center; font-weight: normal; font-size:12px;"></th>
                <th style="border:1px solid black; padding:5px; text-align:center; font-weight: normal; font-size:13px;">KETERANGAN</th>
            </tr>
        </thead>
        @php
            // pastikan disposisi selalu array
            $disposisi = is_array($memo->disposisi) ? $memo->disposisi : json_decode($memo->disposisi, true);
        @endphp

        <tbody>
            {{-- Disposisi Atas --}}
            @if(!empty($disposisi['atas']))
                @foreach($disposisi['atas'] as $row)
                    <tr>
                        <td style="border:1px solid black; padding:5px; width:32%;">{{ $row['tujuan'] ?? '' }}</td>
                        <td style="border:1px solid black; padding:5px; text-align:center; width:8%;">{{ $row['status'] ?? '' }}</td>
                        <td style="border:1px solid black; padding:5px; width:60%;">{{ $row['keterangan'] ?? '' }}</td>
                    </tr>
                @endforeach
            @endif

            {{-- Baris DITERUSKAN --}}
            <tr>
                <th colspan="3" style="border:1px solid black; padding:5px; font-weight: normal; font-size:13px; text-align: left;">
                    DITERUSKAN
                </th>
            </tr>

            {{-- Disposisi Bawah --}}
            @if(!empty($disposisi['bawah']))
                @foreach($disposisi['bawah'] as $row)
                    <tr>
                        <td style="border:1px solid black; padding:5px; width:32%;">{{ $row['tujuan'] ?? '' }}</td>
                        <td style="border:1px solid black; padding:5px; text-align:center; width:8%;">{{ $row['status'] ?? '' }}</td>
                        <td style="border:1px solid black; padding:5px; width:60%;">{{ $row['keterangan'] ?? '' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>


    {{-- ========== LEMBAR KEDUA: MEMO ========== --}}
    <div class="page-break">
        <div style="text-align:center; font-weight:bold; font-size:20px; margin-bottom:12px;">
            MEMO
        </div>

        <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
            <tr>
                <td style="padding:4px 5px; white-space: nowrap;">
                    {{ $memo->lokasi_memo }}, {{ \Carbon\Carbon::parse($memo->tanggal_memo)->format('d F Y') }}
                </td>
            </tr>
            <br>
            <tr>
                <td style="width:100px; padding:4px 2px; font-size:13px;">NOMOR</td>
                <td style="width:5px; padding:4px 2px;">:</td>
                <td style="padding:4px 5px;">{{ $memo->nomor }}</td>
            </tr>
            <tr>
                <td style="width:100px; padding:4px 2px; font-size:13px;">KEPADA</td>
                <td style="width:5px; padding:4px 2px;">:</td>
                <td style="padding:4px 5px;">{{ $memo->kepada }}</td>
            </tr>
            <tr>
                <td style="width:100px; padding:4px 2px; font-size:13px;">DARI</td>
                <td style="width:5px; padding:4px 2px;">:</td>
                <td style="padding:4px 5px;">{{ $memo->dari_memo }}</td>
            </tr>
            <tr>
                <td style="width:100px; padding:4px 2px; font-size:13px;"><strong>PERIHAL</strong></td>
                <td style="width:5px; padding:4px 2px;">:</td>
                <td style="padding:4px 5px;"><strong>{{ $memo->perihal_memo }}</strong></td>
            </tr>
        </table>

        <div class="real-line"></div>
        <style>
        .real-line {
            border-bottom: 1px solid #000; /* garis lurus tipis */
            margin: 10px 0; /* jarak atas bawah */
        }
        </style>

        <div style="margin-top:15px;"></div>

        <p>Sehubungan dengan Memo tersebut diatas, bersama ini kami sampaikan perihal, sebagai berikut:</p>
        <div style="margin-top:15px;"></div>

        <div style="padding: 0 20px;">
            <div class="memo-content">
                {!! $memo->isi !!}
            </div>
        </div>

        <style>
        .memo-content ul,
        .memo-content ol {
            padding-left: 40px; /* indent list */
        }
        .memo-content p {
            margin: 0 0 10px 0; /* jarak antar paragraf */
        }
        </style>
        
        <div style="margin-top:15px;"></div>
        <p>Demikian pengajuan ini kami sampaikan, Terima Kasih</p>
        <div style="margin-top:15px;"></div>

        <p>Hormat kami</p>

    <!-- Tabel TTD di bawah -->
    <table style="width:100%; text-align:center; margin-top:100px;">
        <tr>
            <td style="padding:0 10px; text-align:center; vertical-align:top;">
                <div style="display:inline-block; text-align:left;">
                    <div>Disusun Oleh</div>
                    <div style="height:90px;"></div>
                    <div style="display:inline-block; border-bottom:1px solid black; padding:0 5px;">
                        {{ $memo->ttd_disusun_nama }}
                    </div>
                    <div style="font-style: italic;">{{ $memo->ttd_disusun_jabatan }}</div>
                </div>
            </td>

            <td style="padding:0 10px; text-align:center; vertical-align:top;">
                <div style="display:inline-block; text-align:left;">
                    <div>Diperiksa Oleh</div>
                    <div style="height:90px;"></div>
                    <div style="display:inline-block; border-bottom:1px solid black; padding:0 5px;">
                        {{ $memo->ttd_diperiksa_nama }}
                    </div>
                    <div style="font-style: italic;">{{ $memo->ttd_diperiksa_jabatan }}</div>
                </div>
            </td>

            <td style="padding:0 10px; text-align:center; vertical-align:top;">
                <div style="display:inline-block; text-align:left;">
                    <div>Disetujui Oleh</div>
                    <div style="height:90px;"></div>
                    <div style="display:inline-block; border-bottom:1px solid black; padding:0 5px;">
                        {{ $memo->ttd_disetujui_nama }}
                    </div>
                    <div style="font-style: italic;">{{ $memo->ttd_disetujui_jabatan }}</div>
                </div>
            </td>
        </tr>
    </table>

<style>
    .page-break {
    page-break-after: always; /* atau gunakan page-break-before di elemen berikutnya */
    page-break-inside: avoid; /* hindari pecah di tengah elemen */
}
</style>
