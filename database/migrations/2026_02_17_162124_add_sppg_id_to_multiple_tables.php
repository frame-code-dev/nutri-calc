<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected array $tables = [
        'categories',
        'distribution_units',
        'kloters',
        'menu_items',
        'menu_schedules',
        'menus',
        'procurements',
        'rab_details',
        'rabs',
        'raw_material_nutritions',
        'raw_materials',
        'school_calendars',
        'school_coordinators',
        'school_distributions',
        'school_weekly_statuses',
        'schools',
        'stocks',
        'suppliers',
        'weekly_locks',
    ];
    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->bigInteger('sppg_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('sppg_id');
            });
        }
    }
};
