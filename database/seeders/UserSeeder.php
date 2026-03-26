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
        // 1. Super Admin (Developer)
        $superAdmin = User::updateOrCreate(['username' => 'devoper'], [
            'name' => 'devoper',
            'email' => 'devoper@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');

        // 2. Akuntan
        $akuntan = User::updateOrCreate(['username' => 'mentari'], [
            'name' => 'Mentari Citra Aura J, A.Md. Ak.',
            'email' => 'mentari@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $akuntan->assignRole('Admin MBG');

        // 3. Aslap (Admin MBG)
        $aslap = User::updateOrCreate(['username' => 'rizky'], [
            'name' => 'Rizky Putra D',
            'email' => 'rizky@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $aslap->assignRole('Admin MBG');

        // 4. Ketua SPPG
        $ketuaSppg = User::updateOrCreate(['username' => 'ilyas'], [
            'name' => 'Ilyas Syams Sentosa, S.P.',
            'email' => 'ilyas@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $ketuaSppg->assignRole('Admin MBG');

        // 5. Ahli Gizi
        $ahliGizi = User::updateOrCreate(['username' => 'cici'], [
            'name' => 'cici',
            'email' => 'cici@mbg.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $ahliGizi->assignRole('Ahli Gizi');
    }
}
