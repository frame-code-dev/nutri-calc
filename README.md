# MBG (Makan Bergizi Gratis) System

Sistem aplikasi berbasis web untuk mengelola distribusi makanan bergizi gratis ke sekolah dengan fitur perhitungan gizi otomatis, manajemen stok, RAB, dan notifikasi WhatsApp.

## 🎯 Status Saat Ini

### ✅ Sudah Dikerjakan

#### Database & Models (100%)
- ✅ 13 Migration files untuk complete database schema
- ✅ 13 Eloquent Models dengan relationships lengkap
- ✅ Foreign keys dan indexes teroptimasi

#### **Fitur Star: Automatic Nutritional Calculation** ⭐
- ✅ Perhitungan otomatis gizi per menu
- ✅ NutritionCalculator service (4 methods)
- ✅ Integration pada Menu model
- ✅ Beautiful UI dengan Tailwind CSS
- ✅ Real-time calculation display

#### Controllers & Views
- ✅ MenuController (Full CRUD + nutrition)
- ✅ Menu detail view dengan tampilan gizi
- ✅ Demo landing page
- ✅ Routes configured

#### Sample Data
- ✅ RawMaterialSeeder (8 bahan baku)
- ✅ MenuSeeder (4 sample menus)

### 🚧 Belum Dikerjakan (Fase Berikutnya)

- Laravel Breeze installation
- Spatie Permission setup
- Controllers untuk modules lain (School, Stock, Calendar, RAB, dll)
- WhatsApp Gateway integration
- Dashboards
- Reports & Analytics
- Complete UI/UX

## 📋 Quick Start (Yang Harus Dilakukan)

### 1. Install Dependencies

```bash
cd "d:\Data Freelance\Project Freelance\mbg-system"

# Install Composer dependencies (jika belum)
composer install

# Install Laravel Breeze
composer require laravel/breeze --dev
php artisan breeze:install blade

# Install Spatie Permission
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 2. Setup Environment

```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Setup database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=mbg_system
# DB_USERNAME=root
# DB_PASSWORD=
```

### 3. Run Migrations & Seeders

```bash
# Create database first, then run:
php artisan migrate

# Seed sample data
php artisan db:seed
```

### 4. Build Assets

```bash
# Install NPM dependencies
npm install

# Build assets
npm run dev
```

### 5. Start Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 🧮 Cara Kerja Automatic Nutrition Calculation

### Konsep Dasar

1. **Raw Material Nutrition** - Data nutrisi per 100g
2. **Menu Items** - Jumlah bahan per porsi (gram/ml)
3. **Automatic Calculation** - `(quantity / 100) × nutrition_per_100g`

### Contoh

**Menu Ayam Riza:**
- Ayam Goreng: 150g
  - Energi: 239 kkal/100g → (150/100) × 239 = 358.5 kkal
- Susu: 200ml
  - Energi: 61 kkal/100ml → (200/100) × 61 = 122 kkal
- Sayur Kol: 100g
  - Energi: 25 kkal/100g → (100/100) × 25 = 25 kkal
- Nasi: 200g
  - Energi: 130 kkal/100g → (200/100) × 130 = 260 kkal

**Total Otomatis: 765.5 kkal** ✅

## 📁 Struktur File Utama

### Models
- `app/Models/Menu.php` - **Punya method calculateNutrition()**
- `app/Models/RawMaterial.php` - Dengan getCurrentStock()
- `app/Models/RawMaterialNutrition.php` - Data per 100g
- 10 models lainnya

### Services
- `app/Services/NutritionCalculator.php` - **Service untuk kalkulasi**

### Controllers
- `app/Http/Controllers/MenuController.php` - CRUD + nutrition

### Views
- `resources/views/menus/show.blade.php` - **Tampilan gizi otomatis**
- `resources/views/welcome.blade.php` - Demo page

### Migrations
- `database/migrations/2026_01_12_*_create_*_table.php` (13 files)

### Seeders
- `database/seeders/RawMaterialSeeder.php`
- `database/seeders/MenuSeeder.php`

## 🎨 Fitur UI

### Menu Detail View Features:
- ✅ 5 nutrition cards (Energy, Protein, Fat, Carbs, Fiber)
- ✅ Gradient color schemes
- ✅ SVG icons per nutrient
- ✅ Ingredients table dengan kontribusi energi
- ✅ Responsive design (mobile & desktop)
- ✅ "Otomatis Terhitung" badge

## 📊 Database Schema

### Core Tables
- `schools` - Data sekolah
- `school_coordinators` - Koordinator sekolah
- `users` - Authentication

### Inventory
- `raw_materials` - Bahan baku
- `raw_material_nutritions` - **Data gizi per 100g**
- `stocks` - Transaksi stok
- `suppliers` - Supplier

### Menu System
- `menus` - Menu (wet/dry)
- `menu_items` - **Komposisi menu**

### Planning
- `school_calendars` - Jadwal harian
- `weekly_locks` - Lock mingguan
- `rabs` - Budget
- `rab_details` - Detail budget

### Notifications
- `notifications_log` - Log WhatsApp

## 🚀 Next Development Steps

### Priority 1: Authentication
1. Configure Laravel Breeze
2. Setup Spatie Permission
3. Create roles & permissions seeder
4. Test login system

### Priority 2: Complete CRUD
1. SchoolController
2. RawMaterialController
3. StockController
4. SchoolCalendarController

### Priority 3: Advanced Features
1. Weekly Lock mechanism
2. RAB generation system
3. WhatsApp integration (Fonnte)
4. Scheduler for auto-notifications

### Priority 4: Dashboards
1. Admin Dashboard dengan charts
2. Coordinator Dashboard
3. Reports & Analytics

## 🧪 Testing

### Test Nutrition Calculation

```bash
php artisan tinker
```

```php
$menu = Menu::find(1);
$nutrition = $menu->calculateNutrition();
print_r($nutrition);
// Output: ['energy' => X, 'protein' => Y, ...]
```

### Test Nutrition Calculator Service

```php
$calc = new App\Services\NutritionCalculator();
$school = App\Models\School::find(1);
$nutrition = $calc->calculateSchoolWeeklyNutrition($school, 3, 2026);
```

## 📱 WhatsApp Integration (Future)

```env
FONNTE_API_KEY=your_api_key_here
FONNTE_URL=https://api.fonnte.com/send
```

## 🔐 Roles & Permissions (Future)

- Super Admin
- Admin MBG
- Koordinator Sekolah
- Koordinator Dapur
- Supplier

## 📝 Notes

- Laravel Version: **12.x** (Latest)
- PHP Version: **^8.2**
- Database: MySQL/PostgreSQL
- Frontend: Blade + Tailwind CSS
- Notifications: WhatsApp (Fonnte - planned)

## 🎯 Main Achievement

**✅ AUTOMATIC NUTRITIONAL CALCULATION SYSTEM IS READY!**

Sistem sekarang bisa:
1. Menyimpan data gizi per bahan
2. Membuat menu dengan komposisi
3. **Menghitung gizi otomatis** ⭐
4. Menampilkan dengan UI modern
5. Scale ke level sekolah & mingguan

## 🤝 Contributing

Sistem ini siap dikembangkan lebih lanjut. Fokus berikutnya:
- Complete authentication
- Additional CRUD modules
- WhatsApp notifications
- Weekly locking system

## 📄 License

MIT License

---

**Built with ❤️ using Laravel 12, Blade, and Tailwind CSS**
