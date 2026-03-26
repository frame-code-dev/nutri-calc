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
        DB::table('relawans')->delete();

        // 2. Data Master Relawan sesuai struktur gambar
        // Eko Purwanto (450k/6 = 75k), Rizky Putra D (1200k/6 = 200k), Rina Mulyani (950k)
        $relawans = [
            ['nama' => 'Rizky Putra D', 'jabatan' => 'Asisten Lapangan', 'tipe' => 'tetap', 'nomor_urut' => 1],
            ['nama' => 'Rini Susanti', 'jabatan' => 'Kepala Dapur', 'tipe' => 'tetap', 'nomor_urut' => 2],
            ['nama' => 'Eko Purwanto', 'jabatan' => 'Tenaga Kebersihan', 'tipe' => 'magang', 'nomor_urut' => 3],
            ['nama' => 'Ahmad Faisol', 'jabatan' => 'Asisten Lapangan', 'tipe' => 'tetap', 'nomor_urut' => 4],
        ];

        $relawanModels = [];
        foreach ($relawans as $r) {
            $relawanModels[$r['nama']] = Relawan::create([
                'sppg_id' => $sppg->id,
                'nama' => $r['nama'],
                'jabatan' => $r['jabatan'],
                'tipe' => $r['tipe'],
                'nomor_urut' => $r['nomor_urut'],
                'aktif' => true,
            ]);
        }

        // 3. Setting Upah (Sesuai perhitungan slip)
        $settings = [
            ['jabatan' => 'Asisten Lapangan', 'upah' => 200000], // 6 * 200k = 1.2M (Rizky)
            ['jabatan' => 'Kepala Dapur', 'upah' => 150000],     // 6 * 150k + 50k = 950k (Rini)
            ['jabatan' => 'Tenaga Kebersihan', 'upah' => 75000], // 6 * 75k = 450k (Eko)
        ];

        foreach ($settings as $s) {
            SalarySetting::create([
                'sppg_id' => $sppg->id,
                'jabatan' => $s['jabatan'],
                'upah_per_hari' => $s['upah'],
            ]);
        }

        // 4. Contoh 1 Periode Gaji
        $period = SalaryPeriod::create([
            'sppg_id' => $sppg->id,
            'nama_periode' => 'Minggu KE 2 / Maret 2026',
            'tipe' => 'mingguan',
            'tanggal_mulai' => Carbon::create(2026, 3, 9),
            'tanggal_selesai' => Carbon::create(2026, 3, 14),
            'periode_ke' => 2, // Periode II
            'instansi' => 'SATUAN PELAYANAN PEMENUHAN GIZI KEDOPOK JREBENG KULON 02',
            'penandatangan_1' => 'Mentari Citra Aura J, A.Md. Ak.',
            'penandatangan_2' => 'Ilyas Syams Sentosa, S.P.',
        ]);

        $hariArr = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];

        foreach ($relawanModels as $nama => $relawan) {
            $setting = SalarySetting::where('jabatan', $relawan->jabatan)->first();
            $upah = $setting ? $setting->upah_per_hari : 75000;

            // Hadir 6 hari full
            $hariKerja = array_fill_keys($hariArr, 100);
            $totalHari = 6;
            $totalUpah = $totalHari * $upah;

            $detail = SalaryDetail::create([
                'period_id' => $period->id,
                'relawan_id' => $relawan->id,
                'hari_kerja' => $hariKerja,
                'total_hari' => $totalHari,
                'upah_per_hari' => $upah,
                'total_upah' => $totalUpah,
            ]);

            // Adjust agar hasilnya 950rb untuk Rini
            if ($nama === 'Rini Susanti') {
                SalaryComponent::create([
                    'detail_id' => $detail->id,
                    'nama' => 'Bonus Tambahan',
                    'jumlah' => 50000,
                ]);
            }

            $detail->recalculate();
        }
    }
}
