<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSchedule;
use App\Models\School;
use App\Models\SchoolCalendar;
use App\Models\RawMaterial;
use App\Models\Rab;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MenuScheduleController extends Controller
{
    // ... (index, store, destroy, saveAllergy methods unchanged) ...
    public function index(Request $request)
    {
        $weekNumber = $request->get('week', Carbon::now()->addWeek()->isoWeek);
        $year = $request->get('year', Carbon::now()->year);
        $schoolId = $request->get('school_id');

        // Calculate Dates (Mon-Sat)
        $startOfWeek = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek(Carbon::MONDAY);
        $dates = [];
        for ($i = 0; $i < 6; $i++) {
            $dates[] = $startOfWeek->copy()->addDays($i)->toDateString();
        }

        // 1. Get Schools that have filled their calendars for this week
        // We only show schools that have ANY entry in school_calendars for this week
        $schoolsWithCalendars = School::where('is_active', true)
            ->whereHas('calendars', function($query) use ($weekNumber, $year) {
                $query->where('week_number', $weekNumber)->where('year', $year);
            })
            ->orderBy('name')
            ->get();

        // If no school selected, try to default to the first one available
        if (!$schoolId && $schoolsWithCalendars->isNotEmpty()) {
            $schoolId = $schoolsWithCalendars->first()->id;
        }

        $selectedSchool = $schoolId ? School::find($schoolId) : null;
        $dayStatuses = [];
        $selectedMenus = [];

        if ($selectedSchool) {
            // Fetch calendar for the selected school
            $calendars = SchoolCalendar::where('school_id', $schoolId)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->get()
                ->keyBy(fn($c) => $c->date->toDateString());

            foreach ($dates as $date) {
                $calendar = $calendars->get($date);
                $dayStatuses[$date] = $calendar ? $calendar->day_status : 'pending';
                $selectedMenus[$date] = $calendar ? $calendar->menu_id : null;
            }
        }

        // 3. School-Specific Analytics
        $totalSmallPortions = 0;
        $totalLargePortions = 0;
        $totalPortions = 0;
        $totalRab = 0;
        $totalCost = 0;
        $materialRequirements = [];

        if ($selectedSchool) {
            $stats = SchoolCalendar::where('school_id', $schoolId)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->where(function($q) {
                    $q->where('day_status', 'receive')
                      ->orWhereNotNull('menu_id');
                })
                ->selectRaw('SUM(portion_count) as total, SUM(small_portion_count) as small, SUM(large_portion_count) as large')
                ->first();

            $totalPortions = $stats->total ?? 0;
            $totalSmallPortions = $stats->small ?? 0;
            $totalLargePortions = $stats->large ?? 0;

            $totalRab = Rab::where('school_id', $schoolId)->sum('total_budget');

            foreach ($dates as $date) {
                $menuId = $selectedMenus[$date] ?? null;
                $status = $dayStatuses[$date] ?? 'pending';
                if (!$menuId || $status !== 'receive') continue;

                $menu = Menu::with('menuItems.rawMaterial')->find($menuId);
                if (!$menu) continue;

                // Portions for THIS specific school on this day
                $dayPortions = SchoolCalendar::where('school_id', $schoolId)
                    ->where('date', $date)
                    ->first()?->portion_count ?? 0;

                foreach ($menu->menuItems as $item) {
                    $materialId = $item->raw_material_id;
                    $needed = $item->quantity_per_portion * $dayPortions;
                    
                    if (!isset($materialRequirements[$materialId])) {
                        $materialRequirements[$materialId] = [
                            'name' => $item->rawMaterial->name,
                            'needed' => 0,
                            'price' => $item->rawMaterial->price_per_unit,
                            'stock' => $item->rawMaterial->getCurrentStock(),
                            'unit' => $item->rawMaterial->unit,
                        ];
                    }
                    $materialRequirements[$materialId]['needed'] += $needed;
                    $totalCost += ($needed * $item->rawMaterial->price_per_unit);
                }
            }
        }

        $remainingRab = $totalRab - $totalCost;
        $budgetProgress = $totalRab > 0 ? ($totalCost / $totalRab) * 100 : 0;

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $menuGroups = Menu::where('is_active', true)
            ->where('category', 'packet')
            ->get()
            ->groupBy('type');

        // Allergy Monitoring (Filter by school if selected)
        $allergyQuery = SchoolCalendar::with(['school', 'menu', 'allergyMenu'])
            ->where('week_number', $weekNumber)
            ->where('year', $year)
            ->where('day_status', 'receive')
            ->orderBy('date');

        if ($schoolId) {
            $allergyQuery->where('school_id', $schoolId);
        }

        $allCalendars = $allergyQuery->get();

        // --- GLOBAL DAILY REQUIREMENTS FOR WHATSAPP SHARE ---
        $dailyGlobalRequirements = [];
        $kitchenCoordinators = User::role('Koordinator Dapur')->get();
        
        foreach ($dates as $date) {
            $dailyGlobalRequirements[$date] = [
                'menus' => [],
                'materials' => [],
                'total_portions' => 0
            ];
            
            // Get all calendars for ALL schools on this specific date
            $allCalendarsForDay = SchoolCalendar::where('date', $date)
                ->where('day_status', 'receive')
                ->whereNotNull('menu_id')
                ->with(['menu.menuItems.rawMaterial'])
                ->get();
            
            foreach ($allCalendarsForDay as $cal) {
                $menu = $cal->menu;
                if (!isset($dailyGlobalRequirements[$date]['menus'][$menu->id])) {
                    $dailyGlobalRequirements[$date]['menus'][$menu->id] = [
                        'name' => $menu->name,
                        'dishes' => $menu->menuItems->pluck('group_name')->unique()->filter()->values()->toArray()
                    ];
                }
                
                $dailyGlobalRequirements[$date]['total_portions'] += $cal->portion_count;
                
                foreach ($menu->menuItems as $item) {
                    $matId = $item->raw_material_id;
                    $needed = $item->quantity_per_portion * $cal->portion_count;
                    
                    if (!isset($dailyGlobalRequirements[$date]['materials'][$matId])) {
                        $dailyGlobalRequirements[$date]['materials'][$matId] = [
                            'name' => $item->rawMaterial->name,
                            'total' => 0,
                            'unit' => $item->rawMaterial->unit
                        ];
                    }
                    $dailyGlobalRequirements[$date]['materials'][$matId]['total'] += $needed;
                }
            }
        }

        return view('menu-schedules.index', compact(
            'schoolsWithCalendars',
            'selectedSchool',
            'dayStatuses',
            'menuGroups',
            'days',
            'dates',
            'weekNumber',
            'year',
            'selectedMenus',
            'allCalendars',
            'totalPortions',
            'totalSmallPortions',
            'totalLargePortions',
            'totalCost',
            'totalRab',
            'remainingRab',
            'budgetProgress',
            'materialRequirements',
            'dailyGlobalRequirements',
            'kitchenCoordinators'
        ));
    }
    
    public function store(Request $request) {
        // ... (unchanged)
        $request->validate([
            'week' => 'required|integer',
            'year' => 'required|integer',
            'school_id' => 'required|exists:schools,id',
            'assignments' => 'required|array',
            'assignments.*.date' => 'required|date',
            'assignments.*.menu_id' => 'nullable|exists:menus,id',
        ]);

        $school = School::findOrFail($request->school_id);

        DB::beginTransaction();
        try {
            foreach ($request->assignments as $assign) {
                $calendar = SchoolCalendar::where('school_id', $school->id)
                    ->where('date', $assign['date'])
                    ->first();

                if ($calendar) {
                    $calendar->menu_id = $assign['menu_id'];
                    $calendar->save();
                }
            }
            DB::commit();
            return back()->with('success', 'Menu untuk ' . $school->name . ' berhasil diperbarui.')->with('show_share', true);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan menu: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request) {
        // ... (unchanged)
        $request->validate([
            'date' => 'required|date',
            'school_id' => 'required|exists:schools,id',
        ]);

        try {
            SchoolCalendar::where('school_id', $request->school_id)
                ->where('date', $request->date)
                ->update(['menu_id' => null]);

            return back()->with('success', 'Menu untuk tanggal tersebut telah dikosongkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengosongkan menu: ' . $e->getMessage());
        }
    }
    
    public function saveAllergy(Request $request) {
        // ... (unchanged)
         $request->validate([
            'calendar_id' => 'required|exists:school_calendars,id',
            'allergy_menu_id' => 'required|exists:menus,id',
            'allergy_notes' => 'nullable|string',
        ]);

        $calendar = SchoolCalendar::findOrFail($request->calendar_id);
        $calendar->update([
            'allergy_menu_id' => $request->allergy_menu_id,
            'allergy_notes' => $request->allergy_notes,
        ]);

        return back()->with('success', 'Menu alergi berhasil disimpan.');
    }

    /**
     * Store Global Menu Assignment (Weekly or Per-Day)
     */
    public function storeGlobal(Request $request)
    {
        $request->validate([
            'week' => 'required|integer',
            'year' => 'required|integer',
            // If mode is 'weekly', we don't need 'global_assignments'
            'mode' => 'nullable|string',
            'global_assignments' => 'nullable|array',
            'weekly_wet_menu_id' => 'nullable', // string 'random_wet' or int
            'weekly_dry_menu_id' => 'nullable', // string 'random_dry' or int
        ]);

        DB::beginTransaction();
        try {
            $schools = School::where('is_active', true)->get();
            $updatedCount = 0;
            
            // Pre-fetch menus for random selection if needed
            $allWetMenus = Menu::where('type', 'wet')->get();
            $allDryMenus = Menu::where('type', 'dry')->get(); // Keringan for holidays or manual dry

            // Determine if using Weekly Mode or Legacy Daily Mode
            if ($request->mode === 'weekly') {
                // 1. WEEKLY MODE LOGIC
                // Generate Dates for Mon-Sat (6 days) for the given week
                $startOfWeek = Carbon::now()->setISODate($request->year, $request->week)->startOfWeek(Carbon::MONDAY);
                $dates = [];
                for ($i = 0; $i < 6; $i++) {
                    $dates[] = $startOfWeek->copy()->addDays($i)->toDateString();
                }

                $wetInput = $request->weekly_wet_menu_id;
                $dryInput = $request->weekly_dry_menu_id;

                foreach ($schools as $school) {
                     foreach ($dates as $dateStr) {
                         $calendar = SchoolCalendar::firstOrNew([
                            'school_id' => $school->id,
                            'date' => $dateStr
                        ]);

                        if (!$calendar->exists) {
                            $calendar->week_number = $request->week;
                            $calendar->year = $request->year;
                            $calendar->day_status = 'receive'; 
                            $calendar->portion_count = $school->student_count; 
                            $calendar->small_portion_count = $school->small_portion_count;
                            $calendar->large_portion_count = $school->large_portion_count;
                        }

                        // Determine Menu to Assign based on status
                        if ($calendar->day_status === 'holiday') {
                             // --- HOLIDAY LOGIC ---
                             // Apply Dry Input Selection
                             if ($dryInput === 'random_dry') {
                                 // Random dry menu each day/time
                                 $calendar->menu_id = $allDryMenus->isNotEmpty() ? $allDryMenus->random()->id : null;
                             } elseif ($dryInput) {
                                 // Specific ID
                                 $calendar->menu_id = $dryInput;
                             }
                             // Note: If no dry input, leave explicitly NULL or untouched? 
                             // Usually if they apply globally, they expect update.
                        } else {
                             // --- RECEIVE LOGIC ---
                             // Apply Wet Input Selection
                             if ($wetInput === 'random_wet') {
                                 $calendar->menu_id = $allWetMenus->isNotEmpty() ? $allWetMenus->random()->id : null;
                             } elseif ($wetInput) {
                                 $calendar->menu_id = $wetInput;
                             }
                        }
                        
                        $calendar->save();
                        $updatedCount++;
                     }
                }
            } else {
                // 2. LEGACY (DAILY) MODE LOGIC
                // (Only used if form submits old structure, kept for safety)
                if (!$request->global_assignments) {
                     return back()->with('error', 'Tidak ada data assignment.');
                }

                foreach ($request->global_assignments as $assign) {
                    $rawRegularId = $assign['menu_id'] ?? null;
                    $holidayMenuId = $assign['holiday_menu_id'] ?? null;

                    if (!$rawRegularId && !$holidayMenuId) continue;

                    foreach ($schools as $school) {
                        $calendar = SchoolCalendar::firstOrNew([
                            'school_id' => $school->id,
                            'date' => $assign['date']
                        ]);
                        
                        if (!$calendar->exists) {
                            $calendar->week_number = $request->week;
                            $calendar->year = $request->year;
                            $calendar->day_status = 'receive'; 
                            $calendar->portion_count = $school->student_count; 
                            $calendar->small_portion_count = $school->small_portion_count;
                            $calendar->large_portion_count = $school->large_portion_count;
                        }
                        
                        if ($calendar->day_status === 'holiday') {
                            // Legacy holiday logic
                             if ($holidayMenuId === 'random_dry') {
                                 $calendar->menu_id = $allDryMenus->isNotEmpty() ? $allDryMenus->random()->id : null;
                             } elseif ($holidayMenuId) {
                                 $calendar->menu_id = $holidayMenuId;
                             }
                        } else {
                            if ($rawRegularId === 'random_wet') {
                                $calendar->menu_id = $allWetMenus->isNotEmpty() ? $allWetMenus->random()->id : null;
                            } elseif ($rawRegularId === 'random_dry') {
                                $calendar->menu_id = $allDryMenus->isNotEmpty() ? $allDryMenus->random()->id : null;
                            } elseif ($rawRegularId) {
                                $calendar->menu_id = $rawRegularId;
                            }
                        }

                        $calendar->save();
                        $updatedCount++;
                    }
                }
            }

            DB::commit();
            return back()->with('success', 'Menu berhasil diterapkan secara MINGGUAN untuk ' . $schools->count() . ' sekolah.')->with('show_share', true);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menerapkan menu global: ' . $e->getMessage());
        }
    }
    /**
     * Display the Weekly Menu Report Page
     */
    public function weeklyReportView(Request $request)
    {
        $weekNumber = $request->get('week', Carbon::now()->addWeek()->isoWeek);
        $year = $request->get('year', Carbon::now()->year);

        // Generate Dates
        $startOfWeek = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek(Carbon::MONDAY);
        $dates = [];
        for ($i = 0; $i < 6; $i++) {
            $dates[] = $startOfWeek->copy()->addDays($i);
        }

        return view('reports.weekly-menu', compact('weekNumber', 'year', 'dates'));
    }

    /**
     * Export Weekly Menu Report to Excel
     */
    public function exportWeeklyExcel(Request $request)
    {
        $weekNumber = $request->get('week', Carbon::now()->addWeek()->isoWeek);
        $year = $request->get('year', Carbon::now()->year);

        // Generate Dates (Mon-Sat)
        $startOfWeek = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek(Carbon::MONDAY);
        $dates = [];
        $headerDates = [];
        for ($i = 0; $i < 6; $i++) {
            $dt = $startOfWeek->copy()->addDays($i);
            $dates[] = $dt->toDateString();
            $headerDates[] = $dt->isoFormat('dddd, D MMM Y');
        }

        // --- GATHER DATA (GLOBAL AGGREGATION) ---
        // This follows the logic of "Daily Global Requirements"
        $reportData = [];

        foreach ($dates as $index => $date) {
            $reportData[$date] = [
                'ingredients' => []
            ];

            // Get all calendars for ALL schools on this specific date that are 'receive'
            // We assume the report wants to know what SHOULD be cooked.
            $allCalendarsForDay = SchoolCalendar::where('date', $date)
                ->where('day_status', 'receive')
                ->whereNotNull('menu_id')
                ->with(['menu.menuItems.rawMaterial'])
                ->get();

            // We aggregate unique ingredients used in ANY menu that day.
            // If multiple schools have different menus, we list ALL ingredients.
            $ingredientsList = collect();

            foreach ($allCalendarsForDay as $cal) {
                if (!$cal->menu) continue;

                foreach ($cal->menu->menuItems as $item) {
                    $ingredientsList->push($item->rawMaterial->name);
                }
            }

            // Unique and Sort
            $reportData[$date]['ingredients'] = $ingredientsList->unique()->sort()->values()->all();
        }

        // --- CREATE EXCEL ---
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Laporan Menu Minggu {$weekNumber}");

        // 1. Header Row (Dates)
        $colIndex = 1; // Column A
        foreach ($headerDates as $hDate) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex) . '1';
            $sheet->setCellValue($cell, $hDate);
            
            // Format Header
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('C6E0B4'); // Light Green like screenshot
            $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            $colIndex++;
        }

        // 2. Data Rows
        // Find max number of ingredients to determine value vertical loop
        $maxRows = 0;
        foreach ($reportData as $data) {
            $count = count($data['ingredients']);
            if ($count > $maxRows) $maxRows = $count;
        }

        // Fill columns
        for ($r = 0; $r < $maxRows; $r++) {
            $currentRow = $r + 2; // Start from row 2
            $colIndex = 1;

            foreach ($dates as $date) {
                $ingredient = $reportData[$date]['ingredients'][$r] ?? '';
                $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex) . $currentRow;
                $sheet->setCellValue($cell, $ingredient);
                
                // Border
                $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $colIndex++;
            }
        }

        // 3. Auto Size Columns
        for ($i = 1; $i <= 6; $i++) {
            $sheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
        }

        // 4. Download
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = "Laporan_Menu_Minggu_{$weekNumber}_{$year}.xlsx";

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
