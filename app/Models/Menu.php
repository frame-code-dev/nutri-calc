<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\LogsActivity;

class Menu extends Model
{
    use HasFactory, HasSppg, LogsActivity;

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

    /**
     * Master components that belong to this packet (via parent_id).
     */
    public function components(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    /**
     * Return ALL raw-material items for this menu:
     *  - If category = 'master'  → own menuItems
     *  - If category = 'packet'  → flatten items from all master components
     *
     * Use this everywhere instead of $menu->menuItems when the menu could be
     * a packet (Kebutuhan Bahan Baku, Share ke Dapur, seeder stock, etc.).
     */
    public function allMenuItems(): \Illuminate\Support\Collection
    {
        if ($this->category === 'packet') {
            return $this->components()
                ->with('menuItems.rawMaterial.nutrition')
                ->get()
                ->flatMap(fn ($component) => $component->menuItems);
        }

        // Already a master component — return own items
        return $this->menuItems()->with('rawMaterial.nutrition')->get();
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
            'energy'       => 0,
            'protein'      => 0,
            'fat'          => 0,
            'carbohydrate' => 0,
            'fiber'        => 0,
        ];

        // Use allMenuItems() so packets resolve through their components
        foreach ($this->allMenuItems() as $item) {
            $nutrition = $item->rawMaterial?->nutrition;

            if ($nutrition) {
                $quantityIn100g = $item->quantity_per_portion / 100;

                $totals['energy']       += $nutrition->energy_per_100g       * $quantityIn100g;
                $totals['protein']      += $nutrition->protein_per_100g      * $quantityIn100g;
                $totals['fat']          += $nutrition->fat_per_100g          * $quantityIn100g;
                $totals['carbohydrate'] += $nutrition->carbohydrate_per_100g * $quantityIn100g;
                $totals['fiber']        += $nutrition->fiber_per_100g        * $quantityIn100g;
            }
        }

        // Round to 2 decimal places
        return array_map(fn ($value) => round($value, 2), $totals);
    }
}
