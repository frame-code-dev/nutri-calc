<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menu 1: Menu Ayam Riza (Wet Menu)
        $menuAyamRiza = Menu::create([
            'name' => 'Menu Ayam Riza',
            'type' => 'wet',
            'description' => 'Menu bergizi tinggi protein dengan ayam goreng, sayur, susu, dan nasi',
            'is_active' => true,
        ]);

        // Add ingredients for Menu Ayam Riza
        // Based on example: Ayam goreng, Susu, Sayur kol
        MenuItem::create([
            'menu_id' => $menuAyamRiza->id,
            'raw_material_id' => RawMaterial::where('name', 'Ayam Goreng')->first()->id,
            'quantity_per_portion' => 150, // 150 grams
        ]);

        MenuItem::create([
            'menu_id' => $menuAyamRiza->id,
            'raw_material_id' => RawMaterial::where('name', 'Susu Sapi')->first()->id,
            'quantity_per_portion' => 200, // 200 ml
        ]);

        MenuItem::create([
            'menu_id' => $menuAyamRiza->id,
            'raw_material_id' => RawMaterial::where('name', 'Sayur Kol')->first()->id,
            'quantity_per_portion' => 100, // 100 grams
        ]);

        MenuItem::create([
            'menu_id' => $menuAyamRiza->id,
            'raw_material_id' => RawMaterial::where('name', 'Nasi Putih')->first()->id,
            'quantity_per_portion' => 200, // 200 grams
        ]);

        // Menu 2: Menu Telur Sehat (Wet Menu)
        $menuTelur = Menu::create([
            'name' => 'Menu Telur Sehat',
            'type' => 'wet',
            'description' => 'Menu dengan telur, sayur wortel, dan nasi',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $menuTelur->id,
            'raw_material_id' => RawMaterial::where('name', 'Telur Ayam')->first()->id,
            'quantity_per_portion' => 100, // 2 telur (50g each)
        ]);

        MenuItem::create([
            'menu_id' => $menuTelur->id,
            'raw_material_id' => RawMaterial::where('name', 'Wortel')->first()->id,
            'quantity_per_portion' => 80,
        ]);

        MenuItem::create([
            'menu_id' => $menuTelur->id,
            'raw_material_id' => RawMaterial::where('name', 'Nasi Putih')->first()->id,
            'quantity_per_portion' => 200,
        ]);

        MenuItem::create([
            'menu_id' => $menuTelur->id,
            'raw_material_id' => RawMaterial::where('name', 'Susu Sapi')->first()->id,
            'quantity_per_portion' => 150,
        ]);

        // Menu 3: Menu Tempe Goreng (Wet Menu)
        $menuTempe = Menu::create([
            'name' => 'Menu Tempe Goreng',
            'type' => 'wet',
            'description' => 'Menu protein nabati dengan tempe goreng dan sayur',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $menuTempe->id,
            'raw_material_id' => RawMaterial::where('name', 'Tempe')->first()->id,
            'quantity_per_portion' => 120,
        ]);

        MenuItem::create([
            'menu_id' => $menuTempe->id,
            'raw_material_id' => RawMaterial::where('name', 'Sayur Kol')->first()->id,
            'quantity_per_portion' => 100,
        ]);

        MenuItem::create([
            'menu_id' => $menuTempe->id,
            'raw_material_id' => RawMaterial::where('name', 'Wortel')->first()->id,
            'quantity_per_portion' => 50,
        ]);

        MenuItem::create([
            'menu_id' => $menuTempe->id,
            'raw_material_id' => RawMaterial::where('name', 'Nasi Putih')->first()->id,
            'quantity_per_portion' => 200,
        ]);

        // Menu 4: Snack Pisang Susu (Dry Menu - for holidays)
        $menuSnack = Menu::create([
            'name' => 'Snack Pisang Susu',
            'type' => 'dry',
            'description' => 'Menu kering untuk hari libur - pisang dan susu kotak',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $menuSnack->id,
            'raw_material_id' => RawMaterial::where('name', 'Pisang')->first()->id,
            'quantity_per_portion' => 100, // 1 buah
        ]);

        MenuItem::create([
            'menu_id' => $menuSnack->id,
            'raw_material_id' => RawMaterial::where('name', 'Susu Sapi')->first()->id,
            'quantity_per_portion' => 200,
        ]);
    }
}
