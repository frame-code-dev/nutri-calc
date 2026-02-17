<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterSppg extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instagram',
        'tiktok',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'sppg_id');
    }
}
