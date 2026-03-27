<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Presensi Relawan</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .date {
            font-weight: bold;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: #00B0F0;
            text-align: center;
        }
        td.center {
            text-align: center;
        }
        .footer {
            width: 100%;
            margin-top: 30px;
        }
        .footer td {
            border: none;
            text-align: center;
            padding: 0;
            vertical-align: top;
        }
        .ttd {
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        SATUAN PELAYANAN PEMENUHAN GIZI (SPPG)<br>
        KOTA PROBOLINGGO KEDOPOK JREBENG KULON 02<br>
        PRESENSI ABSENSI RELAWAN
    </div>

    <div class="date">
        Hari, Tanggal : {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama Relawan</th>
                <th style="width: 25%">Jabatan</th>
                <th style="width: 15%">Jam Datang</th>
                <th style="width: 10%">TTD</th>
                <th style="width: 15%">Jam Pulang</th>
                <th style="width: 10%">TTD</th>
            </tr>
        </thead>
        <tbody>
            @foreach($relawans as $index => $r)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->jabatan }}</td>
                <td></td>
                <td class="ttd"></td>
                <td></td>
                <td class="ttd"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="footer" style="border: none;">
        <tr>
            <td style="width: 50%; border: none;">
                Mengetahui,<br>
                Kepala SPPG,
                <br><br><br><br><br>
                _______________________
            </td>
            <td style="width: 50%; border: none;">
                <br>
                Akuntan SPPG,
                <br><br><br><br><br>
                _______________________
            </td>
        </tr>
    </table>
</body>
</html>
