<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sppg_id',
        'nama',
        'jabatan',
        'tipe',
        'nomor_urut',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function sppg()
    {
        return $this->belongsTo(MasterSppg::class, 'sppg_id');
    }

    public function salaryDetails()
    {
        return $this->hasMany(SalaryDetail::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeTetap($query)
    {
        return $query->where('tipe', 'tetap');
    }

    public function scopeMagang($query)
    {
        return $query->where('tipe', 'magang');
    }
}
