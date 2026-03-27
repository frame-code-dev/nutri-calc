<?php

namespace Database\Seeders;

use App\Models\MasterSppg;
use App\Models\Relawan;
use App\Models\SalaryComponent;
use App\Models\SalaryDetail;
use App\Models\SalaryPeriod;
use App\Models\SalarySetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalaryPeriodMarchSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Truncate existing data (Clean Slate - PostgreSQL compatible)
        DB::table('salary_components')->truncate();
        DB::table('salary_details')->truncate();
        // Since salary_periods has foreign key dependencies from salary_details, 
        // and we already truncated salary_details, we can now truncate salary_periods.
        // In PostgreSQL, TRUNCATE on a table with FKs needs CASCADE or the order must be correct.
        DB::statement('TRUNCATE salary_periods CASCADE');

        $sppg = MasterSppg::first();
        if (!$sppg) {
            $sppg = MasterSppg::create([
                'name' => 'SATUAN PELAYANAN PEMENUHAN GIZI KEDOPOK JREBENG KULON 02',
                'alamat' => '-',
                'status' => 'Aktif',
            ]);
        }

        // 2. Definisikan Periode: 16 - 28 Maret 2026
        $start = Carbon::create(2026, 3, 16);
        $end = Carbon::create(2026, 3, 28);

        $period = SalaryPeriod::create([
            'sppg_id' => $sppg->id,
            'nama_periode' => 'Periode 16 - 28 Maret 2026',
            'tipe' => 'mingguan',
            'tanggal_mulai' => $start->toDateString(),
            'tanggal_selesai' => $end->toDateString(),
            'periode_ke' => 1,
            'instansi' => $sppg->name,
            'penandatangan_1' => 'Mentari Citra Aura J, A.Md. Ak.',
            'penandatangan_2' => 'Ilyas Syams Sentosa, S.P.',
        ]);

        // 3. Pastikan Setting Upah ada
        $settingsData = [
            'Asisten Lapangan' => 200000,
            'Chef' => 150000,
            'Koordinator Persiapan Bahan' => 100000,
            'Persiapan Bahan Makanan' => 100000,
            'Produksi/Masak' => 100000,
            'Distribusi' => 100000,
            'Tenaga Keamanan' => 100000,
            'Cuci Bagor' => 100000, // Added this one as it's common in image
            'Pemanas' => 100000,
        ];

        foreach ($settingsData as $jab => $upah) {
            SalarySetting::updateOrCreate(
                ['jabatan' => $jab, 'sppg_id' => $sppg->id],
                ['upah_per_hari' => $upah]
            );
        }

        $relawans = Relawan::where('aktif', true)->orderBy('nomor_urut')->get();

        foreach ($relawans as $index => $relawan) {
            $setting = SalarySetting::where('jabatan', $relawan->jabatan)->first();
            $upahDefault = $setting ? (float)$setting->upah_per_hari : 100000;
 
            $hariKerjaArr = [];
            $components = [];
            $curr = $start->copy();
            
            while ($curr->lte($end)) {
                if (!$curr->isSunday()) {
                    $dateKey = $curr->format('Y-m-d');
                    $day = (int)$curr->day;
                    $isBlueTerritory = $curr->between(Carbon::create(2026, 3, 18), Carbon::create(2026, 3, 24));
                    
                    $val = 0; 
                    $isTunjangan = false;
 
                    // Baseline: White days (16, 17, 25, 26, 27, 28)
                    if ($day <= 17 || $day >= 25) {
                        $val = $upahDefault;
                    }

                    // Specific Patterns for Blue & Red
                    if ($relawan->nama === 'Rizky Putra Dinasti') {
                        // Rizky: ALL FILL
                        $val = $upahDefault; 
                        if ($isBlueTerritory) $isTunjangan = true;
                    } 
                    elseif ($relawan->nama === 'Asep Bagas S') {
                        // Asep: 18-21 blue empty, 23-24 red izin
                        if ($day >= 23 && $day <= 24) $val = '0';
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Nurul Fatimah') {
                        // Nurul: 18 (isi), others blue empty
                        if ($day == 18) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Yuliati') {
                        // Yuliati: 19 (isi), others blue empty
                        if ($day == 19) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Wiwin Herlina') {
                        // Wiwin: 20 (isi), others blue empty
                        if ($day == 20) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Deni Nova Novita') {
                        // Deni: 18 (isi), others blue empty
                        if ($day == 18) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Achmad Al Amin') {
                        // Achmad: 23-24 Red, others blue empty
                        if ($day >= 23 && $day <= 24) $val = '0';
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Mistin Budi' || $relawan->nama === 'Ninin Budi') {
                        // Ninin: 19 (isi)
                        if ($day == 19) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Henawati') {
                        // Henawati: 20 (isi)
                        if ($day == 20) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Antik Ariniasjah') {
                        // Antik: 18 (isi)
                        if ($day == 18) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Ali Syahbana') {
                        if ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Halimatus Sa\'diyah') {
                        // Halimatus (8 hari): 18, 19 (isi)
                        if ($day == 18 || $day == 19) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Restu Hadi P') {
                        // Restu: 20 (isi)
                        if ($day == 20) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif (str_contains($relawan->nama, 'Munir Arifin')) {
                        // Munir: 21 (isi)
                        if ($day == 21) { $val = $upahDefault; $isTunjangan = true; }
                        elseif ($isBlueTerritory) $val = '';
                    }
                    elseif ($relawan->nama === 'Hermanto') {
                         if ($day < 25) $val = '0'; // Red range
                    }
                    elseif (str_contains($relawan->nama, 'Arifianto')) {
                        if ($day == 23) $val = '0'; // Red
                        elseif ($isBlueTerritory) $val = ''; // Blue empty
                    }
                    elseif ($relawan->nama === 'Untung') {
                        // 16, 17, 20, 21, 23, 24, 25, 26, 27, 28 (Total 10)
                        if (in_array($day, [16, 17, 20, 21, 23, 24, 25, 26, 27, 28])) {
                             $val = $upahDefault;
                             if ($isBlueTerritory) $isTunjangan = true;
                        } else {
                             $val = '';
                        }
                    }
                    else {
                        // Default Others: White present, Blue rotated 1 day
                        if ($isBlueTerritory) {
                             if ($index % 5 == ($day % 5)) { $val = $upahDefault; $isTunjangan = true; }
                             else { $val = ''; }
                        }
                    }
 
                    // Store ALL in hari_kerja so it shows in UI grid
                    $hariKerjaArr[$dateKey] = $val;

                    // Also store in components if it's Tunjangan (for the breakdown)
                    if ($isTunjangan && $val > 0) {
                        $components[] = [
                            'nama' => 'Tunjangan',
                            'jumlah' => $val,
                            'tanggal' => $dateKey
                        ];
                    }
                }
                $curr->addDay();
            }
 
            $totalHari = collect($hariKerjaArr)->filter(fn($v) => (float)$v > 0)->count();
            // Note: In this version, totalHari is just count of hari_kerja > 0 
            // because we double-stored Tunjangan in hari_kerja for UI reasons.
            
            $totalUpahBase = collect($hariKerjaArr)->map(fn($v) => (float)$v)->sum();
            // total_upah should be sum of hari_kerja. 
            // (Components are just a breakdown now, not additional money)

            $salaryDetail = SalaryDetail::create([
                'period_id' => $period->id,
                'relawan_id' => $relawan->id,
                'hari_kerja' => $hariKerjaArr,
                'total_hari' => $totalHari,
                'upah_per_hari' => $upahDefault,
                'total_upah' => $totalUpahBase,
            ]);
 
            foreach ($components as $c) {
                SalaryComponent::create(array_merge($c, ['detail_id' => $salaryDetail->id]));
            }
        }
    }
}
