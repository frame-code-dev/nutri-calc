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
        'energy_per_100g',
        'protein_per_100g',
        'fat_per_100g',
        'carbohydrate_per_100g',
        'fiber_per_100g',
    ];

    protected $casts = [
        'energy_per_100g' => 'decimal:2',
        'protein_per_100g' => 'decimal:2',
        'fat_per_100g' => 'decimal:2',
        'carbohydrate_per_100g' => 'decimal:2',
        'fiber_per_100g' => 'decimal:2',
    ];

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }
}
