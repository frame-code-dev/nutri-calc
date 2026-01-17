<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Menu;
use App\Models\SchoolCalendar;
use App\Services\NutritionCalculator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class NutritionReportController extends Controller
{
    protected $nutritionCalculator;

    public function __construct(NutritionCalculator $nutritionCalculator)
    {
        $this->nutritionCalculator = $nutritionCalculator;
    }

    /**
     * Show nutrition reports page
     */
    public function index()
    {
        $schools = School::where('is_active', true)->orderBy('name')->get();
        $menus = Menu::where('is_active', true)->orderBy('name')->get();

        return view('nutrition-reports.index', compact('schools', 'menus'));
    }

    /**
     * Generate menu nutrition report
     */
    public function menuReport(Request $request, Menu $menu)
    {
        $nutrition = $menu->calculateNutrition();

        if ($request->has('format') && $request->format === 'pdf') {
            $pdf = Pdf::loadView('nutrition-reports.menu-pdf', [
                'menu' => $menu,
                'nutrition' => $nutrition,
            ]);

            return $pdf->download("menu-{$menu->id}-nutrition-report.pdf");
        }

        return view('nutrition-reports.menu', compact('menu', 'nutrition'));
    }

    /**
     * Generate school weekly nutrition report
     */
    public function schoolWeeklyReport(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'week_number' => 'required|integer|min:1|max:53',
            'year' => 'required|integer|min:2024|max:2030',
        ]);

        $school = School::findOrFail($validated['school_id']);
        $weekNumber = $validated['week_number'];
        $year = $validated['year'];

        // Calculate nutrition for the week
        $nutrition = $this->nutritionCalculator->calculateSchoolWeeklyNutrition(
            $school,
            $weekNumber,
            $year
        );

        // Get calendars for the week
        $calendars = SchoolCalendar::where('school_id', $school->id)
            ->where('week_number', $weekNumber)
            ->where('year', $year)
            ->with('menu')
            ->orderBy('date')
            ->get();

        if ($request->has('format') && $request->format === 'pdf') {
            $pdf = Pdf::loadView('nutrition-reports.school-weekly-pdf', [
                'school' => $school,
                'weekNumber' => $weekNumber,
                'year' => $year,
                'nutrition' => $nutrition,
                'calendars' => $calendars,
            ]);

            return $pdf->download("school-{$school->id}-week-{$weekNumber}-{$year}-report.pdf");
        }

        return view('nutrition-reports.school-weekly', compact(
            'school',
            'weekNumber',
            'year',
            'nutrition',
            'calendars'
        ));
    }

    /**
     * Generate system-wide weekly benefits report
     */
    public function weeklyBenefitsReport(Request $request)
    {
        $validated = $request->validate([
            'week_number' => 'required|integer|min:1|max:53',
            'year' => 'required|integer|min:2024|max:2030',
        ]);

        $weekNumber = $validated['week_number'];
        $year = $validated['year'];

        // Calculate total benefits
        $benefits = $this->nutritionCalculator->calculateNextWeekTotalBenefits($weekNumber, $year);

        // Get all schools with calendars for this week
        $schools = School::where('is_active', true)
            ->whereHas('calendars', function ($query) use ($weekNumber, $year) {
                $query->where('week_number', $weekNumber)
                    ->where('year', $year)
                    ->where('day_status', 'receive');
            })
            ->withCount(['calendars as receive_count' => function ($query) use ($weekNumber, $year) {
                $query->where('week_number', $weekNumber)
                    ->where('year', $year)
                    ->where('day_status', 'receive');
            }])
            ->get();

        if ($request->has('format') && $request->format === 'pdf') {
            $pdf = Pdf::loadView('nutrition-reports.weekly-benefits-pdf', [
                'weekNumber' => $weekNumber,
                'year' => $year,
                'benefits' => $benefits,
                'schools' => $schools,
            ]);

            return $pdf->download("weekly-benefits-week-{$weekNumber}-{$year}.pdf");
        }

        return view('nutrition-reports.weekly-benefits', compact(
            'weekNumber',
            'year',
            'benefits',
            'schools'
        ));
    }

    /**
     * Compare multiple menus nutrition
     */
    public function compareMenus(Request $request)
    {
        $validated = $request->validate([
            'menu_ids' => 'required|array|min:2',
            'menu_ids.*' => 'exists:menus,id',
        ]);

        $menuIds = $validated['menu_ids'];
        $nutritionComparison = $this->nutritionCalculator->calculateMultipleMenusNutrition($menuIds);

        if ($request->has('format') && $request->format === 'pdf') {
            $pdf = Pdf::loadView('nutrition-reports.menu-comparison-pdf', [
                'nutritionComparison' => $nutritionComparison,
            ]);

            return $pdf->download("menu-comparison-report.pdf");
        }

        return view('nutrition-reports.menu-comparison', compact('nutritionComparison'));
    }
}
