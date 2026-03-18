<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'sppg_id',
        'jabatan',
        'upah_per_hari',
    ];

    protected $casts = [
        'upah_per_hari' => 'decimal:2',
    ];

    public function sppg()
    {
        return $this->belongsTo(MasterSppg::class, 'sppg_id');
    }
}
