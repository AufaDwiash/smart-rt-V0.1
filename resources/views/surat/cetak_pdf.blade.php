<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $surat->suratTemplate->nama_surat }} - {{ $surat->nomor_surat ?? $surat->id }}</title>
    <style>
        @page {
            margin: 2cm 2.5cm 2cm 2.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        .header {
            text-align: center;
            position: relative;
        }
        .header h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 10pt;
            font-style: italic;
        }
        .line-double {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 12px 0 20px 0;
        }
        .title-section {
            text-align: center;
            margin-bottom: 25px;
        }
        .title-section h4 {
            margin: 0;
            font-size: 13pt;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 1px;
        }
        .title-section .nomor {
            margin-top: 3px;
            font-size: 11pt;
        }
        .content {
            text-align: justify;
        }
        .data-table {
            width: 100%;
            margin: 15px 0 20px 20px;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 3px 5px;
            vertical-align: top;
            font-size: 11.5pt;
        }
        .data-table td.label {
            width: 28%;
        }
        .data-table td.colon {
            width: 3%;
        }
        .data-table td.value {
            width: 69%;
        }
        .keperluan-box {
            margin: 15px 0;
            padding: 10px 15px;
            border-left: 3px solid #333;
            background-color: #fcfcfc;
            font-style: italic;
        }
        .signatures {
            width: 100%;
            margin-top: 40px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 11.5pt;
        }
        .stamp-box {
            height: 80px;
            position: relative;
            margin: 5px 0;
        }
        .stamp-badge {
            display: inline-block;
            border: 2px dashed #0284c7;
            color: #0284c7;
            padding: 6px 16px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            transform: rotate(-4deg);
        }
        .sign-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RT -->
    <div class="header">
        <h3>PENGURUS RUKUN TETANGGA 03 / RUKUN WARGA 02</h3>
        <h2>KELURAHAN DIGITAL MAKMUR</h2>
        <h3>KECAMATAN PATRANG — KABUPATEN JEMBER</h3>
        <p>Sekretariat: Jl. Melati No. 01 RT 03 / RW 02 Kode Pos 68121 | Telp: (0331) 543210</p>
    </div>

    <div class="line-double"></div>

    <!-- JUDUL SURAT -->
    <div class="title-section">
        <h4>{{ $surat->suratTemplate->nama_surat }}</h4>
        <div class="nomor">Nomor: {{ $surat->nomor_surat ?? '470/' . sprintf('%03d', $surat->id) . '/RT.03/IX/' . date('Y') }}</div>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>
            Yang bertanda tangan di bawah ini, Ketua Rukun Tetangga 03 / Rukun Warga 02 Kelurahan Digital Makmur, Kecamatan Patrang, Kabupaten Jember, dengan ini menerangkan bahwa:
        </p>

        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ strtoupper($surat->user->nama_lengkap) }}</strong></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td class="colon">:</td>
                <td class="value">{{ $surat->user->nik }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Kartu Keluarga</td>
                <td class="colon">:</td>
                <td class="value">{{ $surat->user->no_kk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value">{{ $surat->user->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat / Tgl. Lahir</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ $surat->user->tempat_lahir ?? 'Jember' }},
                    {{ $surat->user->tanggal_lahir ? $surat->user->tanggal_lahir->isoFormat('D MMMM Y') : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Agama / Pekerjaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $surat->user->agama ?? 'Islam' }} / {{ $surat->user->pekerjaan ?? 'Wiraswasta' }}</td>
            </tr>
            <tr>
                <td class="label">Status Warga</td>
                <td class="colon">:</td>
                <td class="value">Warga {{ ucfirst($surat->user->status_warga) }} ({{ $surat->user->status_keluarga ?? 'Kepala Keluarga' }})</td>
            </tr>
            <tr>
                <td class="label">Alamat Domisili</td>
                <td class="colon">:</td>
                <td class="value">{{ $surat->user->alamat }} RT {{ $surat->user->rt ?? '03' }} / RW {{ $surat->user->rw ?? '02' }}</td>
            </tr>
        </table>

        <p>
            Nama tersebut di atas adalah benar-benar warga yang berdomisili dan bertempat tinggal di lingkungan RT 03 / RW 02 Kelurahan Digital Makmur, Kecamatan Patrang, Kabupaten Jember.
        </p>

        <p>
            Surat pengantar / keterangan ini diberikan kepada yang bersangkutan untuk keperluan:
        </p>

        <div class="keperluan-box">
            "{{ $surat->keperluan }}"
        </div>

        <p>
            Demikian surat keterangan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
        </p>
    </div>

    <!-- TANDA TANGAN & STEMPEL -->
    <table class="signatures">
        <tr>
            <td>
                Mengetahui,<br>
                Yang Bersangkutan
                <div class="stamp-box"></div>
                <div class="sign-name">{{ $surat->user->nama_lengkap }}</div>
            </td>
            <td>
                Jember, {{ $surat->tanggal_selesai ? $surat->tanggal_selesai->isoFormat('D MMMM Y') : \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                Ketua RT 03 / RW 02
                <div class="stamp-box">
                    <div class="stamp-badge">
                        TERVERIFIKASI DIGITAL<br>SMART-RT 03
                    </div>
                </div>
                <div class="sign-name">{{ $ketuaRT->nama_lengkap ?? 'H. Ahmad Supriyanto, S.T.' }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
