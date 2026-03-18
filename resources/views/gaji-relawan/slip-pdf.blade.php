<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji — {{ $period->nama_periode }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            background: #fff;
            color: #000;
        }

        @media print {
            @page { size: A4 portrait; margin: 0; }
            html, body { width: 210mm; height: 297mm; }
            .no-print { display: none !important; }
            .page { page-break-after: always; height: 100vh; }
            .page:last-child { page-break-after: avoid; }
        }

        /* Container halaman, di-set flex stack 4 baris */
        .page {
            width: 210mm;
            height: 297mm; /* Fixed height for A4 */
            padding: 10mm;
            display: flex;
            flex-direction: column;
            gap: 1mm; /* Jarak antar slip */
        }

        /* ─── Single slip ───────────────────────── */
        .slip {
            border: 2px solid #000;
            flex: 1; /* Akan membagi rata sisa space vertikal menjadi 4 */
            display: flex;
            flex-direction: column;
            /* overflow: hidden; */
            font-size: 10pt;
            height: 5000px !important;
        }

        /* Header area */
        .slip-header {
            display: flex;
            border-bottom: 2px solid #000;
        }
        .slip-header-left {
            flex: 1;
            padding: 4px;
            border-right: 1px solid #000;
            font-weight: bold;
            text-align: center;         /* Sesuai gambar, disenter */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .slip-header-right {
            width: 45%;
            padding: 4px;
        }
        .slip-header-right .title {
            font-weight: normal;        /* Di gambar kelihatannya normal font */
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }
        .slip-header-right table {
            width: 100%;
            font-size: 10pt;
            border-collapse: collapse;
        }
        .slip-header-right td {
            padding: 1px 0;
            vertical-align: top;
        }
        .slip-header-right td:first-child { width: 60%; }
        .slip-header-right td:nth-child(2) { width: 5%; }

        /* Body fields */
        .slip-body {
            padding: 4px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .slip-body-table {
            width: 100%;
            font-size: 10pt;
            border-collapse: collapse;
            flex: 1;
        }
        .slip-body-table td { padding: 2px; vertical-align: top; border: none; }
        .slip-body-table td:first-child { width: 120px; }
        .slip-body-table td:nth-child(2) { width: 15px; text-align: center; }

        /* Total Penerimaan Row */
        .total-row {
            display: flex;
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            padding: 3px 4px;
            font-weight: bold;
            font-size: 10pt;
            background: #fff;
        }
        .total-label { width: 135px; } /* menyesuaikan first+second child padding di atas */
        
        .terbilang-row {
            padding: 3px 4px;
            font-style: italic;
            font-size: 10pt;
            text-align: center; /* Sesuai gambar 3 (di tengah) */
            flex: 1;
        }

        /* Signature area */
        .slip-footer {
            border-top: 1px solid #000;
            padding: 4px;
        }
        .sig-table { width: 100%; text-align: center; border-collapse: collapse; }
        .sig-table td { font-size: 10pt; padding: 0 2px; width: 33.33%; border: none; }
        .sig-line { 
            height: 40px; /* Ruang untuk tanda tangan */
            vertical-align: bottom;
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
            background: #2563eb;
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
        
        /* Clear all unexpected borders on tr/td just in case */
        table, tr, td, th { border: none; }
    </style>
</head>
<body>

<div class="no-print">
    <a href="{{ route('gaji-relawan.show', $period) }}" class="btn-back">← Kembali</a>
    <button class="btn-print" onclick="window.print()">🖨️ Cetak PDF</button>
</div>

@php
    $slipsPerPage = 4;
    $chunks = $details->chunk($slipsPerPage);
    // Pisahkan teks instansi jika terlalu panjang "SATUAN PELAYANAN PEMENUHAN GIZI <br/> KEDOPOK JREBENG KULON 02"
    $instansi = $period->instansi ?: 'SATUAN PELAYANAN PEMENUHAN GIZI<br>KEDOPOK JREBENG KULON 02';
    // Otomatis kasih break line kalau tidak ada
    if (strpos($instansi, '<br>') === false && strpos($instansi, 'KEDOPOK') !== false) {
        $instansi = str_replace('KEDOPOK', '<br>KEDOPOK', $instansi);
    }
@endphp

@foreach($chunks as $chunkIndex => $chunk)
<div class="page">
    @foreach($chunk as $detail)
    @php
        $r        = $detail->relawan;
        $gajiPokok = $detail->total_hari * $detail->upah_per_hari;
        $komponenList = $detail->components;
        $danaKesehatan = $komponenList->where('nama', 'Dana Kesehatan')->sum('jumlah');
        $totalPenerimaan = $detail->total_upah;
    @endphp
    <div class="slip">
        {{-- Header --}}
        <div class="slip-header">
            <div class="slip-header-left">{!! $instansi !!}</div>
            <div class="slip-header-right">
                <div class="title">TANDA TERIMA UPAH RELAWAN</div>
                <table>
                    <tr>
                        <td>Jumlah Hari Kerja</td>
                        <td>:</td>
                        <td><strong>{{ $detail->total_hari }}</strong></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>:</td>
                        <td><strong>{{ $period->periode_roman }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Body --}}
        <div class="slip-body">
            <table class="slip-body-table">
                <tr>
                    <td>Nama</td><td>:</td>
                    <td>{{ $r->nama }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td><td>:</td>
                    <td>{{ $r->jabatan }}</td>
                </tr>
                <tr>
                    <td>Gaji Pokok</td><td>:</td>
                    <td>Rp{{ number_format($gajiPokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Dana Kesehatan</td><td>:</td>
                    <td>{{ $danaKesehatan != 0 ? 'Rp' . number_format($danaKesehatan, 0, ',', '.') : '' }}</td>
                </tr>
                @foreach($komponenList->where('nama', '!=', 'Dana Kesehatan') as $komp)
                <tr>
                    <td>{{ $komp->nama }}</td><td>:</td>
                    <td>Rp{{ number_format($komp->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        {{-- Footer area (dipindah ke bawah table) --}}
        <div class="total-row">
            <div class="total-label">Total Penerimaan</div>
            <div style="margin-right:8px;">:</div>
            <div>Rp{{ number_format($totalPenerimaan, 0, ',', '.') }}</div>
        </div>
        <div class="terbilang-row">
            {{ ucwords(terbilangRupiah($totalPenerimaan)) }}
        </div>

        <div class="slip-footer">
            <table class="sig-table">
                <tr>
                    <td>Penerima</td>
                    <td>Mengetahui</td>
                    <td>Menyetujui</td>
                </tr>
                <tr>
                    <td class="sig-line">{{ $r->nama }}</td>
                    <td class="sig-line">{{ $period->penandatangan_1 }}</td>
                    <td class="sig-line">{{ $period->penandatangan_2 }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endforeach

    {{-- Fill empty cells if chunk has < $slipsPerPage --}}
    @if($chunk->count() < $slipsPerPage)
        @for($fill = 0; $fill < ($slipsPerPage - $chunk->count()); $fill++)
        <div class="slip" style="border-color: transparent;"></div>
        @endfor
    @endif
</div>
@endforeach

</body>
</html>
