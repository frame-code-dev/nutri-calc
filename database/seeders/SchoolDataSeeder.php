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
        // 0: Nama PIC, 1: Jabatan PIC, 2: Nama Satuan Pendidikan, 3: Alamat, 4: Besaran Insentif per Hari, 
        // 5: Frekuensi Penyerahan, 6: Jumlah Hari Kerja, 7: Kepala Sekolah
        // 8: Porsi Kecil, 9: Porsi Besar, 10: Guru + Tendik (atau Kader)
        $csvData = [
            // --- SEKOLAH ---
            ['Umi Hanik', 'PIC Sekolah', 'SMP Islam Al Mukarromah', 'Jl. Indra Giri, Kec. Kanigaran, Kota Probolinggo', 20000, '2 (dua) kali dalam sebulan', 6, 'Umi Hanik', 0, 61, 11],
            ['St Fitratul Mukrimah', 'PIC Sekolah', 'KB Al Ishlah', 'Jl. Musi', 20000, '2 (dua) kali dalam sebulan', 6, 'St Fitratul Mukrimah', 24, 3, 3],
            ['Nur Faizah', 'PIC Sekolah', 'MI Nurul Ulum', 'Jl. Bengawan Solo No. 82 RT 02 RW 01', 30000, '2 (dua) kali dalam sebulan', 6, 'Ayyul Fariqoinih', 64, 56, 12],
            ['Kezia Setiawati', 'PIC Sekolah', 'TK Pelangi', 'Jl. Bengawan Solo No. 20', 20000, '2 (dua) kali dalam sebulan', 6, 'Kezia Setiawati', 73, 6, 6],
            ['Siti Rohmah Syamsuri', 'PIC Sekolah', 'KB Setia Kawan', 'Jl. Serayu No. 68', 20000, '2 (dua) kali dalam sebulan', 6, 'Endang Sundari', 49, 4, 4],
            ['Ahmad Husen', 'PIC Sekolah', 'MTs Miftahul Ulum', 'Jl. Musi No 25', 20000, '2 (dua) kali dalam sebulan', 6, 'Ahmad Muslim', 0, 60, 12],
            ['Usmiatin', 'PIC Sekolah', 'MI Miftahul Ulum', 'Jl. Musi No 25', 30000, '2 (dua) kali dalam sebulan', 6, 'Achmad Taufiq', 86, 118, 18],
            ['Aulia Putri Aisah Rani', 'PIC Sekolah', 'SDN Jrebeng Kulon I', 'Jl. Serayu No. 67', 30000, '2 (dua) kali dalam sebulan', 6, 'Ph. Maria Magdalena Sari', 91, 116, 12],
            ['Khoirun Nisa\'', 'PIC Sekolah', 'RA Al Hakim', 'Jl. Indra Giri', 20000, '2 (dua) kali dalam sebulan', 6, 'Kholifatul Hakimah', 26, 2, 2],
            ['Tutik Hidayatul Kiftah', 'PIC Sekolah', 'TK Auladina', 'Jl. Bengawan Solo No. 82', 20000, '2 (dua) kali dalam sebulan', 6, 'Tutik Hidayatul Kiftah', 43, 6, 6],
            ['Ummu Kulsum', 'PIC Sekolah', 'KB TK AL- Jannah', 'Jl. Progo RT. 002 RW. 003', 40000, '2 (dua) kali dalam sebulan', 6, 'Ummu Kulsum', 43, 5, 5],
            ['Linawati', 'PIC Sekolah', 'KB RA Miftahul Ulum', 'Jl. Musi No 25', 20000, '2 (dua) kali dalam sebulan', 6, 'Luluk Mukarramah', 42, 6, 6],
            ['Suviawati', 'PIC Sekolah', 'Paud Ceria', 'Griya Prasaja Mulya No. dd 15', 20000, '2 (dua) kali dalam sebulan', 6, 'Dewi Rosita M, S.Pd.', 54, 10, 10],

            // --- POSYANDU ---
            ['Susiati', 'PIC Posyandu', 'Posyandu Melati', 'Jl. Progo RT 3 RW 3', 1000, '2 (dua) kali dalam sebulan', 2, 'Susiati', 54, 27, 6],
            ['Eka', 'PIC Posyandu', 'Posyandu Dahlia', 'Jl. Progo RT 3 RW 3', 1000, '2 (dua) kali dalam sebulan', 2, 'Wiwik Mujiati', 69, 40, 5],
            ['Dessy Novayanti', 'PIC Posyandu', 'Posyandu Mawar Perum', 'Jl. Serayu Perum Hesni Regency 2 A15', 1000, '2 (dua) kali dalam sebulan', 2, 'Juwati Indriana', 44, 27, 7],
        ];

        DB::beginTransaction();
        try {
            foreach ($csvData as $row) {
                // Parse Data
                $coordinatorName = trim($row[0]);
                $position = trim($row[1]);
                $schoolName = trim($row[2]);
                $address = trim($row[3]);
                $dailyIncentive = (int)$row[4];
                $frequency = trim($row[5]);
                $workDays = (int)$row[6];
                $principalName = trim($row[7]);
                
                // Extract portions and detect type
                $smallPortion = (int)$row[8];
                $largePortion = (int)$row[9];
                $teacherCount = (int)$row[10];
                $type = str_contains(strtolower($schoolName), 'posyandu') ? 'posyandu' : 'sekolah';
                
                // Student count is typically total PM (Small + Large) minus the Teachers (since Large includes Teachers in some cases based on image 1)
                $totalPM = $smallPortion + $largePortion;
                $studentCount = max(0, $totalPM - $teacherCount);

                // 1. Create/Update School
                $school = School::updateOrCreate(
                    ['name' => $schoolName],
                    [
                        'address' => $address,
                        'type' => $type,
                        'student_count' => $studentCount,
                        'small_portion_count' => $smallPortion,
                        'large_portion_count' => $largePortion,
                        'teacher_count' => $teacherCount,
                        'daily_incentive' => $dailyIncentive,
                        'incentive_frequency' => $frequency,
                        'work_days' => $workDays,
                        'principal_name' => $principalName,
                        'is_active' => true,
                    ]
                );

                // 2. Create/Update Coordinator User
                $email = str_replace([' ', "'", ".", ","], '', strtolower($coordinatorName)) . '@mbg.id';
                
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $coordinatorName,
                        'password' => Hash::make('password'), 
                        'email_verified_at' => now(),
                    ]
                );
                
                // Using try catch to prevent error if RolePermissionSeeder hasn't run
                try {
                    if (class_exists(\Spatie\Permission\Models\Role::class)) {
                        $user->assignRole('Koordinator Sekolah');
                    }
                } catch (\Exception $e) {
                    // Ignore missing role error if any
                }

                // 3. Link them in SchoolCoordinator
                SchoolCoordinator::updateOrCreate(
                    [
                        'school_id' => $school->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'name' => $coordinatorName,
                        'position' => $position,
                        'whatsapp_number' => '00000000000', // Default empty since not in image
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
