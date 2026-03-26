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
            $table->string('nota_path')->nullable()->after('notes');
            $table->text('nota_notes')->nullable()->after('nota_path');
            $table->enum('nota_status', ['pending', 'selesai'])->default('pending')->after('nota_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_history_days', function (Blueprint $table) {
            $table->dropColumn(['nota_path', 'nota_notes', 'nota_status']);
        });
    }
};
