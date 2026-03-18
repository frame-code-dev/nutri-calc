<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Gaji — {{ $period->nama_periode }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            background: #fff;
        }

        @media print {
            html, body { width: 210mm; }
            .no-print { display: none !important; }
        }

        .container {
            width: 185mm;
            margin: 10mm auto;
        }

        .page-title {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            line-height: 1.6;
            margin-bottom: 6mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #666;
            padding: 3px 5px;
            font-size: 8.5pt;
        }

        thead th {
            background-color: #4472C4;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        tbody td { vertical-align: top; }
        tbody tr:nth-child(even) { background-color: #f0f4ff; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        tfoot td {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
        }

        .section-label {
            background: #c6d4f0;
            font-weight: bold;
            padding: 3px 5px;
            font-size: 8.5pt;
        }
        .section-total {
            background: #4472C4;
            color: white;
            font-weight: bold;
        }

        .terbilang-cell {
            font-style: italic;
            font-size: 8pt;
        }

        .no-print {
            position: fixed;
            top: 16px;
            right: 16px;
            display: flex;
            gap: 8px;
            z-index: 999;
        }
        .btn-print {
            padding: 8px 20px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-back {
            padding: 8px 16px;
            background: #f3f4f6;
            color: #374151;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="no-print">
    <a href="{{ route('gaji-relawan.show', $period) }}" class="btn-back">← Kembali</a>
    <button class="btn-print" onclick="window.print()">🖨️ Cetak / PDF</button>
</div>

<div class="container">
    <div class="page-title">
        REKAPITULASI UPAH RELAWAN<br>
        {{ strtoupper($period->instansi ?: 'SATUAN PELAYANAN PEMENUHAN GIZI') }}<br>
        {{ strtoupper($period->nama_periode) }} | Periode : {{ $period->periode_roman }}<br>
        {{ $period->tanggal_mulai->format('d M Y') }} s/d {{ $period->tanggal_selesai->format('d M Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:24px">NO</th>
                <th>NAMA RELAWAN</th>
                <th>JABATAN</th>
                <th style="width:36px">HARI</th>
                <th style="width:72px">UPAH</th>
                <th style="width:80px">TOTAL UPAH</th>
                <th>PENYEBUTAN</th>
            </tr>
        </thead>
        <tbody>
            {{-- ── Relawan Tetap ── --}}
            <tr>
                <td colspan="7" class="section-label">Relawan Tetap</td>
            </tr>
            @foreach($detailsTetap as $i => $detail)
            @php $r = $detail->relawan; @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->jabatan }}</td>
                <td class="text-center">{{ $detail->total_hari }}</td>
                <td class="text-right">Rp{{ number_format($detail->upah_per_hari, 0, ',', '.') }}</td>
                <td class="text-right">Rp{{ number_format($detail->total_upah, 0, ',', '.') }}</td>
                <td class="terbilang-cell">{{ terbilangRupiah($detail->total_upah) }}</td>
            </tr>
            @endforeach
            <tr class="section-total">
                <td colspan="5" class="text-right">TOTAL RELAWAN TETAP</td>
                <td class="text-right">Rp{{ number_format($totalTetap, 0, ',', '.') }}</td>
                <td></td>
            </tr>

            @if($detailsMagang->count() > 0)
            {{-- ── Tenaga Magang ── --}}
            <tr>
                <td colspan="7" class="section-label">Tenaga Magang</td>
            </tr>
            @foreach($detailsMagang as $i => $detail)
            @php $r = $detail->relawan; @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->jabatan }}</td>
                <td class="text-center">{{ $detail->total_hari }}</td>
                <td class="text-right">Rp{{ number_format($detail->upah_per_hari, 0, ',', '.') }}</td>
                <td class="text-right">Rp{{ number_format($detail->total_upah, 0, ',', '.') }}</td>
                <td class="terbilang-cell">{{ terbilangRupiah($detail->total_upah) }}</td>
            </tr>
            @endforeach
            <tr class="section-total">
                <td colspan="5" class="text-right">TOTAL TENAGA MAGANG</td>
                <td class="text-right">Rp{{ number_format($totalMagang, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            @endif

            {{-- ── Grand Total ── --}}
            <tr class="section-total">
                <td colspan="5" style="text-align:right; font-size: 9.5pt;">GRAND TOTAL</td>
                <td class="text-right" style="font-size: 9.5pt;">Rp{{ number_format($totalTetap + $totalMagang, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    {{-- Signature --}}
    <div style="margin-top: 12mm; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8mm; text-align: center; font-size: 8pt;">
        <div>
            <p>Penerima,</p>
            <div style="height: 28mm;"></div>
            <p>( ______________ )</p>
        </div>
        <div>
            <p>Mengetahui,</p>
            <div style="height: 28mm;"></div>
            <p>{{ $period->penandatangan_1 ?? '_______________' }}</p>
        </div>
        <div>
            <p>Menyetujui,</p>
            <div style="height: 28mm;"></div>
            <p>{{ $period->penandatangan_2 ?? '_______________' }}</p>
        </div>
    </div>
</div>

</body>
</html>
