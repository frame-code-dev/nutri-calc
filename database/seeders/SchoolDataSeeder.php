<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Models\User;
use App\Models\SchoolCoordinator;

class SchoolDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1: Name, 2: Phone, 3: Koordinator, 4: Guru, 5: Porsi Kecil, 6: Porsi Besar, 7: Total
        $csvData = [
            ['TK Dharma Wanita 01 Sidorejo', '62857-3621-3892', 'Andayati', 1, 10, 0, 10],
            ['TK Dharma wanita 05 Sidorejo', '62856-4578-6815', 'Kayatun', 2, 26, 0, 26],
            ['TK Al hidayah 1 Bacem', '62858-1555-4402', 'Mar\' atus sholekah', 2, 40, 0, 40],
            ['TK Al hidayah 2 Bacem', '62823-3826-8001', 'Nurul Hidajati', 4, 84, 0, 84],
            ['TK Al Hidayah 2 Sidorejo', '62813-3487-7749', 'Desi Purwandari', 2, 34, 0, 34],
            ['Tk Al-hidayah 3 Sidorejo', '62857-3677-6535', 'Bambang', 3, 28, 0, 28],
            ['RA Al Irsyad Karangbendo', '62858-0453-1970', 'Leni Budiarti', 4, 46, 0, 46],
            ['RA Baitul Mutaqiin Sidorejo', '62857-4530-3802', 'Wiwik Mardiatul Rodyah', 4, 31, 0, 31],
            ['RA Nurul Huda', '62856-4855-7601', 'Qonikatur Napi\'ah', 5, 33, 0, 33],
            ['RA Annajiyah', '62857-9096-6411', 'Duwi fatma', 9, 92, 0, 92],
            ['KB Ben Iman Karangbendo', '62856-4909-5971', 'Indria Sutiwi', 1, 12, 0, 12],
            ['UPT SD Negri Sidorejo 01', '62812-3538-4262', 'yuliana', 9, 16, 22, 38],
            ['UPT SD Negri Sidorejo 03', '62857-4611-0178', 'Septy Diah S.', 10, 53, 73, 126],
            ['UPT SD Negri Sidorejo 04', '62813-3040-8443', 'Novita Ainin Jannah', 9, 20, 17, 37],
            ['UPT SD Negri Sidorejo 05', '62857-3115-8828', 'Maya Widya Arti', 15, 126, 123, 249],
            ['MI Mambalul Huda Sidorejo', '62857-1012-3818', 'Muhamad Sukron Fauzi', 14, 65, 88, 153],
            ['MI AL-Irsyad Karangbendo', '62856-4909-5971', 'Binti Rahayu', 25, 54, 79, 133],
            ['MI Darut Taqwa Sidorejo', '62857-9031-1107', 'Richa Roikhatun N', 10, 88, 69, 157],
            ['MI Nurul Huda', '62856-4855-7601', 'Nanik Ratnaningsih', 10, 58, 26, 84],
            ['MI Al Mahmud', '62857-2001-6188', 'Ika Susiloningsih', 0, 0, 500, 500],
            ['SMP Islam Al Irsyadiyah', '62856-4631-7639', 'Vivi Parnita Sari', 8, 0, 47, 47],
            ['SMP PGRI 02 Ponggok', '62857-8415-0174', 'Siti Maratus Solikah', 10, 0, 36, 36],
            ['MTs Al Mahmud', '62821-1070-2431', 'Yeni Rahmawati', 27, 0, 415, 415],
            ['MA Al Mahmud', '62', 'Zaimatul Muna', 6, 0, 26, 26],
            ['MI Ma\'arif Bacem', '62857-3667-1718', 'Lukman Azis', 20, 93, 87, 180],
            ['MTs Ma\'arif Bacem', '62856-4951-2502', 'Muhamad Darul Khoiri', 20, 0, 146, 146],
        ];

        DB::beginTransaction();
        try {
            foreach ($csvData as $row) {
                // Parse Data
                $schoolName = trim($row[0]);
                $phone = preg_replace('/[^0-9]/', '', $row[1]); // Clean phone
                if (substr($phone, 0, 2) === '62') {
                    $phone = '0' . substr($phone, 2); // format 08xx
                }
                
                $coordinatorName = trim($row[2]);
                $teacherCount = (int)$row[3];
                $smallPortion = (int)$row[4];
                $largePortion = (int)$row[5];
                
                // Total Beneficiaries (Students) = PK + PB
                $totalStudents = $smallPortion + $largePortion;

                // 1. Create/Update School
                $school = School::updateOrCreate(
                    ['name' => $schoolName],
                    [
                        'address' => 'Sidorejo / Bacem / Karangbendo / Ponggok', // Default address based on context
                        'student_count' => $totalStudents,
                        'teacher_count' => $teacherCount,
                        'small_portion_count' => $smallPortion,
                        'large_portion_count' => $largePortion,
                        'is_active' => true,
                    ]
                );

                // 2. Create/Update Coordinator User
                // Use phone number or name to create unique email/username
                $email = str_replace([' ', "'", "."], '', strtolower($coordinatorName)) . '@mbg.id';
                
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $coordinatorName,
                        'phone' => $phone,
                        'password' => Hash::make('password'), // Default password
                        'email_verified_at' => now(),
                    ]
                );
                
                // Assign role (assuming RolePermissionSeeder has run)
                // $user->assignRole('Koordinator');

                // 3. Link them in SchoolCoordinator
                SchoolCoordinator::updateOrCreate(
                    [
                        'school_id' => $school->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'name' => $coordinatorName,
                        'position' => 'Koordinator',
                        'whatsapp_number' => $phone,
                        'is_active' => true,
                    ]
                );
            }
            
            DB::commit();
            $this->command->info('Successfully imported ' . count($csvData) . ' schools and coordinators.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error importing schools: ' . $e->getMessage());
        }
    }
}
