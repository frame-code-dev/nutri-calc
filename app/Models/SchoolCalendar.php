<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'date',
        'day_status',
        'menu_id',
        'allergy_menu_id',
        'allergy_notes',
        'portion_count',
        'small_portion_count',
        'large_portion_count',
        'week_number',
        'year',
        'sppg_id',
    ];

    protected $casts = [
        'date' => 'date',
        'portion_count' => 'integer',
        'small_portion_count' => 'integer',
        'large_portion_count' => 'integer',
        'week_number' => 'integer',
        'year' => 'integer',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function allergyMenu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'allergy_menu_id');
    }
}
