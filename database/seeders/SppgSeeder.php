<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SppgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sppg = \App\Models\MasterSppg::updateOrCreate([
            'name' => 'SPPG Sadeng Ponggok Blitar'
        ],[
            'name' => 'SPPG Sadeng Ponggok Blitar',
            'instagram' => 'sppgsadengkarangbendo',
            'tiktok' => 'sppgsadengkarangbendo',
        ]);

        // Assign all current users to this SPPG
        \App\Models\User::where('name','!=','Super Admin')->update(['sppg_id' => $sppg->id]);
    }
}
