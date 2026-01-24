<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\SchoolCalendar;
use App\Models\MenuSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignWeeklyMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TARGET: Seed CURRENT week AND NEXT week to ensure visibility
        $weeksToSeed = [
            Carbon::now(),           // This Week
            Carbon::now()->addWeek() // Next Week
        ];

        // 1. Get active schools
        $schools = School::where('is_active', true)->get();
        if ($schools->isEmpty()) {
            $this->command->warn('⚠️ No active schools found. Please run SchoolSeeder first.');
            return;
        }

        DB::beginTransaction();
        try {
            // Clean up existing MenuSchedule for these weeks to avoid stale data
            // (Optional, but cleaner given we are "resetting" to no menus)
            
            foreach ($weeksToSeed as $weekStart) {
                $startOfWeek = $weekStart->copy()->startOfWeek();
                
                // Get Mon-Sat for this specific week
                $days = [];
                $current = $startOfWeek->copy();
                while ($current->dayOfWeekIso <= 6) { // 1=Mon, 6=Sat
                    $days[] = $current->copy();
                    $current->addDay();
                }

                $this->command->info('📅 Seeding Statuses (No Menu) for Week: ' . $startOfWeek->format('d M Y'));

                foreach ($days as $date) {
                    
                    // Assign to Individual School Calendars
                    foreach ($schools as $school) {
                        
                        // Randomize Status: 90% Receive, 10% Holiday
                        $status = (rand(1, 10) > 1) ? 'receive' : 'holiday';
                        
                        // Calculate portions based on status
                        if ($status === 'receive') {
                            $portionCount = ($school->student_count ?? 0) + ($school->teacher_count ?? 0);
                            $small = $school->small_portion_count ?? 0;
                            $large = $school->large_portion_count ?? 0;
                        } else {
                            $portionCount = 0;
                            $small = 0;
                            $large = 0;
                        }

                        SchoolCalendar::updateOrCreate(
                            [
                                'school_id' => $school->id,
                                'date' => $date->format('Y-m-d'),
                            ],
                            [
                                'day_status' => $status,
                                'menu_id' => null, // Explicitly NULL as requested
                                'portion_count' => $portionCount,
                                'small_portion_count' => $small,
                                'large_portion_count' => $large,
                                'week_number' => $date->weekOfYear,
                                'year' => $date->year,
                            ]
                        );
                    }
                }
            }
            
            DB::commit();
            $this->command->info('✅ Successfully assigned random statuses (without menus) to ' . $schools->count() . ' schools.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Failed to assign statuses: ' . $e->getMessage());
        }
    }
}
