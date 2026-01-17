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
                'name' => 'CV Sumber Rezeki',
                'address' => 'Jl. Pasar Induk No. 12, Tangerang',
                'phone' => '021-5551234',
                'email' => 'info@sumberrezeki.com',
                'is_active' => true,
            ],
            [
                'name' => 'PT Makmur Jaya',
                'address' => 'Jl. Industri No. 45, Bekasi',
                'phone' => '021-8887654',
                'email' => 'contact@makmurjaya.co.id',
                'is_active' => true,
            ],
            [
                'name' => 'UD Berkah Melimpah',
                'address' => 'Jl. Raya Bogor KM 25, Cibinong',
                'phone' => '021-7778899',
                'email' => 'berkahmelimpah@gmail.com',
                'is_active' => true,
            ],
            [
                'name' => 'Toko Sayur Segar Sentosa',
                'address' => 'Pasar Minggu Blok A No. 8, Jakarta Selatan',
                'phone' => '081234567777',
                'email' => 'sayursegar@yahoo.com',
                'is_active' => true,
            ],
            [
                'name' => 'CV Protein Nusantara',
                'address' => 'Jl. Peternakan No. 99, Depok',
                'phone' => '021-6669988',
                'email' => 'protein.nusantara@gmail.com',
                'is_active' => true,
            ],
            [
                'name' => 'PT Susu Sapi Murni',
                'address' => 'Jl. Peternakan Sapi No. 88, Bogor',
                'phone' => '0251-5554433',
                'email' => 'info@susumurni.co.id',
                'is_active' => true,
            ],
            [
                'name' => 'Toko Beras Harapan',
                'address' => 'Jl. Pasar Baru No. 15, Jakarta Pusat',
                'phone' => '021-3334455',
                'email' => 'berasharapan@gmail.com',
                'is_active' => true,
            ],
            [
                'name' => 'CV Mitra Tani Sejahtera',
                'address' => 'Jl. Pertanian No. 22, Karawang',
                'phone' => '0267-8889900',
                'email' => 'mitratani@outlook.com',
                'is_active' => false, // Inactive supplier for demo
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
