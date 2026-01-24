<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // User Management
            'manage users',
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // School Management
            'manage schools',
            'view schools',
            'manage coordinators',
            
            // Supplier Management
            'manage suppliers',
            'view suppliers',
            
            // Raw Material & Stock Management
            'manage raw materials',
            'view raw materials',
            'manage categories',
            'view categories',
            'manage nutrition data',
            'manage stocks',
            'view stocks',
            'update stock',
            
            // Menu Management
            'manage menus',
            'view menus',
            'create menus',
            'edit menus',
            'delete menus',
            
            // Calendar & Weekly Status
            'manage school calendar',
            'view school calendar',
            'update weekly status',
            
            // Weekly Lock
            'lock weekly data',
            'view weekly locks',
            
            // RAB (Budget) Management
            'manage rab',
            'view rab',
            'generate rab',
            'export rab',
            
            // Notifications
            'send notifications',
            'send manual notifications',
            'view notification logs',
            
            // Reports
            'view all reports',
            'view school reports',
            'export reports',
            
            // Dashboard
            'view admin dashboard',
            'view coordinator dashboard',
            'view supplier dashboard',
            'manage procurement',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        // 1. Super Admin - Full Access
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->syncPermissions(Permission::all());

        // 2. Admin MBG / Dapur Pusat
        $adminMBG = Role::firstOrCreate(['name' => 'Admin MBG']);
        $adminMBG->syncPermissions([
            'manage schools',
            'view schools',
            'manage coordinators',
            'manage suppliers',
            'view suppliers',
            'manage raw materials',
            'view raw materials',
            'manage categories',
            'view categories',
            'manage nutrition data',
            'manage stocks',
            'view stocks',
            'manage menus',
            'view menus',
            'create menus',
            'edit menus',
            'delete menus',
            'manage school calendar',
            'manage school calendar',
            'view school calendar',
            'lock weekly data',
            'view weekly locks',
            'manage rab',
            'view rab',
            'generate rab',
            'export rab',
            'send notifications',
            'send manual notifications',
            'view notification logs',
            'view all reports',
            'export reports',
            'view admin dashboard',
        ]);

        // 3. Koordinator Sekolah
        $koordinatorSekolah = Role::firstOrCreate(['name' => 'Koordinator Sekolah']);
        $koordinatorSekolah->syncPermissions([
            'view menus',
            'view school calendar',
            'update weekly status',
            'view school reports',
            'view coordinator dashboard',
        ]);

        // 4. Koordinator Dapur / Produksi
        $koordinatorDapur = Role::firstOrCreate(['name' => 'Koordinator Dapur']);
        $koordinatorDapur->syncPermissions([
            'view menus',
            'view raw materials',
            'view categories',
            'view stocks',
            'view school calendar',
            'view notification logs',
            'view coordinator dashboard',
        ]);

        // 5. Supplier
        $supplier = Role::firstOrCreate(['name' => 'Supplier']);
        $supplier->syncPermissions([
            'view raw materials',
            'view categories',
            'update stock',
            'view stocks',
            'view supplier dashboard',
        ]);

        // 6. Ahli Gizi
        $ahliGizi = Role::firstOrCreate(['name' => 'Ahli Gizi']);
        $ahliGizi->syncPermissions([
            'view raw materials',
            'view categories',
            'manage categories',
            'manage nutrition data', // Specific for nutritionists
            'manage menus',
            'view menus',
            'create menus',
            'edit menus',
            'delete menus',
            'manage school calendar', // To see consumption
            'view all reports',
            'view admin dashboard', // Or a specific dashboard
            'manage procurement', // New Permission
        ]);
    }
}
