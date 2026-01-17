<?php

namespace Database\Seeders;

use App\Models\Stock;
use App\Models\RawMaterial;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@mbg.id')->first();
        
        // Get some raw materials and suppliers
        $ayam = RawMaterial::where('name', 'Ayam Goreng')->first();
        $susu = RawMaterial::where('name', 'Susu Sapi')->first();
        $sayurKol = RawMaterial::where('name', 'Sayur Kol')->first();
        $nasi = RawMaterial::where('name', 'Nasi Putih')->first();
        $telur = RawMaterial::where('name', 'Telur Ayam')->first();
        $wortel = RawMaterial::where('name', 'Wortel')->first();
        $tempe = RawMaterial::where('name', 'Tempe')->first();
        $pisang = RawMaterial::where('name', 'Pisang')->first();

        $supplier1 = Supplier::where('name', 'CV Sumber Rezeki')->first();
        $supplier2 = Supplier::where('name', 'PT Makmur Jaya')->first();
        $supplier3 = Supplier::where('name', 'PT Susu Sapi Murni')->first();
        $supplier4 = Supplier::where('name', 'CV Protein Nusantara')->first();

        // Stock IN transactions (from suppliers)
        
        // Ayam - Stock IN
        Stock::create([
            'raw_material_id' => $ayam->id,
            'supplier_id' => $supplier4->id,
            'type' => 'in',
            'quantity' => 50000, // 50 kg
            'notes' => 'Pembelian awal bulan Januari',
            'transaction_date' => Carbon::now()->subDays(10),
            'created_by' => $adminUser->id,
        ]);

        Stock::create([
            'raw_material_id' => $ayam->id,
            'supplier_id' => $supplier4->id,
            'type' => 'in',
            'quantity' => 30000, // 30 kg
            'notes' => 'Restok minggu ke-2',
            'transaction_date' => Carbon::now()->subDays(3),
            'created_by' => $adminUser->id,
        ]);

        // Stock OUT (production)
        Stock::create([
            'raw_material_id' => $ayam->id,
            'supplier_id' => null,
            'type' => 'out',
            'quantity' => 15000, // 15 kg used
            'notes' => 'Produksi Menu Ayam Riza - Minggu ke-1',
            'transaction_date' => Carbon::now()->subDays(5),
            'created_by' => $adminUser->id,
        ]);

        // Susu - Stock IN
        Stock::create([
            'raw_material_id' => $susu->id,
            'supplier_id' => $supplier3->id,
            'type' => 'in',
            'quantity' => 100000, // 100 liter
            'notes' => 'Pembelian susu segar',
            'transaction_date' => Carbon::now()->subDays(7),
            'created_by' => $adminUser->id,
        ]);

        Stock::create([
            'raw_material_id' => $susu->id,
            'supplier_id' => null,
            'type' => 'out',
            'quantity' => 25000, // 25 liter used
            'notes' => 'Produksi minggu ke-1',
            'transaction_date' => Carbon::now()->subDays(4),
            'created_by' => $adminUser->id,
        ]);

        // Sayur Kol - Stock IN
        Stock::create([
            'raw_material_id' => $sayurKol->id,
            'supplier_id' => $supplier1->id,
            'type' => 'in',
            'quantity' => 30000, // 30 kg
            'notes' => 'Sayur segar dari pasar',
            'transaction_date' => Carbon::now()->subDays(2),
            'created_by' => $adminUser->id,
        ]);

        Stock::create([
            'raw_material_id' => $sayurKol->id,
            'supplier_id' => null,
            'type' => 'out',
            'quantity' => 8000, // 8 kg used
            'notes' => 'Produksi Menu Ayam Riza',
            'transaction_date' => Carbon::now()->subDays(1),
            'created_by' => $adminUser->id,
        ]);

        // Nasi - Stock IN
        Stock::create([
            'raw_material_id' => $nasi->id,
            'supplier_id' => $supplier2->id,
            'type' => 'in',
            'quantity' => 100000, // 100 kg beras (jadi nasi)
            'notes' => 'Beras untuk nasi minggu ini',
            'transaction_date' => Carbon::now()->subDays(8),
            'created_by' => $adminUser->id,
        ]);

        Stock::create([
            'raw_material_id' => $nasi->id,
            'supplier_id' => null,
            'type' => 'out',
            'quantity' => 35000, // 35 kg used
            'notes' => 'Produksi nasi untuk semua menu',
            'transaction_date' => Carbon::now()->subDays(2),
            'created_by' => $adminUser->id,
        ]);

        // Telur - Stock IN
        Stock::create([
            'raw_material_id' => $telur->id,
            'supplier_id' => $supplier4->id,
            'type' => 'in',
            'quantity' => 5000, // 100 butir (50g each = 5000g)
            'notes' => '100 butir telur segar',
            'transaction_date' => Carbon::now()->subDays(6),
            'created_by' => $adminUser->id,
        ]);

        Stock::create([
            'raw_material_id' => $telur->id,
            'supplier_id' => null,
            'type' => 'out',
            'quantity' => 2000, // 40 butir used
            'notes' => 'Produksi Menu Telur Sehat',
            'transaction_date' => Carbon::now()->subDays(3),
            'created_by' => $adminUser->id,
        ]);

        // Wortel - Stock IN
        Stock::create([
            'raw_material_id' => $wortel->id,
            'supplier_id' => $supplier1->id,
            'type' => 'in',
            'quantity' => 20000, // 20 kg
            'notes' => 'Wortel segar',
            'transaction_date' => Carbon::now()->subDays(5),
            'created_by' => $adminUser->id,
        ]);

        // Tempe - Stock IN
        Stock::create([
            'raw_material_id' => $tempe->id,
            'supplier_id' => $supplier2->id,
            'type' => 'in',
            'quantity' => 15000, // 15 kg
            'notes' => 'Tempe segar lokal',
            'transaction_date' => Carbon::now()->subDays(4),
            'created_by' => $adminUser->id,
        ]);

        Stock::create([
            'raw_material_id' => $tempe->id,
            'supplier_id' => null,
            'type' => 'out',
            'quantity' => 5000, // 5 kg used
            'notes' => 'Produksi Menu Tempe Goreng',
            'transaction_date' => Carbon::now()->subDays(2),
            'created_by' => $adminUser->id,
        ]);

        // Pisang - Stock IN
        Stock::create([
            'raw_material_id' => $pisang->id,
            'supplier_id' => $supplier1->id,
            'type' => 'in',
            'quantity' => 10000, // 100 buah (100g each)
            'notes' => '100 buah pisang ambon',
            'transaction_date' => Carbon::now()->subDays(3),
            'created_by' => $adminUser->id,
        ]);
    }
}
