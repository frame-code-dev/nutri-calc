<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rab extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekly_lock_id',
        'school_id',
        'total_budget',
        'total_portions',
    ];

    protected $casts = [
        'total_budget' => 'decimal:2',
        'total_portions' => 'integer',
    ];

    public function weeklyLock(): BelongsTo
    {
        return $this->belongsTo(WeeklyLock::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(RabDetail::class);
    }
}
