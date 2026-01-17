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
        Schema::table('school_calendars', function (Blueprint $table) {
            $table->foreignId('allergy_menu_id')->nullable()->after('menu_id')->constrained('menus')->onDelete('set null');
            $table->text('allergy_notes')->nullable()->after('allergy_menu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_calendars', function (Blueprint $table) {
            $table->dropForeign(['allergy_menu_id']);
            $table->dropColumn(['allergy_menu_id', 'allergy_notes']);
        });
    }
};
