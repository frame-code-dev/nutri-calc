<?php

namespace App\Models\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            static::logActivity($model, 'created');
        });

        static::updated(function (Model $model) {
            if ($model->isDirty()) {
                static::logActivity($model, 'updated');
            }
        });

        static::deleted(function (Model $model) {
            static::logActivity($model, 'deleted');
        });
    }

    protected static function logActivity(Model $model, string $action)
    {
        if (!app()->runningInConsole() && Auth::check()) {
            
            $changes = null;
            if ($action === 'updated') {
                $changes = [
                    'old' => Arr::except($model->getOriginal(), ['updated_at']),
                    'new' => Arr::except($model->getAttributes(), ['updated_at']),
                ];
            } elseif ($action === 'created') {
                $changes = ['attributes' => $model->getAttributes()];
            }

            $modelName = class_basename(get_class($model));
            $description = "{$modelName} {$action} by " . Auth::user()->name;

            $sppgId = null;
            if (\Illuminate\Support\Facades\Schema::hasColumn($model->getTable(), 'sppg_id')) {
                $sppgId = $model->sppg_id;
            } elseif (Auth::check() && Auth::user()->sppg_id) {
                $sppgId = Auth::user()->sppg_id;
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'sppg_id' => $sppgId,
                'model_type' => get_class($model),
                'model_id' => $model->getKey(),
                'action' => $action,
                'description' => $description,
                'changes' => $changes,
                'ip_address' => Request::ip()
            ]);
        }
    }
}
