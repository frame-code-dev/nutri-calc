<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSchedule;
use App\Models\School;
use App\Models\SchoolCalendar;
use App\Models\RawMaterial;
use App\Models\Rab;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MenuScheduleController extends Controller
{
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
        $menuGroups = Menu::where('is_active', true)->get()->groupBy('type');

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
            'materialRequirements'
        ));
    }

    /**
     * Assign menus to all schools for specific dates
     */
    public function store(Request $request)
    {
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
                    // Update menu
                    $calendar->menu_id = $assign['menu_id'];
                    
                    // If holiday but menu assigned, use school's default portions
                    if ($calendar->day_status === 'holiday' && $assign['menu_id']) {
                        $calendar->portion_count = $school->student_count;
                        $calendar->small_portion_count = $school->small_portion_count;
                        $calendar->large_portion_count = $school->large_portion_count;
                    } elseif ($calendar->day_status === 'holiday' && !$assign['menu_id']) {
                        $calendar->portion_count = 0;
                        $calendar->small_portion_count = 0;
                        $calendar->large_portion_count = 0;
                    }
                    
                    $calendar->save();
                }
            }
            DB::commit();
            return back()->with('success', 'Menu untuk ' . $school->name . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan menu: ' . $e->getMessage());
        }
    }

    /**
     * Clear menu assignment for a specific date across all schools
     */
    public function destroy(Request $request)
    {
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

    /**
     * Management for individual allergy replacements
     */
    public function saveAllergy(Request $request)
    {
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
}
