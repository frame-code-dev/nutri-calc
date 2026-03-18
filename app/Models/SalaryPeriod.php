<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'sppg_id',
        'nama_periode',
        'tipe',
        'tanggal_mulai',
        'tanggal_selesai',
        'periode_ke',
        'penandatangan_1',
        'penandatangan_2',
        'instansi',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function sppg()
    {
        return $this->belongsTo(MasterSppg::class, 'sppg_id');
    }

    public function details()
    {
        return $this->hasMany(SalaryDetail::class, 'period_id');
    }

    public function getPeriodeRomanAttribute(): string
    {
        $map = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X',
                'XI', 'XII'];
        return $map[$this->periode_ke] ?? $this->periode_ke;
    }
}
