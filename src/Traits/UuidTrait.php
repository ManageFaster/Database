<?php

namespace Managefaster\Database\Traits;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

trait UuidTrait
{
    use HasUuids {
        newUniqueId as private generateUuid;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->primaryKey} = $model->generateUuid();
        });
    }
}
