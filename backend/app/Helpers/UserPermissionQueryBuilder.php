<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class UserPermissionQueryBuilder extends Builder
{
    public static function hasPermission(Builder $query, int $type): Builder
    {
        return $query->whereHas('userPermissions', function (Builder $query) use ($type) {
            $query->where('type', $type);
        });
    }
}
