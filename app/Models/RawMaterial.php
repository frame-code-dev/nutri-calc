<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RawMaterial extends Model
{
    use HasFactory, HasSppg;

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
        // Gunakan eager-loaded sum jika tersedia untuk mencegah N+1 query
        if (array_key_exists('stock_in', $this->attributes) && array_key_exists('stock_out', $this->attributes)) {
            return (float) ($this->stock_in ?? 0) - (float) ($this->stock_out ?? 0);
        }

        $stockIn = $this->stocks()->where('type', 'in')->sum('quantity');
        $stockOut = $this->stocks()->where('type', 'out')->sum('quantity');
        
        return $stockIn - $stockOut;
    }
}
