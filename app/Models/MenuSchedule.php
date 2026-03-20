<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuSchedule extends Model
{
    use HasFactory, HasSppg;

    protected $fillable = [
        'date',
        'menu_id',
        'description',
        'created_by',
        'sppg_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
