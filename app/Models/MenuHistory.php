<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor',
        'week_number',
        'year',
        'start_date',
        'end_date',
        'description',
        'sppg_id',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'week_number' => 'integer',
        'year'        => 'integer',
    ];

    // ──────────────────────────────────────────
    // Relations
    // ──────────────────────────────────────────

    public function days(): HasMany
    {
        return $this->hasMany(MenuHistoryDay::class)->orderBy('date');
    }

    public function sppg(): BelongsTo
    {
        return $this->belongsTo(MasterSppg::class, 'sppg_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ──────────────────────────────────────────
    // Auto-number generator: BulanTahunUrutanSppg
    // Format contoh: 0320260001 (Maret 2026 urutan 1)
    // ──────────────────────────────────────────

    public static function generateNomor(int $month, int $year, ?int $sppgId = null): string
    {
        $prefix = str_pad($month, 2, '0', STR_PAD_LEFT) . $year;

        $last = self::where('nomor', 'LIKE', $prefix . '%')
            ->when($sppgId, fn($q) => $q->where('sppg_id', $sppgId))
            ->orderByDesc('nomor')
            ->first();

        $seq = $last
            ? ((int) substr($last->nomor, strlen($prefix))) + 1
            : 1;

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    public function getCompletionPercentAttribute(): int
    {
        $total   = $this->days->count();
        if ($total === 0) return 0;
        $done    = $this->days->where('status', 'selesai')->count();
        return (int) round(($done / $total) * 100);
    }
}
