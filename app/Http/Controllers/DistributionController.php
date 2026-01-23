<?php

namespace App\Http\Controllers;

use App\Models\Kloter;
use App\Models\School;
use App\Models\DistributionUnit;
use App\Models\SchoolCalendar;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\SchoolDistribution;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', now()->addDay()->toDateString());
        
        $kloters = Kloter::with(['distributions' => function($q) use ($date) {
            $q->where('is_active', true)
              ->with(['school.calendars' => function($cq) use ($date) {
                  $cq->where('date', $date);
              }, 'unit']);
        }])->get();

        $units = DistributionUnit::all();

        // Summary totals across all kloters
        $summary = [
            'pk' => 0,
            'pb' => 0,
            'guru' => 0,
            'total' => 0
        ];

        foreach ($kloters as $kloter) {
            foreach ($kloter->distributions as $dist) {
                $school = $dist->school;
                $calendar = $school->calendars->first();
                
                if ($calendar && $calendar->day_status === 'receive') {
                    // Calculate portions for this distribution based on assignment
                    $ratioPk = $school->small_portion_count > 0 ? ($dist->small_portion_count / $school->small_portion_count) : 0;
                    $ratioPb = $school->large_portion_count > 0 ? ($dist->large_portion_count / $school->large_portion_count) : 0;
                    $ratioG = $school->teacher_count > 0 ? ($dist->teacher_count / $school->teacher_count) : 0;

                    $dPk = round($calendar->small_portion_count * ($ratioPk ?: ($dist->small_portion_count > 0 ? 1 : 0)));
                    $dPb = round($calendar->large_portion_count * ($ratioPb ?: ($dist->large_portion_count > 0 ? 1 : 0)));
                    $dG = round($school->teacher_count * ($ratioG ?: ($dist->teacher_count > 0 ? 1 : 0)));
                } else {
                    // FALLBACK: Use static allocation from settings if no specific calendar entry
                    $dPk = $dist->small_portion_count;
                    $dPb = $dist->large_portion_count;
                    $dG = $dist->teacher_count;
                }

                // Store calculated portions in the distribution object for the view
                $dist->calculated_pk = $dPk;
                $dist->calculated_pb = $dPb;
                $dist->calculated_guru = $dG;

                $summary['pk'] += $dPk;
                $summary['pb'] += $dPb;
                $summary['guru'] += $dG;
                $summary['total'] += ($dPk + $dPb + $dG);
            }
        }

        return view('distribution.index', compact('kloters', 'units', 'date', 'summary'));
    }

    public function settings()
    {
        $kloters = Kloter::with(['distributions.school', 'distributions.unit'])->get();
        $units = DistributionUnit::all();
        $schools = School::orderBy('name')->get();

        return view('distribution.settings', compact('kloters', 'units', 'schools'));
    }

    public function updateSettings(Request $request)
    {
        // We will validate portions sum in JS, but let's keep basic structure validation
        $request->validate([
            'distributions' => 'nullable|array',
            'distributions.*.school_id' => 'required|exists:schools,id',
            'distributions.*.kloter_id' => 'required|exists:kloters,id',
            'distributions.*.distribution_unit_id' => 'required|exists:distribution_units,id',
            'distributions.*.name' => 'nullable|string|max:255',
            'distributions.*.small_portion_count' => 'required|integer|min:0',
            'distributions.*.large_portion_count' => 'required|integer|min:0',
            'distributions.*.teacher_count' => 'required|integer|min:0',
        ]);

        DB::transaction(function() use ($request) {
            // Delete ALL current distributions to rebuild from the full list in the request
            // This ensures sync if users remove entries
            SchoolDistribution::truncate();
            
            if ($request->distributions) {
                foreach ($request->distributions as $data) {
                    SchoolDistribution::create($data);
                }
            }
        });

        return back()->with('success', 'Setting kloter & distribusi berhasil diperbarui.');
    }

    public function exportWord(Request $request)
    {
        $date = $request->get('date', now()->addDay()->toDateString());
        
        $kloters = Kloter::with(['distributions' => function($q) use ($date) {
            $q->where('is_active', true)
              ->with(['school.calendars' => function($cq) use ($date) {
                  $cq->where('date', $date);
              }, 'unit']);
        }])->get();

        $units = DistributionUnit::all();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'marginLeft' => 600,
            'marginRight' => 600,
            'marginTop' => 600,
            'marginBottom' => 600,
        ]);

        $phpWord->addTitleStyle(1, ['size' => 16, 'bold' => true], ['alignment' => Jc::CENTER]);
        $section->addTitle("LAPORAN DISTRIBUSI MBG - " . date('d F Y', strtotime($date)), 1);
        $section->addTextBreak(1);

        $headerStyle = ['bold' => true, 'size' => 10];
        $cellStyle = ['valign' => 'center'];
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
            'alignment' => Jc::CENTER,
        ];

        foreach ($kloters as $kloter) {
            $section->addText(strtoupper($kloter->name), ['bold' => true, 'size' => 12], ['alignment' => Jc::CENTER]);
            
            $table = $section->addTable($tableStyle);
            
            // Header Row: [Unit 1 name] [Unit 2 name] ... [Jumlah]
            // We'll use 2 columns per unit (Label + Value) plus 1 for total
            $table->addRow();
            foreach ($units as $unit) {
                // Add two cells for each unit, but we'll try to visually group them
                $table->addCell(4000, array_merge($cellStyle, ['gridSpan' => 2, 'shading' => ['fill' => 'F9FAFB']]))
                      ->addText(strtoupper($unit->name), $headerStyle, ['alignment' => Jc::CENTER]);
            }
            $table->addCell(2000, array_merge($cellStyle, ['shading' => ['fill' => 'F3F4F6']]))
                  ->addText("JUMLAH", $headerStyle, ['alignment' => Jc::CENTER]);

            // Calculate per-unit totals for this kloter
            $unitData = [];
            foreach ($units as $u) {
                $unitData[$u->id] = ['pk' => 0, 'pb' => 0, 'g' => 0];
            }

            foreach ($kloter->distributions as $dist) {
                if (!$dist->unit) continue;
                
                $school = $dist->school;
                $calendar = $school->calendars->first();
                
                if ($calendar && $calendar->day_status === 'receive') {
                    $ratioPk = $school->small_portion_count > 0 ? ($dist->small_portion_count / $school->small_portion_count) : 0;
                    $ratioPb = $school->large_portion_count > 0 ? ($dist->large_portion_count / $school->large_portion_count) : 0;
                    $ratioG = $school->teacher_count > 0 ? ($dist->teacher_count / $school->teacher_count) : 0;

                    $dPk = round($calendar->small_portion_count * ($ratioPk ?: ($dist->small_portion_count > 0 ? 1 : 0)));
                    $dPb = round($calendar->large_portion_count * ($ratioPb ?: ($dist->large_portion_count > 0 ? 1 : 0)));
                    $dG = round($school->teacher_count * ($ratioG ?: ($dist->teacher_count > 0 ? 1 : 0)));
                } else {
                    $dPk = $dist->small_portion_count;
                    $dPb = $dist->large_portion_count;
                    $dG = $dist->teacher_count;
                }

                $unitData[$dist->unit->id]['pk'] += $dPk;
                $unitData[$dist->unit->id]['pb'] += $dPb;
                $unitData[$dist->unit->id]['g'] += $dG;
            }

            // Row: PK
            $table->addRow();
            $rowSumPk = 0;
            foreach ($units as $unit) {
                $val = $unitData[$unit->id]['pk'];
                $table->addCell(1000, $cellStyle)->addText("pk", ['italic' => true, 'size' => 9]);
                $table->addCell(3000, $cellStyle)->addText(number_format($val), [], ['alignment' => Jc::CENTER]);
                $rowSumPk += $val;
            }
            $table->addCell(2000, $cellStyle)->addText(number_format($rowSumPk), $headerStyle, ['alignment' => Jc::CENTER]);

            // Row: PB
            $table->addRow();
            $rowSumPb = 0;
            foreach ($units as $unit) {
                $val = $unitData[$unit->id]['pb'];
                $table->addCell(1000, $cellStyle)->addText("pb", ['italic' => true, 'size' => 9]);
                $table->addCell(3000, $cellStyle)->addText(number_format($val), [], ['alignment' => Jc::CENTER]);
                $rowSumPb += $val;
            }
            $table->addCell(2000, $cellStyle)->addText(number_format($rowSumPb), $headerStyle, ['alignment' => Jc::CENTER]);

            // Row: GURU
            $table->addRow();
            $rowSumG = 0;
            foreach ($units as $unit) {
                $val = $unitData[$unit->id]['g'];
                $table->addCell(1000, $cellStyle)->addText("guru", ['italic' => true, 'size' => 9]);
                $table->addCell(3000, $cellStyle)->addText(number_format($val), [], ['alignment' => Jc::CENTER]);
                $rowSumG += $val;
            }
            $table->addCell(2000, $cellStyle)->addText(number_format($rowSumG), $headerStyle, ['alignment' => Jc::CENTER]);

            // Row: TOTAL UNIT
            $table->addRow();
            $grandSum = 0;
            foreach ($units as $unit) {
                $unitTotal = $unitData[$unit->id]['pk'] + $unitData[$unit->id]['pb'] + $unitData[$unit->id]['g'];
                $table->addCell(1000, array_merge($cellStyle, ['shading' => ['fill' => 'F3F4F6']]))->addText("", $headerStyle);
                $table->addCell(3000, array_merge($cellStyle, ['shading' => ['fill' => 'F3F4F6']]))->addText(number_format($unitTotal), $headerStyle, ['alignment' => Jc::CENTER]);
                $grandSum += $unitTotal;
            }
            $table->addCell(2000, array_merge($cellStyle, ['shading' => ['fill' => 'DBEAFE']]))->addText(number_format($grandSum), ['bold' => true, 'color' => '2563EB'], ['alignment' => Jc::CENTER]);

            $section->addTextBreak(2);
        }

        $filename = "Laporan_Distribusi_" . $date . ".docx";
        $temp_file = tempnam(sys_get_temp_dir(), 'phpword');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }
}
