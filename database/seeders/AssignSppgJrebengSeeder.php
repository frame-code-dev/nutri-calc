<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignSppgJrebengSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      protected array $tables = [
        'categories',
        'distribution_units',
        'kloters',
        'menu_items',
        'menu_schedules',
        'menus',
        'procurements',
        'rab_details',
        'rabs',
        'raw_material_nutritions',
        'raw_materials',
        'relawans',
        'salary_periods',
        'salary_settings',
        'school_calendars',
        'school_coordinators',
        'school_distributions',
        'school_weekly_statuses',
        'schools',
        'stocks',
        'suppliers',
        'weekly_locks',
    ];
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $sppg = DB::table('master_sppgs')
                ->where('name', 'SPPG KEDOPOK JREBENG KULON 02')
                ->first();

            if (!$sppg) {
                throw new \Exception('SPPG tidak ditemukan.');
            }

            foreach ($this->tables as $table) {
                DB::table($table)
                    ->whereNull('sppg_id')
                    ->update([
                        'sppg_id' => $sppg->id
                    ]);
            }

            DB::commit();

            $this->command->info('Assign SPPG KEDOPOK JREBENG KULON 02 berhasil.');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}
