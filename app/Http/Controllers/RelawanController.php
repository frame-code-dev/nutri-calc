<?php

namespace App\Http\Controllers;

use App\Models\Relawan;
use App\Models\MasterSppg;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class RelawanController extends Controller
{
    public function index()
    {
        $relawans = Relawan::with('sppg')
            ->orderBy('tipe')
            ->orderBy('nomor_urut')
            ->orderBy('nama')
            ->get();

        $tetap  = $relawans->where('tipe', 'tetap');
        $magang = $relawans->where('tipe', 'magang');

        return view('relawans.index', compact('relawans', 'tetap', 'magang'));
    }

    public function create()
    {
        $sppgs = MasterSppg::all();
        return view('relawans.create', compact('sppgs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sppg_id'     => 'nullable|exists:master_sppgs,id',
            'nama'        => 'required|string|max:255',
            'jabatan'     => 'required|string|max:255',
            'tipe'        => 'required|in:tetap,magang',
            'nomor_urut'  => 'required|integer|min:1',
            'aktif'       => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        Relawan::create($validated);

        return redirect()->route('relawans.index')
            ->with('success', 'Data relawan berhasil ditambahkan.');
    }

    public function edit(Relawan $relawan)
    {
        $sppgs = MasterSppg::all();
        return view('relawans.edit', compact('relawan', 'sppgs'));
    }

    public function update(Request $request, Relawan $relawan)
    {
        $validated = $request->validate([
            'sppg_id'    => 'nullable|exists:master_sppgs,id',
            'nama'       => 'required|string|max:255',
            'jabatan'    => 'required|string|max:255',
            'tipe'       => 'required|in:tetap,magang',
            'nomor_urut' => 'required|integer|min:1',
            'aktif'      => 'boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);

        $relawan->update($validated);

        return redirect()->route('relawans.index')
            ->with('success', 'Data relawan berhasil diperbarui.');
    }

    public function destroy(Relawan $relawan)
    {
        $relawan->delete();
        return redirect()->route('relawans.index')
            ->with('success', 'Data relawan berhasil dihapus.');
    }

    public function exportPresensiPdf()
    {
        $relawans = Relawan::where('aktif', true)
            ->orderBy('nomor_urut')
            ->get();

        $pdf = Pdf::loadView('relawans.exports.presensi-pdf', compact('relawans'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Presensi_Relawan_' . date('Y-m-d') . '.pdf');
    }

    public function exportPresensiExcel()
    {
        $relawans = Relawan::where('aktif', true)
            ->orderBy('nomor_urut')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setTitle('Presensi Relawan');

        // Styles
        $styleHeader = [
            'font' => ['bold' => true, 'name' => 'Times New Roman'],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        $styleTableHead = [
            'font' => ['bold' => true, 'name' => 'Times New Roman'],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF00B0F0'], // Light Blue exactly like image
            ],
        ];

        $styleTableBodyCenter = [
            'font' => ['name' => 'Times New Roman'],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];

        $styleTableBodyLeft = [
            'font' => ['name' => 'Times New Roman'],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];

        // Header Texts
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'SATUAN PELAYANAN PEMENUHAN GIZI (SPPG)');
        $sheet->getStyle('A1')->applyFromArray($styleHeader);

        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'KOTA PROBOLINGGO KEDOPOK JREBENG KULON 02');
        $sheet->getStyle('A2')->applyFromArray($styleHeader);

        $sheet->mergeCells('A3:G3');
        $sheet->setCellValue('A3', 'PRESENSI ABSENSI RELAWAN');
        $sheet->getStyle('A3')->applyFromArray($styleHeader);

        // Date - bold, flush left
        Carbon::setLocale('id');
        $dateStr = 'Hari, Tanggal : ' . Carbon::now()->translatedFormat('l, d F Y');
        $sheet->mergeCells('A5:C5');
        $sheet->setCellValue('A5', $dateStr);
        $sheet->getStyle('A5')->getFont()->setBold(true)->setName('Times New Roman');

        // Table Headers
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Nama Relawan');
        $sheet->setCellValue('C6', 'Jabatan');
        $sheet->setCellValue('D6', 'Jam Datang');
        $sheet->setCellValue('E6', 'TTD');
        $sheet->setCellValue('F6', 'Jam Pulang');
        $sheet->setCellValue('G6', 'TTD');
        $sheet->getStyle('A6:G6')->applyFromArray($styleTableHead);

        // Column Widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);

        // Data
        $row = 7;
        foreach ($relawans as $index => $relawan) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $relawan->nama);
            $sheet->setCellValue('C' . $row, $relawan->jabatan);
            $sheet->setCellValue('D' . $row, '');
            $sheet->setCellValue('E' . $row, '');
            $sheet->setCellValue('F' . $row, '');
            $sheet->setCellValue('G' . $row, '');

            $sheet->getStyle('A' . $row)->applyFromArray($styleTableBodyCenter);
            $sheet->getStyle('B' . $row)->applyFromArray($styleTableBodyLeft);
            $sheet->getStyle('B' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('C' . $row)->applyFromArray($styleTableBodyLeft);
            $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('D' . $row . ':G' . $row)->applyFromArray($styleTableBodyCenter);
            
            $sheet->getRowDimension($row)->setRowHeight(30);
            $row++;
        }

        // Footer
        $row += 2;
        $sheet->setCellValue('B' . $row, 'Mengetahui,');
        $sheet->getStyle('B' . $row)->getFont()->setName('Times New Roman');
        
        $row++;
        $sheet->setCellValue('B' . $row, 'Kepala SPPG,');
        $sheet->setCellValue('F' . $row, 'Akuntan SPPG,');
        $sheet->getStyle('B' . $row)->getFont()->setName('Times New Roman');
        $sheet->getStyle('F' . $row)->getFont()->setName('Times New Roman');

        $writer = new Xlsx($spreadsheet);
        $filename = 'Presensi_Relawan_' . date('Y-m-d') . '.xlsx';
        
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
