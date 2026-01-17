<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RabDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rab_id',
        'menu_id',
        'raw_material_id',
        'quantity',
        'price_per_unit',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'price_per_unit' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function rab(): BelongsTo
    {
        return $this->belongsTo(Rab::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }
}
