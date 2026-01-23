<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kloter->name }}</title>
    <style>
        @page {
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }
        h1 {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        h2 {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin: 0 0 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9pt;
        }
        td.left {
            text-align: left;
        }
        .section-header {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
        }
        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .notes {
            margin-top: 10px;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <h1>DAFTAR NAMA SEKOLAH PENERIMA MBG</h1>
    <h2>{{ strtoupper($kloter->name) }}@if($kloter->date), {{ $kloter->date->format('d F Y') }}@endif</h2>

    <table>
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA</th>
                <th colspan="3">PLAT</th>
                <th rowspan="2">JUMLAH</th>
            </tr>
            <tr>
                <th>PK</th>
                <th>PB</th>
                <th>GURU</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPk = 0;
                $totalPb = 0;
                $totalGuru = 0;
                $totalJumlah = 0;
            @endphp

            @forelse($kloter->distributions as $index => $dist)
                @php
                    $pk = $dist->small_portion_count;
                    $pb = $dist->large_portion_count;
                    $guru = $dist->teacher_count;
                    $jumlah = $pk + $pb + $guru;
                    
                    $totalPk += $pk;
                    $totalPb += $pb;
                    $totalGuru += $guru;
                    $totalJumlah += $jumlah;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="left">
                        {{ $dist->school->name }}
                        @if($dist->name) ({{ $dist->name }}) @endif
                    </td>
                    <td>{{ $pk }}</td>
                    <td>{{ $pb > 0 ? $pb : '' }}</td>
                    <td>{{ $guru > 0 ? $guru : '' }}</td>
                    <td>{{ $jumlah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada distribusi</td>
                </tr>
            @endforelse

            @if($kloter->distributions->count() > 0)
                <tr class="total-row">
                    <td colspan="2">TOTAL KESELURUHAN</td>
                    <td>{{ $totalPk }}</td>
                    <td>{{ $totalPb }}</td>
                    <td>{{ $totalGuru }}</td>
                    <td>{{ $totalJumlah }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if($kloter->description)
        <div class="notes">
            <strong>Catatan:</strong> {{ $kloter->description }}
        </div>
    @endif

    <div class="notes">
        <p><strong>Keterangan:</strong></p>
        <p>PK: Porsi Kecil (Siswa Kelas 1-3) | PB: Porsi Besar (Siswa Kelas 4-6) | GURU: Guru dan Tenaga Kependidikan</p>
    </div>
</body>
</html>
