<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolDistribution extends Model
{
    protected $fillable = [
        'school_id',
        'kloter_id',
        'distribution_unit_id',
        'name',
        'small_portion_count',
        'large_portion_count',
        'teacher_count',
        'is_active'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function kloter()
    {
        return $this->belongsTo(Kloter::class);
    }

    public function unit()
    {
        return $this->belongsTo(DistributionUnit::class, 'distribution_unit_id');
    }
}
