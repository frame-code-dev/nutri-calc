<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notifications_log';

    protected $fillable = [
        'recipient_phone',
        'recipient_name',
        'message',
        'type',
        'status',
        'response',
        'sent_at',
        'sppg_id',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
