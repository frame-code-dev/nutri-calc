<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeeklyLock extends Model
{
    use HasFactory, HasSppg;

    protected $fillable = [
        'week_number',
        'year',
        'week_start_date',
        'week_end_date',
        'status',
        'locked_by',
        'locked_at',
        'sppg_id',
    ];

    protected $casts = [
        'week_number' => 'integer',
        'year' => 'integer',
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'locked_at' => 'datetime',
    ];

    public function lockedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function rabs(): HasMany
    {
        return $this->hasMany(Rab::class);
    }
}
