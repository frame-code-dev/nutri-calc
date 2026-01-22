<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\RawMaterial;

class MasterMenuSeeder extends Seeder
{
    public function run()
    {
        $csvFile = public_path('Menu Halal.csv');
        if (!file_exists($csvFile)) {
            $this->command->error("File public/Menu Halal.csv not found.");
            return;
        }

        $file = fopen($csvFile, 'r');
        
        $currentMenu1 = null; 
        $currentMenu2 = null; 

        while (($row = fgetcsv($file, 1000, ';')) !== false) {
            // Trim all values empty
            $row = array_map(function($value) {
                return trim($value) === '' ? null : trim($value);
            }, $row);

            // Left Side: Name(0), Ingredient(1), ID(2)
            $this->processColumn($row, 0, 1, 2, $currentMenu1);

            // Right Side: Name(5), Ingredient(6), ID(7)
            if (count($row) > 5) {
                $this->processColumn($row, 5, 6, 7, $currentMenu2);
            }
        }

        fclose($file);
    }

    private function processColumn($row, $nameIndex, $ingredientIndex, $idIndex, &$currentMenu)
    {
        $menuName = $row[$nameIndex] ?? null;
        $ingredientName = $row[$ingredientIndex] ?? null;
        $code = $row[$idIndex] ?? null;

        // Start New Menu
        if ($menuName) {
            $currentMenu = Menu::firstOrCreate(
                ['name' => $menuName],
                ['type' => 'wet', 'is_active' => true, 'description' => 'Imported from Master Menu']
            );
            $this->command->info("Processing Menu: $menuName");
        }

        if ($currentMenu && $ingredientName) {
            $ingredients = explode(',', $ingredientName);
            
            foreach ($ingredients as $index => $ingName) {
                $ingName = trim($ingName);
                if (empty($ingName)) continue;

                // Code usually applies to the main/first ingredient if comma separated
                $currentCode = ($index === 0) ? $code : null;

                // Find Material
                $material = null;
                if ($currentCode) {
                    $material = RawMaterial::where('code', $currentCode)->first();
                }
                if (!$material) {
                    $material = RawMaterial::where('name', 'LIKE', $ingName)->first();
                }

                // Create if missing
                if (!$material) {
                    $material = RawMaterial::create([
                        'name' => $ingName,
                        'code' => $currentCode, // Can be null
                        'unit' => 'unit',
                        'price_per_unit' => 0,
                        'is_active' => true,
                        'category_id' => 1 // Default category if needed
                    ]);
                    $this->command->info("  + Created Material: $ingName (Code: " . ($currentCode ?? 'None') . ")");
                } else {
                    // Update code if missing
                    if ($currentCode && !$material->code) {
                        $material->update(['code' => $currentCode]);
                    }
                }

                // Attach to Menu
                MenuItem::firstOrCreate([
                    'menu_id' => $currentMenu->id,
                    'raw_material_id' => $material->id,
                ], [
                    'quantity_per_portion' => 1,
                    'group_name' => 'Komposisi Utama'
                ]);
            }
        }
    }
}
