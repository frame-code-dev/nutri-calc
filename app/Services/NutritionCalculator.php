<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\School;
use App\Models\SchoolCalendar;

class NutritionCalculator
{
    /**
     * Calculate total nutrition for a single menu
     *
     * @param Menu $menu
     * @return array
     */
    public function calculateMenuNutrition(Menu $menu): array
    {
        return $menu->calculateNutrition();
    }

    /**
     * Calculate total nutrition for a school for a specific week
     *
     * @param School $school
     * @param int $weekNumber
     * @param int $year
     * @return array
     */
    public function calculateSchoolWeeklyNutrition(School $school, int $weekNumber, int $year): array
    {
        $totals = [
            'energy' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrate' => 0,
            'fiber' => 0,
        ];

        // Get all calendars for this school in the specified week
        $calendars = SchoolCalendar::where('school_id', $school->id)
            ->where('week_number', $weekNumber)
            ->where('year', $year)
            ->where('day_status', 'receive')
            ->with('menu.menuItems.rawMaterial.nutrition')
            ->get();

        $daysWithFood = 0;

        foreach ($calendars as $calendar) {
            if ($calendar->menu) {
                $menuNutrition = $this->calculateMenuNutrition($calendar->menu);
                $portions = $calendar->portion_count ?? $school->student_count;

                // Add to totals (already per student)
                $totals['energy'] += $menuNutrition['energy'];
                $totals['protein'] += $menuNutrition['protein'];
                $totals['fat'] += $menuNutrition['fat'];
                $totals['carbohydrate'] += $menuNutrition['carbohydrate'];
                $totals['fiber'] += $menuNutrition['fiber'];
                
                $daysWithFood++;
            }
        }

        // Calculate averages
        $average = $daysWithFood > 0 ? array_map(fn($value) => round($value / $daysWithFood, 2), $totals) : $totals;

        // Return both weekly total and daily average
        return [
            'weekly_total' => array_map(fn($value) => round($value, 2), $totals),
            'daily_average' => $average,
            'active_days' => $daysWithFood,
        ];
    }

    /**
     * Calculate nutrition per portion for multiple menus
     *
     * @param array $menuIds
     * @return array
     */
    public function calculateMultipleMenusNutrition(array $menuIds): array
    {
        $results = [];

        $menus = Menu::whereIn('id', $menuIds)->with('menuItems.rawMaterial.nutrition')->get();

        foreach ($menus as $menu) {
            $results[] = [
                'menu' => $menu,
                'nutrition' => $this->calculateMenuNutrition($menu),
            ];
        }

        return $results;
    }

    /**
     * Calculate total nutrition benefits for next week
     *
     * @param int $weekNumber
     * @param int $year
     * @return array
     */
    public function calculateNextWeekTotalBenefits(int $weekNumber, int $year): array
    {
        $totals = [
            'total_students' => 0,
            'total_portions' => 0,
            'active_days' => 0,
            'total_nutrition' => [
                'energy' => 0,
                'protein' => 0,
                'fat' => 0,
                'carbohydrate' => 0,
                'fiber' => 0,
            ],
            'average_per_student' => [
                'energy' => 0,
                'protein' => 0,
                'fat' => 0,
                'carbohydrate' => 0,
                'fiber' => 0,
            ],
        ];

        $schools = School::where('is_active', true)->get();
        $totalDaysWithFood = 0;

        foreach ($schools as $school) {
            $schoolNutrition = $this->calculateSchoolWeeklyNutrition($school, $weekNumber, $year);
            
            $schoolPortions = SchoolCalendar::where('school_id', $school->id)
                ->where('week_number', $weekNumber)
                ->where('year', $year)
                ->where('day_status', 'receive')
                ->count();

            $totals['total_students'] += $school->student_count;
            $totals['total_portions'] += ($school->student_count * $schoolPortions);
            $totalDaysWithFood += $schoolNutrition['active_days'];
            
            // Add weekly totals
            $totals['total_nutrition']['energy'] += $schoolNutrition['weekly_total']['energy'];
            $totals['total_nutrition']['protein'] += $schoolNutrition['weekly_total']['protein'];
            $totals['total_nutrition']['fat'] += $schoolNutrition['weekly_total']['fat'];
            $totals['total_nutrition']['carbohydrate'] += $schoolNutrition['weekly_total']['carbohydrate'];
            $totals['total_nutrition']['fiber'] += $schoolNutrition['weekly_total']['fiber'];
        }

        // Calculate average per student
        if ($totals['total_students'] > 0) {
            foreach ($totals['total_nutrition'] as $key => $value) {
                $totals['average_per_student'][$key] = round($value / $totals['total_students'], 2);
            }
        }

        // Set active days
        $totals['active_days'] = $totalDaysWithFood > 0 ? round($totalDaysWithFood / max(count($schools), 1)) : 0;

        // Round totals
        $totals['total_nutrition'] = array_map(fn($value) => round($value, 2), $totals['total_nutrition']);

        return $totals;
    }
}
