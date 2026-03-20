<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait HasSppg
{
    public static function bootHasSppg()
    {
        // Implementasi Global Scope untuk multi-tenant MBG (SPPG)
        static::addGlobalScope('sppg', function (Builder $builder) {
            if (Auth::check()) {
                $user = Auth::user();
                // Jika bukan Super Admin, filter data berdasarkan MBG
                // Data dengan sppg_id NULL dianggap sebagai data Global yang bisa diakses semua
                if (!$user->hasRole('Super Admin') && $user->sppg_id) {
                    $builder->where(function ($query) use ($user) {
                        $query->where('sppg_id', $user->sppg_id)
                              ->orWhereNull('sppg_id');
                    });
                }
            }
        });

        // Hook creating untuk auto-assign SPPG
        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                if (!$user->hasRole('Super Admin')) {
                    if (empty($model->sppg_id)) {
                        $model->sppg_id = $user->sppg_id;
                    }
                }
            }
        });
    }

    public function sppg()
    {
        return $this->belongsTo(\App\Models\MasterSppg::class, 'sppg_id');
    }
}
