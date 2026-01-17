<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use Illuminate\Database\Seeder;

class OfficeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $officeCategory = \App\Models\Category::where('name', 'Office')->first();
        $officeCategoryId = $officeCategory ? $officeCategory->id : null;

        $officeItems = [
            [
                'name' => 'Kertas A4 80gr',
                'category_id' => $officeCategoryId,
                'unit' => 'rim',
                'price_per_unit' => 55000,
                'description' => 'Kertas HVS A4 80 gram (1 rim = 500 lembar)',
            ],
            [
                'name' => 'Tinta Epson Black 664',
                'category_id' => $officeCategoryId,
                'unit' => 'botol',
                'price_per_unit' => 95000,
                'description' => 'Tinta original Epson 664 Hitam',
            ],
            [
                'name' => 'Tinta Epson Cyan 664',
                'category_id' => $officeCategoryId,
                'unit' => 'botol',
                'price_per_unit' => 95000,
                'description' => 'Tinta original Epson 664 Biru',
            ],
            [
                'name' => 'Tinta Epson Magenta 664',
                'category_id' => $officeCategoryId,
                'unit' => 'botol',
                'price_per_unit' => 95000,
                'description' => 'Tinta original Epson 664 Merah',
            ],
            [
                'name' => 'Tinta Epson Yellow 664',
                'category_id' => $officeCategoryId,
                'unit' => 'botol',
                'price_per_unit' => 95000,
                'description' => 'Tinta original Epson 664 Kuning',
            ],
            [
                'name' => 'Pulpen Standard AE7',
                'category_id' => $officeCategoryId,
                'unit' => 'box',
                'price_per_unit' => 24000,
                'description' => 'Pulpen hitam (1 box = 12 pcs)',
            ],
            [
                'name' => 'Buku Kas Besar',
                'category_id' => $officeCategoryId,
                'unit' => 'buah',
                'price_per_unit' => 15000,
                'description' => 'Buku Hardcover Folio 100 lembar',
            ],
            [
                'name' => 'Staples Max No.10',
                'category_id' => $officeCategoryId,
                'unit' => 'kotak',
                'price_per_unit' => 2500,
                'description' => 'Isi staples kecil no 10',
            ],
            [
                'name' => 'Map Folder Plastik',
                'category_id' => $officeCategoryId,
                'unit' => 'lusin',
                'price_per_unit' => 36000,
                'description' => 'Map plastik bening L-Folder (1 lusin = 12 pcs)',
            ],
            [
                'name' => 'Lakban Bening 2 Inch',
                'category_id' => $officeCategoryId,
                'unit' => 'roll',
                'price_per_unit' => 12000,
                'description' => 'Opp Tape Bening lebar 48mm',
            ],
        ];

        foreach ($officeItems as $item) {
            RawMaterial::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
