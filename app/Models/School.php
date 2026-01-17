<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'student_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'student_count' => 'integer',
    ];

    public function coordinators(): HasMany
    {
        return $this->hasMany(SchoolCoordinator::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(SchoolCalendar::class);
    }

    public function rabs(): HasMany
    {
        return $this->hasMany(Rab::class);
    }

    public function weeklyStatuses(): HasMany
    {
        return $this->hasMany(SchoolWeeklyStatus::class);
    }

    /**
     * Get the primary/latest coordinator
     */
    public function coordinator()
    {
        return $this->hasOne(SchoolCoordinator::class)->latest();
    }
}
