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
        Schema::create('raw_material_nutritions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raw_material_id')->constrained()->onDelete('cascade');
            $table->decimal('energy_per_100g', 10, 2)->default(0)->comment('kcal');
            $table->decimal('protein_per_100g', 10, 2)->default(0)->comment('grams');
            $table->decimal('fat_per_100g', 10, 2)->default(0)->comment('grams');
            $table->decimal('carbohydrate_per_100g', 10, 2)->default(0)->comment('grams');
            $table->decimal('fiber_per_100g', 10, 2)->default(0)->comment('grams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_material_nutritions');
    }
};
