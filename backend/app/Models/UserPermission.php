<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserPermission extends Model
{
    use HasFactory;

    /**
     * Permission types
     *
     * Naming: ACTION
     *
     */
    const AZURE_READ = 1;
    const AZURE_UPDATE = 2;
    const AZURE_UPLOAD = 3;
    const AZURE_DELETE = 4;
    const AZURE_DOWNLOAD = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'user_id',
    ];

    /**
     * Get the route key.
     *
     * @return string
     */
    public function getRouteKeyName() : string
    {
        return 'uuid';
    }

    /**
     * Get the name of the permission.
     *
     * @return string
     */
    public function getNameAttribute() : string
    {
        $reflection = new \ReflectionClass($this);
        $constants = $reflection->getConstants();

        foreach ($constants as $key => $value) {
            if ($value === $this->type) {
                return $key;
            }
        }

        return 'L01 Unknown Permission Type - ' . $this->type;
    }

    /**
     * Get the permission type min constant value. Just for validation in tests.
     *
     * @return int
     */
    public static function getPermissionTypeMin() : int
    {
        return 1;
    }

    /**
     * Get the permission type max constant value. Just for validation in tests.
     *
     * @return int
     */
    public static function getPermissionTypeMax() : int
    {
        return 5;
    }

    /**
     * Get the permission type enum.
     *
     * @return array<int, int>
     */
    public static function getPermissionTypes() : array
    {
        return [
            self::AZURE_READ,
            self::AZURE_UPDATE,
            self::AZURE_UPLOAD,
            self::AZURE_DELETE,
            self::AZURE_DOWNLOAD,
        ];
    }

    /**
     * Standard boot function for defining proper action handling.
     *
     * @return void
     */
    public static function boot() : void
    {
        parent::boot();

        static::creating(function (UserPermission $permission) {
            $permission->uuid = Str::uuid();
        });
    }

    /**
     * Get the user that owns the UserPermission.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Logs by User UUID.
     *
     * @param Builder $query
     */
    public function scopeUserUuid($query, $uuid): Builder
    {
        return $query->whereHas('user', function ($query) use ($uuid) {
            $query->where('uuid', $uuid);
        });
    }

}
