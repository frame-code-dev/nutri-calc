<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\SchoolCoordinator;
use App\Models\User;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get coordinator users
        $koordinator1 = User::where('email', 'budi.koordinator@mbg.id')->first();
        $koordinator2 = User::where('email', 'siti.koordinator@mbg.id')->first();
        $koordinator3 = User::where('email', 'ahmad.koordinator@mbg.id')->first();

        // School 1: SDN Merdeka 01
        $school1 = School::create([
            'name' => 'SDN Merdeka 01',
            'address' => 'Jl. Pendidikan No. 15, Kecamatan Merdeka, Jakarta Pusat',
            'student_count' => 450,
            'is_active' => true,
        ]);

        // Coordinator for School 1
        SchoolCoordinator::create([
            'school_id' => $school1->id,
            'user_id' => $koordinator1->id,
            'name' => 'Budi Santoso',
            'position' => 'Kepala Sekolah',
            'whatsapp_number' => '081234567890',
            'is_active' => true,
        ]);

        // School 2: SDN Harapan Bangsa
        $school2 = School::create([
            'name' => 'SDN Harapan Bangsa',
            'address' => 'Jl. Pahlawan No. 22, Kecamatan Sejahtera, Jakarta Selatan',
            'student_count' => 380,
            'is_active' => true,
        ]);

        SchoolCoordinator::create([
            'school_id' => $school2->id,
            'user_id' => $koordinator2->id,
            'name' => 'Siti Aminah',
            'position' => 'Kepala Sekolah',
            'whatsapp_number' => '081298765432',
            'is_active' => true,
        ]);

        // School 3: SDN Cerdas Ceria
        $school3 = School::create([
            'name' => 'SDN Cerdas Ceria',
            'address' => 'Jl. Raya Pendidikan No. 88, Kecamatan Cerdas, Jakarta Timur',
            'student_count' => 520,
            'is_active' => true,
        ]);

        SchoolCoordinator::create([
            'school_id' => $school3->id,
            'user_id' => $koordinator3->id,
            'name' => 'Ahmad Wijaya',
            'position' => 'Kepala Sekolah',
            'whatsapp_number' => '081387654321',
            'is_active' => true,
        ]);

        // School 4: SDN Nusantara
        $school4 = School::create([
            'name' => 'SDN Nusantara',
            'address' => 'Jl. Bhinneka No. 45, Kecamatan Tunggal Ika, Jakarta Barat',
            'student_count' => 410,
            'is_active' => true,
        ]);

        // School 4 has additional coordinator
        SchoolCoordinator::create([
            'school_id' => $school4->id,
            'user_id' => null, // No user account yet
            'name' => 'Dewi Kusuma',
            'position' => 'Wakil Kepala Sekolah',
            'whatsapp_number' => '081456789012',
            'is_active' => true,
        ]);

        // School 5: SDN Gemilang
        $school5 = School::create([
            'name' => 'SDN Gemilang',
            'address' => 'Jl. Cahaya No. 77, Kecamatan Terang, Jakarta Utara',
            'student_count' => 350,
            'is_active' => true,
        ]);

        SchoolCoordinator::create([
            'school_id' => $school5->id,
            'user_id' => null,
            'name' => 'Rina Melati',
            'position' => 'Kepala Sekolah',
            'whatsapp_number' => '081567890123',
            'is_active' => true,
        ]);

        // School 6: SDN Tunas Harapan (Inactive for demo)
        $school6 = School::create([
            'name' => 'SDN Tunas Harapan',
            'address' => 'Jl. Masa Depan No. 33, Kecamatan Berkembang, Depok',
            'student_count' => 280,
            'is_active' => false, // Inactive school demo
        ]);

        SchoolCoordinator::create([
            'school_id' => $school6->id,
            'user_id' => null,
            'name' => 'Bambang Purnomo',
            'position' => 'Kepala Sekolah',
            'whatsapp_number' => '081678901234',
            'is_active' => false,
        ]);
    }
}
