<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\RawMaterial;
use App\Models\RawMaterialNutrition;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Membaca data dari public/tkpi.xlsx (Tabel Komposisi Pangan Indonesia).
     *
     * Kolom TKPI (0-indexed setelah header terdeteksi):
     *   NO | KODE | NAMA BAHAN | SUMBER
     *   AIR(g) | ENERGI(Kal) | PROTEIN(g) | LEMAK(g) | KH(g) | SERAT(g) | ABU(g)
     *   KALSI(mg) | FOSFO(mg) | BESI(mg) | NATRIU(mg) | KALIU(mg) | TEMBA(mg) | SENG(mg)
     *   RETINO(mcg) | B-KAR(mcg) | KAR(mcg) | THIAMI(mg) | RIBOFL(mg) | NIASIN(mg) | VIT_C(mg)
     *   BDD(%)
     *
     * Nama dengan koma dipecah jadi entri terpisah:
     *   "Babi, daging, gemuk, segar" → "Babi" | "Daging" | "Gemuk" | "Segar"
     * Stok awal = 100 untuk setiap entri baru.
     */
    public function run(): void
    {
        // ── 1. Pastikan kategori Food ada ──────────────────────────────────────
        $category = Category::firstOrCreate(
            ['name' => 'Food'],
            ['description' => 'Bahan pangan / makanan']
        );

        // ── 2. Ambil user pertama sebagai creator stok ─────────────────────────
        $user = User::first() ?? User::factory()->create();

        // ── 3. Buka file TKPI ──────────────────────────────────────────────────
        $filePath = public_path('tkpi.xlsx');

        if (! file_exists($filePath)) {
            $this->command->error("File tidak ditemukan: {$filePath}");

            return;
        }

        $this->command->info('Membaca file tkpi.xlsx ...');

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, false); // 0-indexed

        // ── 4. Temukan baris header ────────────────────────────────────────────
        $headerRowIndex = null;
        foreach ($rows as $i => $row) {
            foreach ($row as $cell) {
                if (is_string($cell) && stripos(trim($cell), 'NAMA BAHAN') !== false) {
                    $headerRowIndex = $i;
                    break 2;
                }
            }
        }

        if ($headerRowIndex === null) {
            $this->command->error('Tidak dapat menemukan baris header (NAMA BAHAN) di TKPI.');

            return;
        }

        $this->command->info("Header ditemukan di baris index: {$headerRowIndex}");

        // ── 5. Petakan indeks kolom dari header ────────────────────────────────
        $header = $rows[$headerRowIndex];
        $colMap = [];
        foreach ($header as $colIdx => $colName) {
            if ($colName === null) {
                continue;
            }
            $normalized = strtoupper(trim((string) $colName));
            $colMap[$normalized] = $colIdx;
        }

        // Helper: cari indeks kolom berdasarkan kandidat nama
        $findCol = function (array $candidates) use ($colMap): ?int {
            foreach ($candidates as $name) {
                $key = strtoupper(trim($name));
                if (isset($colMap[$key])) {
                    return $colMap[$key];
                }
            }

            return null;
        };

        // Indeks kolom (fallback ke posisi standar TKPI jika nama tidak cocok)
        $cols = [
            'nama' => $findCol(['NAMA BAHAN', 'NAMA']) ?? 2,
            'kode' => $findCol(['KODE']) ?? 1,
            'air' => $findCol(['AIR']) ?? 4,
            'energi' => $findCol(['ENERGI', 'ENERGY']) ?? 5,
            'protein' => $findCol(['PROTEIN', 'PROTEI']) ?? 6,
            'lemak' => $findCol(['LEMAK']) ?? 7,
            'kh' => $findCol(['KH', 'KARBOHIDRAT']) ?? 8,
            'serat' => $findCol(['SERAT']) ?? 9,
            'abu' => $findCol(['ABU']) ?? 10,
            'kalsi' => $findCol(['KALSI', 'KALSIUM']) ?? 11,
            'fosfo' => $findCol(['FOSFO', 'FOSFOR']) ?? 12,
            'besi' => $findCol(['BESI']) ?? 13,
            'natriu' => $findCol(['NATRIU', 'NATRIUM']) ?? 14,
            'kaliu' => $findCol(['KALIU', 'KALIUM']) ?? 15,
            'temba' => $findCol(['TEMBA', 'TEMBAGA']) ?? 16,
            'seng' => $findCol(['SENG']) ?? 17,
            'retino' => $findCol(['RETINO', 'RETINOL']) ?? 18,
            'bkar' => $findCol(['B-KAR', 'BKAR']) ?? 19,
            'kar' => $findCol(['KAR']) ?? 20,
            'thiami' => $findCol(['THIAMI', 'TIAMIN']) ?? 21,
            'ribofl' => $findCol(['RIBOFL', 'RIBOFLAVIN']) ?? 22,
            'niasin' => $findCol(['NIASIN']) ?? 23,
            'vitc' => $findCol(['VIT_C', 'VIT C', 'VITAMIN C']) ?? 24,
            'bdd' => $findCol(['BDD']) ?? 25,
        ];

        $this->command->info('Mapping kolom: '.json_encode($cols));

        // ── 6. Proses baris data ───────────────────────────────────────────────
        $imported = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {
            foreach ($rows as $i => $row) {
                if ($i <= $headerRowIndex) {
                    continue;
                }

                $rawNama = isset($row[$cols['nama']]) ? trim((string) $row[$cols['nama']]) : '';
                if (empty($rawNama)) {
                    $skipped++;

                    continue;
                }

                // Ambil semua nilai gizi
                $kode = isset($row[$cols['kode']]) ? trim((string) $row[$cols['kode']]) : null;
                $n = fn ($k) => $this->numVal($row[$cols[$k]] ?? null);

                $nutrisiData = [
                    'water_per_100g' => $n('air'),
                    'energy_per_100g' => $n('energi'),
                    'protein_per_100g' => $n('protein'),
                    'fat_per_100g' => $n('lemak'),
                    'carbohydrate_per_100g' => $n('kh'),
                    'fiber_per_100g' => $n('serat'),
                    'ash_per_100g' => $n('abu'),
                    'calcium_per_100g' => $n('kalsi'),
                    'phosphorus_per_100g' => $n('fosfo'),
                    'iron_per_100g' => $n('besi'),
                    'sodium_per_100g' => $n('natriu'),
                    'potassium_per_100g' => $n('kaliu'),
                    'copper_per_100g' => $n('temba'),
                    'zinc_per_100g' => $n('seng'),
                    'retinol_per_100g' => $n('retino'),
                    'beta_carotene_per_100g' => $n('bkar'),
                    'carotene_per_100g' => $n('kar'),
                    'thiamine_per_100g' => $n('thiami'),
                    'riboflavin_per_100g' => $n('ribofl'),
                    'niacin_per_100g' => $n('niasin'),
                    'vitamin_c_per_100g' => $n('vitc'),
                    'bdd' => $n('bdd') ?: 100.0,
                ];

                // Pecah nama berdasarkan koma
                $namaSegments = $this->splitNama($rawNama);
                $isFirst = true;

                foreach ($namaSegments as $namaFinal) {
                    $rawMaterial = RawMaterial::firstOrCreate(
                        ['name' => $namaFinal, 'unit' => 'gram'],
                        [
                            'category_id' => $category->id,
                            'code' => $isFirst ? $kode : null,
                            'price_per_unit' => 0,
                            'is_active' => true,
                        ]
                    );

                    // Upsert data gizi
                    RawMaterialNutrition::updateOrCreate(
                        ['raw_material_id' => $rawMaterial->id],
                        $nutrisiData
                    );

                    // Stok awal 100 jika belum ada
                    if ($rawMaterial->stocks()->count() === 0) {
                        Stock::create([
                            'raw_material_id' => $rawMaterial->id,
                            'type' => 'in',
                            'quantity' => 100,
                            'notes' => 'Stok Awal – Import TKPI',
                            'transaction_date' => Carbon::now('Asia/Jakarta'),
                            'created_by' => $user->id,
                        ]);
                    }

                    $isFirst = false;
                    $imported++;
                }
            }

            DB::commit();
            $this->command->info("✅ Import selesai! {$imported} bahan baku diimport, {$skipped} baris dilewati.");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Error: '.$e->getMessage());
            $this->command->error($e->getTraceAsString());
        }
    }

    /**
     * Pecah nama bahan yang mengandung koma menjadi entri-entri terpisah.
     * "Babi, daging, gemuk, segar" → ["Babi", "Daging", "Gemuk", "Segar"]
     *
     * @return string[]
     */
    private function splitNama(string $rawNama): array
    {
        if (strpos($rawNama, ',') === false) {
            return [ucwords(strtolower(trim($rawNama)))];
        }

        $result = [];
        foreach (explode(',', $rawNama) as $part) {
            $clean = trim($part);
            if ($clean !== '') {
                $result[] = ucwords(strtolower($clean));
            }
        }

        return array_unique($result);
    }

    /**
     * Konversi nilai sel ke float, kembalikan 0 jika tidak numerik.
     */
    private function numVal(mixed $value): float
    {
        if ($value === null || $value === '' || $value === '-' || $value === 0) {
            return 0.0;
        }
        $cleaned = str_replace([',', ' '], ['.', ''], (string) $value);

        return is_numeric($cleaned) ? (float) $cleaned : 0.0;
    }
}
