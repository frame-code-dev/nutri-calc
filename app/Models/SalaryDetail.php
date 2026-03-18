<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'relawan_id',
        'hari_kerja',
        'total_hari',
        'upah_per_hari',
        'total_upah',
    ];

    protected $casts = [
        'hari_kerja'    => 'array',
        'upah_per_hari' => 'decimal:2',
        'total_upah'    => 'decimal:2',
    ];

    public function period()
    {
        return $this->belongsTo(SalaryPeriod::class, 'period_id');
    }

    public function relawan()
    {
        return $this->belongsTo(Relawan::class);
    }

    public function components()
    {
        return $this->hasMany(SalaryComponent::class, 'detail_id');
    }

    /**
     * Recalculate total_upah = (total_hari * upah_per_hari) + sum(components)
     */
    public function recalculate(): void
    {
        $base  = $this->total_hari * $this->upah_per_hari;
        $extra = $this->components()->sum('jumlah');
        $this->total_upah = $base + $extra;
        $this->save();
    }
}
