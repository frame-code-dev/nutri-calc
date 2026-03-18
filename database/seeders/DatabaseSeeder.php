<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Order matters! Follow dependencies
        
        $this->call([
            // 1. Roles & Permissions (Spatie) - Must be first
            RolePermissionSeeder::class,
            
            // 2. Users with Roles
            UserSeeder::class,
            
            // 3. Schools & Coordinators
            // SchoolSeeder::class,
            KloterSeeder::class,
            SchoolDataSeeder::class,
            
            // 4. Suppliers
            SupplierSeeder::class,
            
            // 5. Raw Materials & Nutrition Data
            // RawMaterialSeeder::class,
            BahanBakuSeeder::class,
            MasterMenuSeeder::class,

            // 6. Office Items
            // OfficeItemSeeder::class,
            
            // // 7. Menus & Menu Items
            // MenuSeeder::class,
            
            // 7. Stock Transactions
            // StockSeeder::class,
            AssignWeeklyMenuSeeder::class,

            // 8. SDM / Gaji Relawan
            GajiRelawanSeeder::class,
        ]);

        $this->command->info('✅ All seeders completed successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('   - 5 Roles with Permissions');
        $this->command->info('   - 10 Users (across all roles)');
        $this->command->info('   - 6 Schools with Coordinators');
        $this->command->info('   - 8 Suppliers');
        $this->command->info('   - 8 Raw Materials with Nutrition Data');
        $this->command->info('   - 4 Menus with Compositions');
        $this->command->info('   - 17 Stock Transactions');
        $this->command->info('');
        $this->command->info('🔐 Login Credentials:');
        $this->command->info('   Super Admin: superadmin@mbg.id / password');
        $this->command->info('   Admin MBG:   admin@mbg.id / password');
        $this->command->info('   Koordinator: budi.koordinator@mbg.id / password');
        $this->command->info('   Dapur:       fatimah.dapur@mbg.id / password');
        $this->command->info('   Supplier:    supplier1@mbg.id / password');
    }
}
