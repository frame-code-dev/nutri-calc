# Management Gizi - Setup Guide

## 🚀 Quick Setup Instructions

Follow these steps to get the Management Gizi up and running on your local machine.

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL or PostgreSQL
- Node.js & NPM

### Step-by-Step Setup

#### 1. Navigate to Project Directory

```bash
cd "d:\Data Freelance\Project Freelance\mbg-system"
```

#### 2. Install PHP Dependencies

```bash
composer install
```

This will install:

- Laravel 12 framework
- Spatie Laravel Permission (already added)
- Other dependencies

#### 3. Install Laravel Breeze (Authentication)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

When prompted, choose:

- **Stack**: Blade
- **Dark mode**: No (or Yes, your preference)
- **Testing framework**: Pest (or PHPUnit)

#### 4. Setup Environment File

```bash
# Copy the example environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

#### 5. Configure Database

Open `.env` file and update database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mbg_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

**Create the database in MySQL:**

```sql
CREATE DATABASE mbg_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or using command line:

```bash
mysql -u root -p
CREATE DATABASE mbg_system;
exit;
```

#### 6. Publish Spatie Permission Config

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

#### 7. Run Migrations

```bash
php artisan migrate
```

This will create all 13 tables:

- users, password_resets, sessions (Laravel/Breeze)
- roles, permissions, role_has_permissions, model_has_roles, model_has_permissions (Spatie)
- schools, school_coordinators, suppliers
- raw_materials, raw_material_nutritions, stocks
- menus, menu_items
- school_calendars, weekly_locks
- rabs, rab_details
- notifications_log

#### 8. Run Seeders

```bash
php artisan db:seed
```

This will populate:

- ✅ 5 Roles with 40+ Permissions
- ✅ 10 Sample Users (all roles)
- ✅ 6 Schools with Coordinators
- ✅ 8 Suppliers
- ✅ 8 Raw Materials with Nutrition Data
- ✅ 4 Sample Menus
- ✅ 17 Stock Transactions

#### 9. Install & Build Frontend Assets

```bash
npm install
npm run dev
```

Keep this terminal open for hot-reload during development.

Or build for production:

```bash
npm run build
```

#### 10. Start Development Server

Open a **new terminal** and run:

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## 🔐 Login Credentials

After seeding, you can login with these accounts:

| Role                    | Email                   | Password |
| ----------------------- | ----------------------- | -------- |
| **Super Admin**         | superadmin@mbg.id       | password |
| **Admin MBG**           | admin@mbg.id            | password |
| **Koordinator Sekolah** | budi.koordinator@mbg.id | password |
| **Koordinator Dapur**   | fatimah.dapur@mbg.id    | password |
| **Supplier**            | supplier1@mbg.id        | password |

---

## 🧪 Testing the System

### 1. Test Authentication

Visit: `http://localhost:8000/login`

Login with any of the credentials above.

### 2. Test Nutrition Calculation

To see the automatic nutrition calculation in action:

```bash
php artisan tinker
```

Then run:

```php
// Get a menu
$menu = App\Models\Menu::find(1);

// Calculate nutrition automatically
$nutrition = $menu->calculateNutrition();
print_r($nutrition);

// Expected output:
// Array
// (
//     [energy] => 701.5
//     [protein] => 53.5
//     [fat] => 27.5
//     [carbohydrate] => 71.8
//     [fiber] => 3.3
// )
```

### 3. View Menu Detail Page

Visit: `http://localhost:8000/menus/1`

You should see the **Menu Ayam Riza** with:

- ✅ Beautiful nutrition cards showing all 5 nutrients
- ✅ Ingredients table
- ✅ Auto-calculated values

### 4. Test Stock Balance

```php
php artisan tinker

$ayam = App\Models\RawMaterial::where('name', 'Ayam Goreng')->first();
echo "Current Stock: " . $ayam->getCurrentStock() . " gram\n";
// Should show: 65000 gram (80000 in - 15000 out)
```

---

## 📁 What's Been Created

### Migrations (13 files)

✅ All database tables with proper relationships

### Models (13 files)

✅ All Eloquent models with relationships:

- School, SchoolCoordinator, Supplier
- RawMaterial, RawMaterialNutrition, Stock
- Menu ⭐ (with calculateNutrition()), MenuItem
- SchoolCalendar, WeeklyLock
- Rab, RabDetail, NotificationLog

### Services (1 file)

✅ NutritionCalculator.php ⭐

### Controllers (1 file)

✅ MenuController.php ⭐

### Seeders (7 files)

✅ Complete sample data:

1. RolePermissionSeeder
2. UserSeeder
3. SchoolSeeder
4. SupplierSeeder
5. RawMaterialSeeder
6. MenuSeeder
7. StockSeeder

### Views (2 files)

✅ menus/show.blade.php ⭐ (nutrition display)
✅ welcome.blade.php (demo page)

---

## 🎯 Core Features Ready

### ⭐ Automatic Nutritional Calculation

- **Status**: 100% Functional
- **Location**: Menu model, NutritionCalculator service
- **UI**: Beautiful Tailwind CSS cards
- **Calculation**: Real-time based on ingredients

### 🏫 Schools Management

- **Models**: School, SchoolCoordinator
- **Sample Data**: 6 schools, various student counts
- **Coordinators**: Linked to users with WhatsApp numbers

### 📦 Inventory System

- **Models**: RawMaterial, Stock, Supplier
- **Features**: Stock IN/OUT tracking, current balance calculation
- **Sample Data**: 8 materials, 8 suppliers, 17 transactions

### 🍽️ Menu System

- **Models**: Menu, MenuItem
- **Features**: Wet/dry types, composition management
- **Nutrition**: Automatic calculation for all nutrients
- **Sample Data**: 4 ready-to-use menus

---

## 🐛 Troubleshooting

### Migration Error: "Table already exists"

```bash
php artisan migrate:fresh
php artisan db:seed
```

⚠️ **Warning**: This will drop all tables and data!

### Composer Memory Error

```bash
php -d memory_limit=-1 $(which composer) install
```

### NPM Build Issues

```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### Permission Errors (Spatie)

Make sure you run:

```bash
php artisan cache:clear
php artisan config:clear
```

### Can't See Roles/Permissions

Clear cache:

```bash
php artisan optimize:clear
```

---

## 📊 Database Overview

After migration and seeding, you'll have:

```
📁 Management Gizi Database
├── 👥 Users & Auth (8 tables)
│   ├── users
│   ├── roles (5 roles)
│   ├── permissions (40+ permissions)
│   └── ... (Spatie tables)
│
├── 🏫 Schools (2 tables)
│   ├── schools (6 schools)
│   └── school_coordinators (6+ coordinators)
│
├── 📦 Inventory (4 tables)
│   ├── suppliers (8 suppliers)
│   ├── raw_materials (8 materials)
│   ├── raw_material_nutritions (nutrition per 100g)
│   └── stocks (17 transactions)
│
├── 🍽️ Menus (2 tables)
│   ├── menus (4 menus)
│   └── menu_items (compositions)
│
├── 📅 Planning (2 tables)
│   ├── school_calendars
│   └── weekly_locks
│
├── 💰 Budget (2 tables)
│   ├── rabs
│   └── rab_details
│
└── 📱 Notifications (1 table)
    └── notifications_log
```

---

## 🔄 Reset & Reseed

If you want to start fresh:

```bash
# Drop all tables and recreate
php artisan migrate:fresh

# Reseed all data
php artisan db:seed
```

Or in one command:

```bash
php artisan migrate:fresh --seed
```

---

## ✅ Verification Checklist

After setup, verify:

- [ ] Can access http://localhost:8000
- [ ] Can login with provided credentials
- [ ] Can view `/menus/1` with nutrition display
- [ ] All 5 nutrients are calculated and shown
- [ ] Tables have data (check in MySQL)
- [ ] No console errors in browser

---

## 🚀 Next Development Steps

Now that Phase 3 is complete, continue with:

1. **Complete CRUD Controllers**
    - SchoolController
    - RawMaterialController
    - StockController
    - etc.

2. **Build Dashboards**
    - Admin dashboard with charts
    - Coordinator dashboards
    - Reports

3. **WhatsApp Integration**
    - Setup Fonnte API
    - Create notification service
    - Setup scheduler

4. **Advanced Features**
    - Weekly locking mechanism
    - RAB generation
    - Calendar management

---

## 📝 Notes

- Default password for all users: **password**
- Change in production!
- Seeded data is for **demonstration only**
- WhatsApp numbers are fictitious

---

**🎉 Setup Complete! Happy Coding!**
