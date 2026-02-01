<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Super Admin
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');

        // 2. Admin MBG
        $adminMBG = User::create([
            'name' => 'Admin MBG Pusat',
            'email' => 'sppgkarangbendo@gmail.com',
            'password' => Hash::make('123'),
            'email_verified_at' => now(),
        ]);
        $adminMBG->assignRole('Admin MBG');

        // 3. Koordinator Sekolah (Multiple)
        $koordinatorSekolah1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.koordinator@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $koordinatorSekolah1->assignRole('Koordinator Sekolah');

        $koordinatorSekolah2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti.koordinator@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $koordinatorSekolah2->assignRole('Koordinator Sekolah');

        $koordinatorSekolah3 = User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad.koordinator@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $koordinatorSekolah3->assignRole('Koordinator Sekolah');

        // 4. Koordinator Dapur
        $koordinatorDapur = User::create([
            'name' => 'Ibu Fatimah',
            'email' => 'fatimah.dapur@mbg.id',
            'phone' => '6281234567890',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $koordinatorDapur->assignRole('Koordinator Dapur');

        $koordinatorDapur2 = User::create([
            'name' => 'Pak Joko',
            'email' => 'joko.dapur@mbg.id',
            'phone' => '6281298765432',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $koordinatorDapur2->assignRole('Koordinator Dapur');

        // 5. Supplier
        $supplier1 = User::create([
            'name' => 'CV Sumber Rezeki',
            'email' => 'supplier1@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $supplier1->assignRole('Supplier');

        $supplier2 = User::create([
            'name' => 'PT Makmur Jaya',
            'email' => 'supplier2@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $supplier2->assignRole('Supplier');

        // 6. Ahli Gizi
        $ahliGizi = User::create([
            'name' => 'Ibu Ratna',
            'email' => 'ratna.gizi@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $ahliGizi->assignRole('Ahli Gizi');
    }
}
