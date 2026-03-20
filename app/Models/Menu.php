<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory, HasSppg;

    protected $fillable = [
        'name',
        'type',
        'category', // master, packet
        'description',
        'is_active',
        'parent_id',
        'version',
        'code',
        'sppg_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(SchoolCalendar::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(MenuSchedule::class);
    }

    /**
     * Calculate total nutrition for this menu
     * Returns array with energy, protein, fat, carbohydrate, fiber
     */
    public function calculateNutrition(): array
    {
        $totals = [
            'energy' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrate' => 0,
            'fiber' => 0,
        ];

        foreach ($this->menuItems as $item) {
            $nutrition = $item->rawMaterial->nutrition;
            
            if ($nutrition) {
                // Convert quantity to per-100g basis
                $quantityIn100g = $item->quantity_per_portion / 100;
                
                $totals['energy'] += $nutrition->energy_per_100g * $quantityIn100g;
                $totals['protein'] += $nutrition->protein_per_100g * $quantityIn100g;
                $totals['fat'] += $nutrition->fat_per_100g * $quantityIn100g;
                $totals['carbohydrate'] += $nutrition->carbohydrate_per_100g * $quantityIn100g;
                $totals['fiber'] += $nutrition->fiber_per_100g * $quantityIn100g;
            }
        }

        // Round to 2 decimal places
        return array_map(fn($value) => round($value, 2), $totals);
    }
}
