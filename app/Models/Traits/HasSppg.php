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
            // Gunakan hasUser() untuk mencegah infinite loop saat mengambil User session
            if (Auth::hasUser()) {
                $user = Auth::user();
                // Jika bukan Super Admin, filter data berdasarkan MBG
                // Data dengan sppg_id NULL dianggap sebagai data Global yang bisa diakses semua
                if ($user && !$user->hasRole('Super Admin') && $user->sppg_id) {
                    $builder->where(function ($query) use ($user, $builder) {
                        $table = $builder->getModel()->getTable();
                        $query->where($table . '.sppg_id', $user->sppg_id)
                              ->orWhereNull($table . '.sppg_id');
                    });
                }
            }
        });

        // Hook creating untuk auto-assign SPPG
        static::creating(function ($model) {
            if (Auth::hasUser()) {
                $user = Auth::user();
                if ($user && !$user->hasRole('Super Admin')) {
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
