<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'unit',
        'price_per_unit',
        'code',
        'description',
        'is_active',
        'sppg_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_unit' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function nutrition(): HasOne
    {
        return $this->hasOne(RawMaterialNutrition::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get current stock balance
     */
    public function getCurrentStock(): float
    {
        $stockIn = $this->stocks()->where('type', 'in')->sum('quantity');
        $stockOut = $this->stocks()->where('type', 'out')->sum('quantity');
        
        return $stockIn - $stockOut;
    }
}
