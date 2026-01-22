<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('group_name')->nullable()->after('menu_id');
            // Drop unique constraint if exists to allow same material in different groups if needed
            $table->dropUnique(['menu_id', 'raw_material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('group_name');
            $table->unique(['menu_id', 'raw_material_id']);
        });
    }
};
