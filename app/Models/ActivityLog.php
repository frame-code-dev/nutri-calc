<?php

namespace App\Models;

use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory, HasSppg;

    protected $fillable = [
        'sppg_id',
        'user_id',
        'model_type',
        'model_id',
        'action',
        'description',
        'changes',
        'ip_address'
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function target()
    {
        return $this->morphTo('target', 'model_type', 'model_id');
    }
}
