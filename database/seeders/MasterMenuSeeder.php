<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MasterMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // Carbs / Nasi (Dry)
            ['name' => 'Nasi Hainan', 'type' => 'dry'],
            ['name' => 'Nasi kebuli', 'type' => 'dry'],
            ['name' => 'Nasi Daun Jeruk', 'type' => 'dry'],
            ['name' => 'Nasi Kuning', 'type' => 'dry'],
            ['name' => 'Nasi Pandan', 'type' => 'dry'],
            ['name' => 'Nasi Goreng', 'type' => 'dry'],
            
            // Mie / Pasta (Dry)
            ['name' => 'Mie Ayam', 'type' => 'dry'],
            ['name' => 'Mie Sweet', 'type' => 'dry'],
            ['name' => 'Macaroni Pasta', 'type' => 'dry'],
            ['name' => 'Bakmie Jawa', 'type' => 'dry'],
            
            // Others (Dry)
            ['name' => 'Burger', 'type' => 'dry'],
            ['name' => 'Kentang Goreng', 'type' => 'dry'],
            ['name' => 'Parsley Potatoes', 'type' => 'dry'],
            ['name' => 'Jasuke', 'type' => 'dry'],
            
            // Proteins - Meats (Dry)
            ['name' => 'Beef Teriyaki', 'type' => 'dry'],
            ['name' => 'Ayam Teriyaki', 'type' => 'dry'],
            ['name' => 'Ayam Koloke', 'type' => 'dry'],
            ['name' => 'Ayam Kecap', 'type' => 'dry'],
            ['name' => 'Ayam Goreng Mentega', 'type' => 'dry'],
            ['name' => 'Ayam Suwir', 'type' => 'dry'],
            ['name' => 'Oseng Bakso', 'type' => 'dry'],
            ['name' => 'Chicken Katsu', 'type' => 'dry'],
            ['name' => 'Ayam Kremes', 'type' => 'dry'],
            ['name' => 'Ayam pop', 'type' => 'dry'],
            ['name' => 'Ayam Crispy', 'type' => 'dry'],
            ['name' => 'Ayam Patty', 'type' => 'dry'],
            ['name' => 'Fire Chicken', 'type' => 'dry'],
            ['name' => 'Sate Ayam', 'type' => 'dry'],
            ['name' => 'Kaki Naga', 'type' => 'dry'],
            ['name' => 'Ayam Rendang', 'type' => 'dry'],
            ['name' => 'Ayam Bolognese', 'type' => 'dry'],
            ['name' => 'Bakso Bolognese', 'type' => 'dry'],
            ['name' => 'Chicken Steak', 'type' => 'dry'],
            ['name' => 'Ayam Geprek', 'type' => 'dry'],
            ['name' => 'Ayam Goreng', 'type' => 'dry'],
            ['name' => 'Dimsum ayam', 'type' => 'dry'],
            ['name' => 'Ayam Bakar', 'type' => 'dry'],
            ['name' => 'Pangsit Ayam', 'type' => 'dry'],
            ['name' => 'Abon Ayam', 'type' => 'dry'],
            
            // Proteins - Eggs (Dry)
            ['name' => 'Telur Balado', 'type' => 'dry'],
            ['name' => 'Telur Ceplok', 'type' => 'dry'],
            ['name' => 'Nugget telur', 'type' => 'dry'],
            ['name' => 'Fuyunghai', 'type' => 'dry'],
            ['name' => 'Telur Dabu-dabu', 'type' => 'dry'],
            ['name' => 'Telur Bacem', 'type' => 'dry'],
            ['name' => 'Telur kecap', 'type' => 'dry'],
            
            // Proteins - Fish (Dry)
            ['name' => 'Lele Krispy', 'type' => 'dry'],
            
            // Proteins - Vegan/Tofu/Tempe (Dry)
            ['name' => 'Tahu Bacem', 'type' => 'dry'],
            ['name' => 'Kubis Tahu', 'type' => 'dry'],
            ['name' => 'Tahu Crispy', 'type' => 'dry'],
            ['name' => 'Tempe Krispy', 'type' => 'dry'],
            ['name' => 'Tahu Goreng', 'type' => 'dry'],
            ['name' => 'Tempe Goreng', 'type' => 'dry'],
            ['name' => 'Kering Tempe', 'type' => 'dry'],
            ['name' => 'Tahu Orek', 'type' => 'dry'],
            ['name' => 'Tempe Orek', 'type' => 'dry'],
            ['name' => 'Stik Tempe', 'type' => 'dry'],
            ['name' => 'Nugget Tahu', 'type' => 'dry'],
            ['name' => 'Kripik Tempe', 'type' => 'dry'],
            ['name' => 'Tahu Bulat', 'type' => 'dry'],
            
            // Soups / Wet Items
            ['name' => 'Ayam Curry', 'type' => 'wet'],
            ['name' => 'Soto Ayam', 'type' => 'wet'],
            ['name' => 'Saus BBQ', 'type' => 'wet'],
            ['name' => 'Sapo tahu', 'type' => 'wet'],
            ['name' => 'Capjay', 'type' => 'wet'],
            
            // Vegetables (Wet)
            ['name' => 'Mix vegetable', 'type' => 'wet'],
            ['name' => 'Tumis Labu Siam', 'type' => 'wet'],
            ['name' => 'Setup Sayur', 'type' => 'wet'],
            ['name' => 'Tempe Kriwil', 'type' => 'wet'],
            ['name' => 'Pakcoy Saus Tiram', 'type' => 'wet'],
            ['name' => 'Tumis Buncis Broccoli', 'type' => 'wet'],
            ['name' => 'Acar Wortel Timun', 'type' => 'wet'],
            ['name' => 'Sambal Bawang', 'type' => 'wet'],
            ['name' => 'Buncis bb Bawang putih', 'type' => 'wet'],
            ['name' => 'Tumis Jamur Tiram Pakcoy', 'type' => 'wet'],
            ['name' => 'Cah buncis Baby corn', 'type' => 'wet'],
            ['name' => 'Bihun Goreng', 'type' => 'dry'], // Bihun usually dry
            ['name' => 'Tumis Jamur Kuping Pakcoy', 'type' => 'wet'],
            ['name' => 'Mix Vegetable', 'type' => 'wet'],
            ['name' => 'Tumis Pakcoy', 'type' => 'wet'],
            ['name' => 'Sayur Pecel', 'type' => 'wet'],
            ['name' => 'Tumis Toge Wortel', 'type' => 'wet'],
            ['name' => 'Tumis Besai', 'type' => 'wet'],
            ['name' => 'Cah Kangkung Toge', 'type' => 'wet'],
            ['name' => 'Setup Sayuran', 'type' => 'wet'],
            ['name' => 'Tumis Buncis Brokoli', 'type' => 'wet'],
        ];

        foreach ($menus as $menuData) {
            Menu::firstOrCreate(
                ['name' => $menuData['name']],
                [
                    'type' => $menuData['type'],
                    'category' => 'master',
                    'is_active' => true,
                    'description' => 'Master menu component.',
                ]
            );
        }
    }
}
