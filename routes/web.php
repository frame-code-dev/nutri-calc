<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KloterController;
use App\Http\Controllers\MasterSppgController;
use App\Http\Controllers\NutritionReportController;
use App\Http\Controllers\SchoolCalendarController;
use App\Http\Controllers\WeeklyLockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Reports
Route::group(['prefix' => 'reports', 'as' => 'reports.', 'middleware' => 'auth'], function () {
    Route::get('weekly-menu', [\App\Http\Controllers\MenuScheduleController::class, 'weeklyReportView'])->name('weekly-menu');
    Route::post('weekly-menu/export', [\App\Http\Controllers\MenuScheduleController::class, 'exportWeeklyExcel'])->name('weekly-menu.export');
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/coordinator', [DashboardController::class, 'coordinator'])->name('dashboard.coordinator');
    Route::get('/dashboard/kitchen', [DashboardController::class, 'kitchen'])->name('dashboard.kitchen');
    Route::get('/dashboard/supplier', [DashboardController::class, 'supplier'])->name('dashboard.supplier');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class);

    // Schools Management
    Route::resource('schools', SchoolController::class);
    Route::post('schools/{school}/toggle-status', [SchoolController::class, 'toggleStatus'])->name('schools.toggle-status');
    Route::get('schools/{school}/coordinators', [SchoolController::class, 'coordinators'])->name('schools.coordinators');
    Route::post('schools/{school}/coordinators', [SchoolController::class, 'addCoordinator'])->name('schools.add-coordinator');

    // Suppliers Management
    Route::resource('suppliers', SupplierController::class);
    Route::post('suppliers/{supplier}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');

    // Raw Materials Management
    Route::resource('raw-materials', RawMaterialController::class);
    Route::post('raw-materials/{rawMaterial}/toggle-status', [RawMaterialController::class, 'toggleStatus'])->name('raw-materials.toggle-status');

    // Categories Management
    Route::resource('categories', CategoryController::class); // Added this line

    // Stock Management
    Route::get('stocks/summary', [StockController::class, 'summary'])->name('stocks.summary');
    Route::resource('stocks', StockController::class);

    // Generate Menu
    Route::get('menus/generate', [App\Http\Controllers\MenuGenerationController::class, 'index'])->name('menus.generate');
    Route::post('menus/generate', [App\Http\Controllers\MenuGenerationController::class, 'store'])->name('menus.generate.store');

    // Menu Management with Automatic Nutritional Calculation
    Route::get('menus/export-all-master', [MenuController::class, 'exportAllMasterWord'])->name('menus.export-all-master');
    Route::resource('menus', MenuController::class);
    Route::get('menus/{menu}/export-word', [MenuController::class, 'exportWord'])->name('menus.export-word');
    Route::post('menus/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menus.toggle-status');

    // Kloter (Batch) Management
    Route::get('kloters/{kloter}/export-pdf', [KloterController::class, 'exportPdf'])->name('kloters.export-pdf');
    Route::resource('kloters', KloterController::class);

    // Distribution Dashboard & Settings
    Route::get('distribution', [\App\Http\Controllers\DistributionController::class, 'index'])->name('distribution.index');
    Route::get('distribution/export-word', [\App\Http\Controllers\DistributionController::class, 'exportWord'])->name('distribution.export-word');
    Route::get('distribution/settings', [\App\Http\Controllers\DistributionController::class, 'settings'])->name('distribution.settings');
    Route::post('distribution/settings', [\App\Http\Controllers\DistributionController::class, 'updateSettings'])->name('distribution.settings.update');

    // Nutrition Reports
    Route::get('nutrition-reports', [NutritionReportController::class, 'index'])->name('nutrition-reports.index');
    Route::get('nutrition-reports/menu/{menu}', [NutritionReportController::class, 'menuReport'])->name('nutrition-reports.menu');
    Route::get('nutrition-reports/school-weekly', [NutritionReportController::class, 'schoolWeeklyReport'])->name('nutrition-reports.school-weekly');
    Route::get('nutrition-reports/weekly-benefits', [NutritionReportController::class, 'weeklyBenefitsReport'])->name('nutrition-reports.weekly-benefits');

    Route::get('nutrition-reports/compare-menus', [NutritionReportController::class, 'compareMenus'])->name('nutrition-reports.compare-menus');

    // Menu Scheduling (Nutritionist)
    Route::resource('menu-schedules', \App\Http\Controllers\MenuScheduleController::class)->only(['index', 'store', 'destroy']);

    // School Calendar & Weekly Status
    Route::get('calendars', [\App\Http\Controllers\SchoolCalendarController::class, 'index'])->name('calendars.index');
    Route::get('calendars/edit-week', [\App\Http\Controllers\SchoolCalendarController::class, 'editWeek'])->name('calendars.edit-week');
    Route::post('calendars/save-week', [\App\Http\Controllers\SchoolCalendarController::class, 'saveWeek'])->name('calendars.save-week');
    Route::post('calendars/update-status', [\App\Http\Controllers\SchoolCalendarController::class, 'updateStatus'])->name('calendars.update-status');
    Route::post('calendars/bulk-update-status', [\App\Http\Controllers\SchoolCalendarController::class, 'bulkUpdateStatus'])->name('calendars.bulk-update-status');
    Route::post('calendars/send-notification', [\App\Http\Controllers\SchoolCalendarController::class, 'sendNotification'])->name('calendars.send-notification');
    Route::delete('calendars/{calendar}', [\App\Http\Controllers\SchoolCalendarController::class, 'destroy'])->name('calendars.destroy');

    // Weekly Locks (Admin only)
    // Weekly Locks (Admin only)
    Route::post('monitoring/lock', [\App\Http\Controllers\WeeklyMonitoringController::class, 'lockSchool'])->name('monitoring.lock-school');
    Route::post('monitoring/unlock', [\App\Http\Controllers\WeeklyMonitoringController::class, 'unlockSchool'])->name('monitoring.unlock-school');

    // Monitoring & WA
    Route::get('monitoring', [\App\Http\Controllers\WeeklyMonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('monitoring/wa/{school}/{week}', [\App\Http\Controllers\WeeklyMonitoringController::class, 'waReminder'])->name('monitoring.wa-reminder');

    // Procurement
    Route::get('procurements', [\App\Http\Controllers\ProcurementController::class, 'index'])->name('procurements.index'); // Shopping List
    Route::get('procurements/office', [\App\Http\Controllers\ProcurementController::class, 'officeInventory'])->name('procurements.office'); // Office Inventory
    Route::post('procurements', [\App\Http\Controllers\ProcurementController::class, 'store'])->name('procurements.store');

    // Nutritionist Dashboard & Menu Schedules
    Route::post('nutritionist/allergy', [\App\Http\Controllers\MenuScheduleController::class, 'saveAllergy'])->name('nutritionist.save-allergy');
    
    Route::post('menu-schedules/global', [\App\Http\Controllers\MenuScheduleController::class, 'storeGlobal'])->name('menu-schedules.store-global');
    Route::resource('menu-schedules', \App\Http\Controllers\MenuScheduleController::class)->only(['index', 'store']);
    Route::post('menu-schedules/clear', [\App\Http\Controllers\MenuScheduleController::class, 'destroy'])->name('menu-schedules.clear');

    // master sppg 
    Route::resource('master-sppg', MasterSppgController::class);
    Route::post('master-sppg/{masterSppg}/toggle-status', [MasterSppgController::class, 'toggleStatus'])->name('master-sppg.toggle-status');
        
});

require __DIR__.'/auth.php';
