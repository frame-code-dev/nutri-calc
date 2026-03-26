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
        Schema::table('menu_history_days', function (Blueprint $table) {
            $table->dropColumn('nota_path');
            $table->json('nota_paths')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_history_days', function (Blueprint $table) {
            $table->dropColumn('nota_paths');
            $table->string('nota_path')->nullable()->after('notes');
        });
    }
};
