<?php

namespace App\Models;

use App\Models\Traits\HasSppg;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\LogsActivity;

class DocumentAttachment extends Model
{
    use HasFactory, HasSppg, LogsActivity;

    protected $fillable = [
        'sppg_id',
        'created_by',
        'title',
        'description',
        'files'
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
