<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolCalendar;
use App\Models\Menu;
use App\Models\RawMaterial;
use App\Models\Rab;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NutritionistMenuController extends Controller
{
    public function index(Request $request)
    {
        $weekNumber = $request->get('week', Carbon::now()->addWeek()->isoWeek);
        $year = $request->get('year', Carbon::now()->year);

        // Calculate Start and End Date
        $startOfWeek = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->addDays(4); // Mon-Fri

        // 1. Schools that have "receive" status in this week
        $activeSchools = School::where('is_active', true)
            ->whereHas('calendars', function($q) use ($weekNumber, $year) {
                $q->where('week_number', $weekNumber)
                  ->where('year', $year)
                  ->where('day_status', 'receive');
            })->get();

        // 2. Total portions for the week
        $totalPortions = SchoolCalendar::where('week_number', $weekNumber)
            ->where('year', $year)
            ->where('day_status', 'receive')
            ->sum('portion_count');

        // 3. Matrix Assignment Data (Menu for each day)
        // We'll use a simple array to represent the 5 days
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $dates = [];
        for ($i = 0; $i < 5; $i++) {
            $dates[] = $startOfWeek->copy()->addDays($i)->toDateString();
        }

        // Fetch menus grouped by type for selection
        $menus = Menu::where('is_active', true)->get()->groupBy('type');
        // Map to friendly labels for the view
        $menuGroups = [
            'Basah' => $menus->get('wet', collect()),
            'Kering' => $menus->get('dry', collect())
        ];

        // 4. Cost & Raw Material Calculation
        // This is dynamic based on selected menus in the matrix (session or request)
        $selectedMenus = $request->get('menus', []); // Format: ['2026-01-20' => menu_id]
        
        $materialRequirements = [];
        $totalCost = 0;

        if (!empty($selectedMenus)) {
            foreach ($selectedMenus as $date => $menuId) {
                $menu = Menu::with('menuItems.rawMaterial')->find($menuId);
                if (!$menu) continue;

                $portionsThisDay = SchoolCalendar::where('date', $date)
                    ->where('day_status', 'receive')
                    ->sum('portion_count');

                foreach ($menu->menuItems as $item) {
                    $materialId = $item->raw_material_id;
                    $needed = $item->quantity_per_portion * $portionsThisDay;
                    
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
                    $totalCost += ($item->quantity_per_portion * $portionsThisDay * $item->rawMaterial->price_per_unit);
                }
            }
        }

        // 5. RAB Progress
        $totalRab = Rab::whereIn('school_id', $activeSchools->pluck('id'))->sum('total_budget');
        $remainingRab = $totalRab - $totalCost;
        $budgetProgress = $totalRab > 0 ? ($totalCost / $totalRab) * 100 : 0;

        return view('nutritionist.dashboard', compact(
            'activeSchools',
            'totalPortions',
            'totalCost',
            'remainingRab',
            'budgetProgress',
            'totalRab',
            'menuGroups',
            'days',
            'dates',
            'materialRequirements',
            'weekNumber',
            'year'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'week' => 'required|integer',
            'year' => 'required|integer',
            'assignments' => 'required|array',
            'assignments.*.date' => 'required|date',
            'assignments.*.menu_id' => 'required|exists:menus,id',
        ]);

        foreach ($request->assignments as $assign) {
            SchoolCalendar::where('date', $assign['date'])
                ->where('day_status', 'receive')
                ->update(['menu_id' => $assign['menu_id']]);
        }

        return back()->with('success', 'Menu berhasil di-assign ke semua sekolah.');
    }

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
