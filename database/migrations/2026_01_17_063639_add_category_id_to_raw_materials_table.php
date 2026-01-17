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
        Schema::table('raw_materials', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('name')->constrained('categories')->onDelete('cascade');
        });

        // Migrate existing data
        $categories = ['food', 'office', 'packaging', 'other'];
        foreach ($categories as $cat) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => ucfirst($cat),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('raw_materials')
                ->where('category', $cat)
                ->update(['category_id' => $categoryId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raw_materials', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
