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
        Schema::table('schools', function (Blueprint $table) {
            $table->integer('small_portion_count')->default(0)->after('student_count');
            $table->integer('large_portion_count')->default(0)->after('small_portion_count');
        });

        Schema::table('school_calendars', function (Blueprint $table) {
            $table->integer('small_portion_count')->default(0)->after('portion_count');
            $table->integer('large_portion_count')->default(0)->after('small_portion_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['small_portion_count', 'large_portion_count']);
        });

        Schema::table('school_calendars', function (Blueprint $table) {
            $table->dropColumn(['small_portion_count', 'large_portion_count']);
        });
    }
};
