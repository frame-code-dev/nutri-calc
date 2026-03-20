<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolWeeklyStatus extends Model
{
    use HasFactory, HasSppg;

    protected $fillable = [
        'school_id',
        'week',
        'year',
        'is_locked',
        'locked_at',
        'locked_by',
        'sppg_id',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'locked_at' => 'datetime',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function locker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }
}
