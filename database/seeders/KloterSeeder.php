<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KloterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table first to clear previous data
        DB::table('kloters')->truncate();

        $kloters = [
            [
                'name' => 'Kloter 1',
                'description' => 'Kloter 1',
                'date' => Carbon::now(),
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kloter 2',
                'description' => 'Kloter 2',
                'date' => Carbon::now(),
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kloter 3',
                'description' => 'Kloter 3',
                'date' => Carbon::now(),
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kloter 4',
                'description' => 'Kloter 4',
                'date' => Carbon::now(),
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('kloters')->insert($kloters);
    }
}
