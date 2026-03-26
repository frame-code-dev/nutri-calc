<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Koperasi Peternakan & Pertanian Sejahtera',
                'address' => 'Kedopok Jrebeng Kulon',
                'phone' => '021-5551234',
                'email' => 'koperasi@sumberrezeki.com',
                'is_active' => true,
            ],
           
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
