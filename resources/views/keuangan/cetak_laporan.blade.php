<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kas & Keuangan RT 03</title>
    <style>
        @page {
            margin: 1.8cm 2cm 1.8cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #111;
        }
        .header {
            text-align: center;
        }
        .header h3 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 0;
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 9.5pt;
            font-style: italic;
        }
        .line-double {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin: 10px 0 15px 0;
        }
        .title {
            text-align: center;
            margin-bottom: 15px;
        }
        .title h4 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .title p {
            margin: 3px 0 0 0;
            font-size: 10pt;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th, table.data td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-size: 10pt;
        }
        table.data th {
            background-color: #f3f4f6;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9.5pt;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary-box {
            margin-top: 15px;
            float: right;
            width: 45%;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
        }
        .summary-table td {
            padding: 4px 6px;
        }
        .signatures {
            width: 100%;
            margin-top: 50px;
            clear: both;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
        }
        .sign-space {
            height: 60px;
        }
        .sign-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header">
        <h3>PENGURUS RUKUN TETANGGA 03 / RUKUN WARGA 02</h3>
        <h2>KELURAHAN DIGITAL MAKMUR - KECAMATAN PATRANG</h2>
        <p>Sekretariat: Jl. Melati No. 01 RT 03 / RW 02 Kode Pos 68121 | Telp: (0331) 543210</p>
    </div>

    <div class="line-double"></div>

    <div class="title">
        <h4>LAPORAN REKAPITULASI BUKU KAS & KEUANGAN RT 03</h4>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Tanggal</th>
                <th width="15%">Kode Transaksi</th>
                <th width="35%">Kategori & Keterangan</th>
                <th width="17%">Pemasukan (Rp)</th>
                <th width="17%">Pengeluaran (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $idx => $t)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td class="text-center">{{ $t->tanggal_transaksi->format('d/m/Y') }}</td>
                <td class="text-center font-mono">{{ $t->kode_transaksi }}</td>
                <td>
                    <strong>{{ $t->kategori }}</strong>
                    @if($t->keterangan)
                    <br><span style="font-size: 9pt; color: #555;">{{ $t->keterangan }}</span>
                    @endif
                </td>
                <td class="text-right">
                    {{ $t->jenis === 'pemasukan' ? number_format($t->nominal, 0, ',', '.') : '-' }}
                </td>
                <td class="text-right">
                    {{ $t->jenis === 'pengeluaran' ? number_format($t->nominal, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi dalam periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #f9fafb; font-weight: bold;">
                <td colspan="4" class="text-center">TOTAL REKAPITULASI</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td><strong>Total Pemasukan</strong></td>
                <td>:</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Pengeluaran</strong></td>
                <td>:</td>
                <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 1px solid #000;">
                <td><strong>Saldo Bersih</strong></td>
                <td>:</td>
                <td class="text-right"><strong>Rp {{ number_format($saldoPeriode, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <table class="signatures">
        <tr>
            <td>
                Mengetahui,<br>
                Ketua RT 03 / RW 02
                <div class="sign-space"></div>
                <div class="sign-name">{{ $ketuaRT->nama_lengkap ?? 'H. Ahmad Supriyanto, S.T.' }}</div>
            </td>
            <td>
                Jember, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                Bendahara RT 03 / RW 02
                <div class="sign-space"></div>
                <div class="sign-name">{{ $bendahara->nama_lengkap ?? 'Hj. Siti Rahmawati, S.E.' }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
