<?php

namespace Database\Seeders;

use App\Models\MasterSppg;
use App\Models\Relawan;
use App\Models\SalarySetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GajiRelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. Ambil atau buat SPPG default
        $sppg = MasterSppg::first();
        if (! $sppg) {
            $sppg = MasterSppg::create([
                'name' => 'SATUAN PELAYANAN PEMENUHAN GIZI KEDOPOK JREBENG KULON 02',
                'alamat' => '-',
                'status' => 'Aktif',
            ]);
        }

        // Clean up lama
        DB::table('salary_components')->delete();
        DB::table('salary_details')->delete();
        DB::table('salary_periods')->delete();
        DB::table('salary_settings')->delete();

        $relawans = Relawan::all();

        // 3. Setting Upah (Asisten Lapangan = 200k, Chef = 150k, lainnya = 100k)
        $jabatans = collect($relawans)->pluck('jabatan')->unique();
        foreach ($jabatans as $jab) {
            $upah = 100000;
            if (strtolower($jab) === 'asisten lapangan') {
                $upah = 200000;
            }
            if (strtolower($jab) === 'chef') {
                $upah = 150000;
            }

            SalarySetting::create([
                'sppg_id' => $sppg->id,
                'jabatan' => $jab,
                'upah_per_hari' => $upah,
            ]);
        }

    }
}
