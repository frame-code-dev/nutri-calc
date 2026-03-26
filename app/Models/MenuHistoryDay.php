<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuHistoryDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_history_id',
        'date',
        'day_name',
        'menu_id',
        'photo_path',
        'status',
        'uploaded_by',
        'uploaded_at',
        'notes',
        'nota_paths',
        'nota_notes',
        'nota_status',
    ];

    protected $casts = [
        'date'        => 'date',
        'uploaded_at' => 'datetime',
        'nota_paths'  => 'array',
    ];

    public function menuHistory(): BelongsTo
    {
        return $this->belongsTo(MenuHistory::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? asset('storage/' . $this->photo_path) : null;
    }

    public function getNotaUrlsAttribute(): array
    {
        $urls = [];
        if (is_array($this->nota_paths)) {
            foreach ($this->nota_paths as $path) {
                $urls[] = asset('storage/' . $path);
            }
        }
        return $urls;
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }
}
