<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing data
        $schools = DB::table('schools')->get();
        foreach ($schools as $school) {
            if ($school->kloter_id) {
                DB::table('school_distributions')->insert([
                    'school_id' => $school->id,
                    'kloter_id' => $school->kloter_id,
                    'distribution_unit_id' => $school->distribution_unit_id,
                    'name' => null, // fallback to school name in code
                    'small_portion_count' => $school->small_portion_count,
                    'large_portion_count' => $school->large_portion_count,
                    'teacher_count' => $school->teacher_count,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Drop old columns from schools
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['kloter_id']);
            $table->dropForeign(['distribution_unit_id']);
            $table->dropColumn(['kloter_id', 'distribution_unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->foreignId('kloter_id')->nullable()->constrained('kloters')->onDelete('set null');
            $table->foreignId('distribution_unit_id')->nullable()->constrained('distribution_units')->onDelete('set null');
        });

        // Restore data (best effort)
        $distributions = DB::table('school_distributions')->get();
        foreach ($distributions as $dist) {
            DB::table('schools')->where('id', $dist->school_id)->update([
                'kloter_id' => $dist->kloter_id,
                'distribution_unit_id' => $dist->distribution_unit_id,
            ]);
        }
    }
};
