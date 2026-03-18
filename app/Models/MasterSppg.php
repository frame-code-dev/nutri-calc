<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSppg extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instagram',
        'tiktok',
        'alamat',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'sppg_id');
    }
}
