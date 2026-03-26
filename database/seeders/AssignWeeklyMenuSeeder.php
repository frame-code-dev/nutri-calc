<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\SchoolCalendar;
use App\Models\MenuSchedule;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
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
        // Gunakan timezone WIB (Asia/Jakarta) agar perhitungan minggu sesuai waktu Indonesia
        $weeksToSeed = [
            Carbon::now('Asia/Jakarta'),           // This Week
            Carbon::now('Asia/Jakarta')->addWeek() // Next Week
        ];

        // 1. Get active schools
        $schools = School::where('is_active', true)->get();
        if ($schools->isEmpty()) {
            $this->command->warn('⚠️ No active schools found. Please run SchoolSeeder first.');
            return;
        }

        // 2. Get available packet menus
        $allMenus = Menu::where('is_active', true)->where('category', 'packet')->get();
        if ($allMenus->isEmpty()) {
            $this->command->warn('⚠️ No active packet menus found. Please run MenuSeeder first.');
            return;
        }

        DB::beginTransaction();
        try {
            // Find a valid admin/superadmin user to assign as creator
            $adminUser = User::where('email', 'admin@mbg.id')->first() 
                      ?? User::where('email', 'superadmin@mail.com')->first() 
                      ?? User::first();
            
            if (!$adminUser) {
                $this->command->error('❌ No user found to assign as creator.');
                return;
            }

            $suppliers = Supplier::all();

            foreach ($weeksToSeed as $weekStart) {
                // Ensure we start on Monday
                $startOfWeek = $weekStart->copy()->startOfWeek(Carbon::MONDAY);
                
                // Get Mon-Sat for this specific week (6 days)
                $days = [];
                for ($i = 0; $i < 6; $i++) {
                    $days[] = $startOfWeek->copy()->addDays($i);
                }

                $this->command->info('📅 Seeding Menu, Status & Stock for Week: ' . $startOfWeek->format('d M Y'));

                foreach ($days as $date) {
                    $dateStr = $date->format('Y-m-d');
                    
                    // 1. Choose a random menu for THIS day globally
                    $randomMenu = $allMenus->random();
                    
                    MenuSchedule::updateOrCreate(
                        ['date' => $dateStr],
                        [
                            'menu_id' => $randomMenu->id,
                            'description' => 'Auto-assigned via seeder',
                            'created_by' => $adminUser->id,
                        ]
                    );

                    // 2. Seed some random Stock IN for materials in this menu to make analytics interesting
                    if ($suppliers->isNotEmpty()) {
                        foreach ($randomMenu->allMenuItems() as $item) {
                            // 50% chance to add stock for this material on this day or previous days
                            if (rand(1, 2) === 1) {
                                Stock::create([
                                    'raw_material_id' => $item->raw_material_id,
                                    'supplier_id' => $suppliers->random()->id,
                                    'type' => 'in',
                                    'quantity' => rand(50000, 200000), // 50-200 units (assumes g/ml usually)
                                    'notes' => 'Restock otomatis seeder',
                                    'transaction_date' => $date->copy()->subDays(rand(0, 3)),
                                    'created_by' => $adminUser->id,
                                ]);
                            }
                        }
                    }
                    
                    // 3. Assign to Individual School Calendars
                    foreach ($schools as $school) {
                        
                        // Randomize Status: 90% Receive, 10% Holiday
                        $status = (rand(1, 10) > 1) ? 'receive' : 'holiday';
                        
                        // Calculate portions based on status
                        if ($status === 'receive') {
                            $portionCount = ($school->student_count ?? 0);
                            $small = $school->small_portion_count ?? 0;
                            $large = $school->large_portion_count ?? 0;
                            $menuId = $randomMenu->id;
                        } else {
                            $portionCount = 0;
                            $small = 0;
                            $large = 0;
                            $menuId = null;
                        }

                        SchoolCalendar::updateOrCreate(
                            [
                                'school_id' => $school->id,
                                'date' => $dateStr,
                            ],
                            [
                                'day_status' => $status,
                                'menu_id' => $menuId,
                                'portion_count' => $portionCount,
                                'small_portion_count' => $small,
                                'large_portion_count' => $large,
                                'week_number' => $date->isoWeek,
                                'year' => $date->isoWeekYear(),
                            ]
                        );
                    }
                }
            }
            
            DB::commit();
            $this->command->info('✅ Successfully assigned random menus, statuses, and stock to ' . $schools->count() . ' schools.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Failed to assign: ' . $e->getMessage());
        }
    }
}
