<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RawMaterial;
use App\Models\Category;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;

class BahanBakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure Food category exists
        $category = Category::firstOrCreate(
            ['name' => 'Food'],
            ['description' => 'Food ingredients']
        );

        // Ensure we have a user for creator (fallback to ID 1 or create one)
        $user = User::first() ?? User::factory()->create();

        $filePath = public_path('bahan baku - Sheet1.csv');

        if (!file_exists($filePath)) {
            $this->command->error("CSV file not found at: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        
        // Skip header row
        fgetcsv($file);

        $this->command->info("Importing raw materials from CSV...");

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($file)) !== false) {
                // Handle case where entire line is quoted and read as single column
                if (count($row) === 1 && isset($row[0])) {
                    $parsed = str_getcsv($row[0]);
                    if (count($parsed) > 1) {
                        $row = $parsed;
                    }
                }

                // CSV Schema:
                // 0: Bahan Baku (Name)
                // 1: Satuan (Unit)
                // 2: Harga/Unit (Price)
                // 3: Stok Saat Ini (Initial Stock)
                // 4: Gizi (Nutrition - unused for now)
                // 5: Status (unused)

                $name = trim($row[0]);
                
                // Skip empty rows
                if (empty($name)) {
                    continue;
                }

                $unit = isset($row[1]) ? trim($row[1]) : 'Unspecified';
                if (empty($unit)) {
                    $unit = 'Unspecified';
                }
                
                // Clean price string (remove non-numeric chars if any, though CSV looks clean)
                // but just in case, cast to float
                $price = (isset($row[2]) && is_numeric($row[2])) ? (float)$row[2] : 0;
                
                $initialStock = (isset($row[3]) && is_numeric($row[3])) ? (float)$row[3] : 0;

                // Create or Update Raw Material
                $rawMaterial = RawMaterial::updateOrCreate(
                    [
                        'name' => $name,
                        'unit' => $unit
                    ],
                    [
                        'category_id' => $category->id,
                        'price_per_unit' => $price,
                        'is_active' => true,
                    ]
                );

                // Add Initial Stock if none exists and we have quantity > 0
                if ($initialStock > 0 && $rawMaterial->stocks()->count() === 0) {
                    Stock::create([
                        'raw_material_id' => $rawMaterial->id,
                        'type' => 'in',
                        'quantity' => $initialStock,
                        'notes' => 'Old System Import / Initial Stock',
                        'transaction_date' => Carbon::now(),
                        'created_by' => $user->id,
                    ]);
                }
            }

            DB::commit();
            $this->command->info("Import completed successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Error importing data: " . $e->getMessage());
        } finally {
            fclose($file);
        }
    }
}
