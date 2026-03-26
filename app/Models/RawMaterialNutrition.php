<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawMaterialNutrition extends Model
{
    use HasFactory;

    protected $table = 'raw_material_nutritions';

    protected $fillable = [
        'raw_material_id',
        // Proximate
        'water_per_100g',
        'energy_per_100g',
        'protein_per_100g',
        'fat_per_100g',
        'carbohydrate_per_100g',
        'fiber_per_100g',
        'ash_per_100g',
        // Minerals
        'calcium_per_100g',
        'phosphorus_per_100g',
        'iron_per_100g',
        'sodium_per_100g',
        'potassium_per_100g',
        'copper_per_100g',
        'zinc_per_100g',
        // Vitamins
        'retinol_per_100g',
        'beta_carotene_per_100g',
        'carotene_per_100g',
        'thiamine_per_100g',
        'riboflavin_per_100g',
        'niacin_per_100g',
        'vitamin_c_per_100g',
        // BDD
        'bdd',
        'sppg_id',
    ];

    protected $casts = [
        'water_per_100g'         => 'decimal:2',
        'energy_per_100g'        => 'decimal:2',
        'protein_per_100g'       => 'decimal:2',
        'fat_per_100g'           => 'decimal:2',
        'carbohydrate_per_100g'  => 'decimal:2',
        'fiber_per_100g'         => 'decimal:2',
        'ash_per_100g'           => 'decimal:2',
        'calcium_per_100g'       => 'decimal:2',
        'phosphorus_per_100g'    => 'decimal:2',
        'iron_per_100g'          => 'decimal:4',
        'sodium_per_100g'        => 'decimal:2',
        'potassium_per_100g'     => 'decimal:2',
        'copper_per_100g'        => 'decimal:4',
        'zinc_per_100g'          => 'decimal:4',
        'retinol_per_100g'       => 'decimal:2',
        'beta_carotene_per_100g' => 'decimal:2',
        'carotene_per_100g'      => 'decimal:2',
        'thiamine_per_100g'      => 'decimal:4',
        'riboflavin_per_100g'    => 'decimal:4',
        'niacin_per_100g'        => 'decimal:4',
        'vitamin_c_per_100g'     => 'decimal:2',
        'bdd'                    => 'decimal:2',
    ];

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }
}
