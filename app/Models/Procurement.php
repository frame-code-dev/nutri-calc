<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Procurement extends Model
{
    use HasFactory, HasSppg;

    protected $fillable = [
        'date',
        'raw_material_id',
        'quantity',
        'price_per_unit',
        'total_cost',
        'status',
        'notes',
        'created_by',
        'sppg_id',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:3',
        'price_per_unit' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function rawMaterial(): BelongsTo
    {
        return $this->belongsTo(RawMaterial::class);
    }
}
