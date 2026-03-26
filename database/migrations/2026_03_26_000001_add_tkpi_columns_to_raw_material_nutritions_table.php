<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom-kolom TKPI yang belum ada di tabel raw_material_nutritions.
     *
     * Kolom baru (semua nilai per 100 gram BDD):
     *   water_per_100g       — AIR     (g)
     *   ash_per_100g         — ABU     (g)
     *   calcium_per_100g     — KALSI   (mg)
     *   phosphorus_per_100g  — FOSFO   (mg)
     *   iron_per_100g        — BESI    (mg)
     *   sodium_per_100g      — NATRIU  (mg)
     *   potassium_per_100g   — KALIU   (mg)
     *   copper_per_100g      — TEMBA   (mg)
     *   zinc_per_100g        — SENG    (mg)
     *   retinol_per_100g     — RETINO  (mcg)
     *   beta_carotene_per_100g — B-KAR (mcg)
     *   carotene_per_100g    — KAR     (mcg)
     *   thiamine_per_100g    — THIAMI  (mg)
     *   riboflavin_per_100g  — RIBOFL  (mg)
     *   niacin_per_100g      — NIASIN  (mg)
     *   vitamin_c_per_100g   — VIT_C   (mg)
     *   bdd                  — BDD     (%) Bagian Yang Dapat Dimakan
     */
    public function up(): void
    {
        Schema::table('raw_material_nutritions', function (Blueprint $table) {
            // Group 1: Proximate
            $table->decimal('water_per_100g', 10, 2)->default(0)->comment('AIR (g)')->after('raw_material_id');
            $table->decimal('ash_per_100g', 10, 2)->default(0)->comment('ABU (g)')->after('fiber_per_100g');

            // Group 2: Minerals (mg)
            $table->decimal('calcium_per_100g', 10, 2)->default(0)->comment('KALSI (mg)')->after('ash_per_100g');
            $table->decimal('phosphorus_per_100g', 10, 2)->default(0)->comment('FOSFO (mg)')->after('calcium_per_100g');
            $table->decimal('iron_per_100g', 10, 4)->default(0)->comment('BESI (mg)')->after('phosphorus_per_100g');
            $table->decimal('sodium_per_100g', 10, 2)->default(0)->comment('NATRIU (mg)')->after('iron_per_100g');
            $table->decimal('potassium_per_100g', 10, 2)->default(0)->comment('KALIU (mg)')->after('sodium_per_100g');
            $table->decimal('copper_per_100g', 10, 4)->default(0)->comment('TEMBA (mg)')->after('potassium_per_100g');
            $table->decimal('zinc_per_100g', 10, 4)->default(0)->comment('SENG (mg)')->after('copper_per_100g');

            // Group 3: Vitamins (mcg/mg)
            $table->decimal('retinol_per_100g', 10, 2)->default(0)->comment('RETINO (mcg)')->after('zinc_per_100g');
            $table->decimal('beta_carotene_per_100g', 10, 2)->default(0)->comment('B-KAR (mcg)')->after('retinol_per_100g');
            $table->decimal('carotene_per_100g', 10, 2)->default(0)->comment('KAR (mcg)')->after('beta_carotene_per_100g');
            $table->decimal('thiamine_per_100g', 10, 4)->default(0)->comment('THIAMI (mg)')->after('carotene_per_100g');
            $table->decimal('riboflavin_per_100g', 10, 4)->default(0)->comment('RIBOFL (mg)')->after('thiamine_per_100g');
            $table->decimal('niacin_per_100g', 10, 4)->default(0)->comment('NIASIN (mg)')->after('riboflavin_per_100g');
            $table->decimal('vitamin_c_per_100g', 10, 2)->default(0)->comment('VIT_C (mg)')->after('niacin_per_100g');

            // BDD
            $table->decimal('bdd', 5, 2)->default(100)->comment('BDD (%) Bagian Yang Dapat Dimakan')->after('vitamin_c_per_100g');
        });
    }

    public function down(): void
    {
        Schema::table('raw_material_nutritions', function (Blueprint $table) {
            $table->dropColumn([
                'water_per_100g',
                'ash_per_100g',
                'calcium_per_100g',
                'phosphorus_per_100g',
                'iron_per_100g',
                'sodium_per_100g',
                'potassium_per_100g',
                'copper_per_100g',
                'zinc_per_100g',
                'retinol_per_100g',
                'beta_carotene_per_100g',
                'carotene_per_100g',
                'thiamine_per_100g',
                'riboflavin_per_100g',
                'niacin_per_100g',
                'vitamin_c_per_100g',
                'bdd',
            ]);
        });
    }
};
