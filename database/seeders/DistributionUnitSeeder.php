<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistributionUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\DistributionUnit::updateOrCreate(['code' => 'IPAN'], ['name' => 'IPAN']);
        \App\Models\DistributionUnit::updateOrCreate(['code' => 'DANA'], ['name' => 'DANA']);    }
}
