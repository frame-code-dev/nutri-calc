<?php

namespace Database\Seeders;

use App\Models\MasterSppg;
use App\Models\Relawan;
use App\Models\SalaryDetail;
use App\Models\SalaryPeriod;
use App\Models\SalarySetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SalaryPeriodMarchSeeder extends Seeder
{
    public function run()
    {
        $sppg = MasterSppg::first();
        if (! $sppg) {
            $sppg = MasterSppg::create([
                'name' => 'SATUAN PELAYANAN PEMENUHAN GIZI KEDOPOK JREBENG KULON 02',
                'alamat' => '-',
                'status' => 'Aktif',
            ]);
        }

        // 1. Definisikan Periode: 16 - 28 Maret 2026
        $start = Carbon::create(2026, 3, 16);
        $end = Carbon::create(2026, 3, 28);

        $period = SalaryPeriod::create([
            'sppg_id' => $sppg->id,
            'nama_periode' => 'Periode 16 - 28 Maret 2026',
            'tipe' => 'mingguan',
            'tanggal_mulai' => $start,
            'tanggal_selesai' => $end,
            'periode_ke' => 1,
            'instansi' => $sppg->name,
            'penandatangan_1' => 'Mentari Citra Aura J, A.Md. Ak.',
            'penandatangan_2' => 'Ilyas Syams Sentosa, S.P.',
        ]);

        // 2. Data Relawan (sesuai gambar)
        $dataRelawan = Relawan::where('sppg_id', $sppg->id)->get();

        // 3. Pastikan Setting Upah ada
        foreach (['Asisten Lapangan', 'Chef', 'Koordinator Persiapan Bahan', 'Persiapan Bahan Makanan', 'Produksi/Masak', 'Distribusi', 'Tenaga Keamanan'] as $jab) {
            $upah = 100000;
            if ($jab === 'Asisten Lapangan') {
                $upah = 200000;
            }
            if ($jab === 'Chef') {
                $upah = 150000;
            }

            SalarySetting::firstOrCreate(
                ['jabatan' => $jab, 'sppg_id' => $sppg->id],
                ['upah_per_hari' => $upah]
            );
        }

        // 4. Generate detail absensi
        foreach ($dataRelawan as $index => $rData) {
            $relawan = Relawan::firstOrCreate(
                ['nama' => $rData['nama'], 'sppg_id' => $sppg->id],
                ['jabatan' => $rData['jabatan'], 'tipe' => 'tetap', 'nomor_urut' => $index + 1, 'aktif' => true]
            );

            $setting = SalarySetting::where('jabatan', $relawan->jabatan)->first();
            $upahDefault = $setting ? $setting->upah_per_hari : 100000;

            $hariKerjaArr = [];
            $curr = $start->copy();
            while ($curr->lte($end)) {
                if (! $curr->isSunday()) {
                    $dateKey = $curr->format('Y-m-d');
                    $val = $upahDefault;

                    // Logika "Merah = Izin/OFF (0)" & "Kosong = 0"
                    // Rizky (Selalu hadir)
                    if ($relawan->nama === 'Rizky Putra D') {
                        $val = $upahDefault;
                    }
                    // Asep Bagas S
                    elseif ($relawan->nama === 'Asep Bagas S') {
                        // M1: 16-17 isi, 18-21 kosong
                        if ($curr->between('2026-03-18', '2026-03-21')) {
                            $val = 0;
                        }
                        // M2: 23-24 isi, 25-26 merah (OFF), 27-28 isi
                        if ($curr->between('2026-03-25', '2026-03-26')) {
                            $val = 0;
                        }
                    }
                    // Nurul Fatimah
                    elseif ($relawan->nama === 'Nurul Fatimah') {
                        // 16-18 isi, 19-21 kosong
                        if ($curr->between('2026-03-19', '2026-03-21')) {
                            $val = 0;
                        }
                    }
                    // Achmad Al Amin
                    elseif ($relawan->nama === 'Achmad Al Amin') {
                        // M2: 25-28 merah (IZIN)
                        if ($curr->between('2026-03-25', '2026-03-28')) {
                            $val = 0;
                        }
                    }
                    // Default logic for others
                    else {
                        // Random bolong di Minggu ke-1 (biru tua di gambar biasanya kosong/izin/bebas)
                        if ($curr->between(Carbon::create(2026, 3, 16), Carbon::create(2026, 3, 21)) && $index > 3 && $curr->day % 3 == 0) {
                            $val = 0;
                        }
                    }

                    $hariKerjaArr[$dateKey] = $val;
                }
                $curr->addDay();
            }

            $totalHari = collect($hariKerjaArr)->filter(fn ($v) => (float) $v > 0)->count();
            $totalUpah = collect($hariKerjaArr)->map(fn ($v) => (float) $v)->sum();

            SalaryDetail::create([
                'period_id' => $period->id,
                'relawan_id' => $relawan->id,
                'hari_kerja' => $hariKerjaArr,
                'total_hari' => $totalHari,
                'upah_per_hari' => $upahDefault,
                'total_upah' => $totalUpah,
            ]);
        }
    }
}
