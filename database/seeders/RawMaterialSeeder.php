<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use App\Models\RawMaterialNutrition;
use Illuminate\Database\Seeder;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'raw_material' => [
                    'name' => 'Ayam Goreng',
                    'unit' => 'gram',
                    'price_per_unit' => 45,
                    'description' => 'Daging ayam goreng tanpa tulang',
                ],
                'nutrition' => [
                    'energy_per_100g' => 239,
                    'protein_per_100g' => 27.3,
                    'fat_per_100g' => 13.6,
                    'carbohydrate_per_100g' => 0,
                    'fiber_per_100g' => 0,
                ],
            ],
            [
                'raw_material' => [
                    'name' => 'Susu Sapi',
                    'unit' => 'ml',
                    'price_per_unit' => 15,
                    'description' => 'Susu sapi segar full cream',
                ],
                'nutrition' => [
                    'energy_per_100g' => 61,
                    'protein_per_100g' => 3.2,
                    'fat_per_100g' => 3.3,
                    'carbohydrate_per_100g' => 4.8,
                    'fiber_per_100g' => 0,
                ],
            ],
            [
                'raw_material' => [
                    'name' => 'Sayur Kol',
                    'unit' => 'gram',
                    'price_per_unit' => 8,
                    'description' => 'Kol segar untuk sayur tumis',
                ],
                'nutrition' => [
                    'energy_per_100g' => 25,
                    'protein_per_100g' => 1.3,
                    'fat_per_100g' => 0.1,
                    'carbohydrate_per_100g' => 5.8,
                    'fiber_per_100g' => 2.5,
                ],
            ],
            [
                'raw_material' => [
                    'name' => 'Nasi Putih',
                    'unit' => 'gram',
                    'price_per_unit' => 5,
                    'description' => 'Nasi putih matang',
                ],
                'nutrition' => [
                    'energy_per_100g' => 130,
                    'protein_per_100g' => 2.7,
                    'fat_per_100g' => 0.3,
                    'carbohydrate_per_100g' => 28.2,
                    'fiber_per_100g' => 0.4,
                ],
            ],
            [
                'raw_material' => [
                    'name' => 'Telur Ayam',
                    'unit' => 'butir',
                    'price_per_unit' => 2500,
                    'description' => 'Telur ayam segar (1 butir = 50g)',
                ],
                'nutrition' => [
                    'energy_per_100g' => 155,
                    'protein_per_100g' => 12.6,
                    'fat_per_100g' => 11.5,
                    'carbohydrate_per_100g' => 1.1,
                    'fiber_per_100g' => 0,
                ],
            ],
            [
                'raw_material' => [
                    'name' => 'Wortel',
                    'unit' => 'gram',
                    'price_per_unit' => 10,
                    'description' => 'Wortel segar',
                ],
                'nutrition' => [
                    'energy_per_100g' => 41,
                    'protein_per_100g' => 0.9,
                    'fat_per_100g' => 0.2,
                    'carbohydrate_per_100g' => 9.6,
                    'fiber_per_100g' => 2.8,
                ],
            ],
            [
                'raw_material' => [
                    'name' => 'Tempe',
                    'unit' => 'gram',
                    'price_per_unit' => 18,
                    'description' => 'Tempe kedelai',
                ],
                'nutrition' => [
                    'energy_per_100g' => 201,
                    'protein_per_100g' => 20.8,
                    'fat_per_100g' => 8.8,
                    'carbohydrate_per_100g' => 13.5,
                    'fiber_per_100g' => 1.4,
                ],
            ],
            [
                'raw_material' => [
                    'name' => 'Pisang',
                    'unit' => 'buah',
                    'price_per_unit' => 3000,
                    'description' => 'Pisang ambon (1 buah = 100g)',
                ],
                'nutrition' => [
                    'energy_per_100g' => 99,
                    'protein_per_100g' => 1.2,
                    'fat_per_100g' => 0.2,
                    'carbohydrate_per_100g' => 25.8,
                    'fiber_per_100g' => 2.6,
                ],
            ],
        ];

        $foodCategory = \App\Models\Category::where('name', 'Food')->first();
        $foodCategoryId = $foodCategory ? $foodCategory->id : null;

        foreach ($materials as $data) {
            $materialData = array_merge($data['raw_material'], ['category_id' => $foodCategoryId]);
            $material = RawMaterial::create($materialData);
            
            RawMaterialNutrition::create(array_merge(
                ['raw_material_id' => $material->id],
                $data['nutrition']
            ));
        }
    }
}
