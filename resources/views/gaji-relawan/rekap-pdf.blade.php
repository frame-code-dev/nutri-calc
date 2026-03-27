<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Gaji — {{ $period->nama_periode }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 8pt;
            background: #fff;
        }

        @media print {
            @page { size: A4 landscape; margin: 10mm; }
            .no-print { display: none !important; }
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .page-title {
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            line-height: 1.4;
            margin-bottom: 4mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #333;
            padding: 2px 3px;
            font-size: 7.5pt;
            text-align: center;
            word-wrap: break-word;
        }

        thead th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .bg-blue-dark { background-color: #2e5496; color: white; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .val-zero { color: #dc2626; font-weight: bold; }
        .val-comp { color: #2563eb; font-weight: bold; font-size: 6.5pt; }

        .section-label {
            background: #d9e1f2;
            font-weight: bold;
            text-align: left;
        }
        .section-total {
            background: #4472C4;
            color: white;
            font-weight: bold;
        }
        .terbilang-cell { font-style: italic; font-size: 7pt; }

        .no-print {
            position: fixed; top: 16px; right: 16px; display: flex; gap: 8px; z-index: 999;
        }
        .btn-print { padding: 6px 16px; background: #f59e0b; color: white; border: none; border-radius: 6px; cursor: pointer; }
        .btn-back { padding: 6px 12px; background: #f3f4f6; color: #374151; border: none; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>

<div class="no-print">
    <a href="{{ route('gaji-relawan.show', $period) }}" class="btn-back">← Kembali</a>
    <button class="btn-print" onclick="window.print()">🖨️ Cetak Rekap (Landscape)</button>
</div>

<div class="container">
    <div class="page-title">
        REKAPITULASI UPAH RELAWAN<br>
        {{ strtoupper($period->instansi ?: 'SATUAN PELAYANAN PEMENUHAN GIZI') }}<br>
        {{ strtoupper($period->nama_periode) }} | Periode : {{ $period->periode_roman }}<br>
        {{ $period->tanggal_mulai->format('d M Y') }} s/d {{ $period->tanggal_selesai->format('d M Y') }}
    </div>

    @php
        $totalGridCols = 0;
        foreach($hariKolom as $m => $h) $totalGridCols += count($h);
        $totalCols = 4 + $totalGridCols + 3; // NO, NAMA, JABATAN + GRID + HARI, UPAH, TOTAL
    @endphp

    <table>
        <thead>
            <tr class="bg-blue-dark">
                <th colspan="3"></th>
                @foreach($hariKolom as $minggu => $hariList)
                    <th colspan="{{ count($hariList) }}">{{ $minggu }}</th>
                @endforeach
                <th colspan="3"></th>
            </tr>
            <tr>
                <th style="width:25px">NO</th>
                <th style="width:120px">NAMA RELAWAN</th>
                <th style="width:100px">JABATAN</th>
                @foreach($hariKolom as $minggu => $hariList)
                    @foreach($hariList as $hari => $label)
                        <th style="width:35px">{{ strtoupper(substr($label, 0, 3)) }}<br>{{ substr($label, -6) }}</th>
                    @endforeach
                @endforeach
                <th style="width:30px">HARI</th>
                <th style="width:60px">UPAH</th>
                <th style="width:70px">TOTAL UPAH</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="{{ $totalCols }}" class="section-label">Relawan Tetap</td>
            </tr>
            @foreach($detailsTetap as $i => $detail)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="text-left font-bold">{{ $detail->relawan->nama }}</td>
                <td class="text-left">{{ $detail->relawan->jabatan }}</td>
                @foreach($hariKolom as $minggu => $hariList)
                    @foreach($hariList as $hari => $label)
                        @php 
                            $val = $detail->hari_kerja[$hari] ?? ''; 
                            $kompHari = $detail->components->where('tanggal', $hari)->sum('jumlah');
                            $isHoliday = \Illuminate\Support\Carbon::parse($hari)->between('2026-03-18', '2026-03-24');
                            $bgColor = '';
                            if ($isHoliday) $bgColor = 'background-color: #dbeafe;'; // Blue-50 priority
                            elseif ($val === '0') $bgColor = 'background-color: #fee2e2;'; // Red-50
                        @endphp
                        <td style="{{ $bgColor }}">
                            <div class="{{ $val == '0' ? 'val-zero' : '' }}">
                                {{ $val == '0' ? 'IZIN' : ($val ?: '-') }}
                            </div>
                            @if($kompHari > 0)
                                <div class="val-comp">+{{ number_format($kompHari, 0, ',', '.') }}</div>
                            @endif
                        </td>
                    @endforeach
                @endforeach
                <td class="font-bold">{{ $detail->total_hari }}</td>
                <td class="text-right">{{ number_format($detail->upah_per_hari, 0, ',', '.') }}</td>
                <td class="text-right font-bold">{{ number_format($detail->total_upah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="section-total">
                <td colspan="{{ 4 + $totalGridCols }}" class="text-right">TOTAL RELAWAN TETAP</td>
                <td colspan="2" class="text-right font-bold">Rp{{ number_format($totalTetap, 0, ',', '.') }}</td>
            </tr>

            @if($detailsMagang->count() > 0)
            <tr>
                <td colspan="{{ $totalCols }}" class="section-label">Tenaga Magang</td>
            </tr>
            @foreach($detailsMagang as $i => $detail)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="text-left font-bold">{{ $detail->relawan->nama }}</td>
                <td class="text-left">{{ $detail->relawan->jabatan }}</td>
                @foreach($hariKolom as $minggu => $hariList)
                    @foreach($hariList as $hari => $label)
                        @php 
                            $val = $detail->hari_kerja[$hari] ?? ''; 
                            $kompHari = $detail->components->where('tanggal', $hari)->sum('jumlah');
                            $isHoliday = \Illuminate\Support\Carbon::parse($hari)->between('2026-03-18', '2026-03-24');
                            $bgColor = '';
                            if ($isHoliday) $bgColor = 'background-color: #dbeafe;'; // Blue-50 priority
                            elseif ($val === '0') $bgColor = 'background-color: #fee2e2;'; // Red-50
                        @endphp
                        <td style="{{ $bgColor }}">
                            <div class="{{ $val == '0' ? 'val-zero' : '' }}">
                                {{ $val == '0' ? 'IZIN' : ($val ?: '-') }}
                            </div>
                            @if($kompHari > 0)
                                <div class="val-comp">+{{ number_format($kompHari, 0, ',', '.') }}</div>
                            @endif
                        </td>
                    @endforeach
                @endforeach
                <td class="font-bold">{{ $detail->total_hari }}</td>
                <td class="text-right">{{ number_format($detail->upah_per_hari, 0, ',', '.') }}</td>
                <td class="text-right font-bold">{{ number_format($detail->total_upah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="section-total">
                <td colspan="{{ 4 + $totalGridCols }}" class="text-right">TOTAL TENAGA MAGANG</td>
                <td colspan="2" class="text-right font-bold">Rp{{ number_format($totalMagang, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr class="section-total" style="background: #2e5496;">
                <td colspan="{{ 4 + $totalGridCols }}" class="text-right" style="font-size: 9pt;">GRAND TOTAL</td>
                <td colspan="2" class="text-right" style="font-size: 9pt; font-weight: bold;">Rp{{ number_format($totalTetap + $totalMagang, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 8mm; display: grid; grid-template-columns: 1fr 1fr 1fr; text-align: center; font-size: 8pt;">
        <div>
            <p>Penerima,</p>
            <div style="height: 15mm;"></div>
            <p>( ______________ )</p>
        </div>
        <div>
            <p>Mengetahui,</p>
            <div style="height: 15mm;"></div>
            <p><strong>{{ $period->penandatangan_1 ?? '_______________' }}</strong></p>
        </div>
        <div>
            <p>Menyetujui,</p>
            <div style="height: 15mm;"></div>
            <p><strong>{{ $period->penandatangan_2 ?? '_______________' }}</strong></p>
        </div>
    </div>
</div>

</body>
</html>
</div>

</body>
</html>
