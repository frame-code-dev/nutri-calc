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
            $table->string('unit')->nullable()->after('quantity_per_portion');
            $table->decimal('quantity_input', 10, 4)->nullable()->after('unit');
            $table->decimal('conversion_factor', 10, 4)->default(1.0)->after('quantity_input');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['unit', 'quantity_input', 'conversion_factor']);
        });
    }
};
