<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Log extends Model
{
    use HasFactory;

    /**
     * Log types
     *
     * Naming: ENTITY_ACTION
     *
     * Grouped by entities
     */
    const USER_LOGIN = 1;
    const USER_LOGOUT = 2;
    const USER_REGISTER = 3;
    const USER_UPDATE_PROFILE = 4;

    const USER_AZURE_READ = 5;
    const USER_AZURE_UPLOAD = 6;
    const USER_AZURE_UPDATE = 7;
    const USER_AZURE_DELETE = 8;
    const USER_AZURE_DOWNLOAD = 9;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'description',
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
     * Get the name of the log.
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

        return 'L01 Unknown Log Type - ' . $this->type;
    }

    /**
     * Get the log type min constant value. Just for validation in tests.
     *
     * @return int
     */
    public static function getLogTypeMin() : int
    {
        return 1;
    }

    /**
     * Get the log type max constant value. Just for validation in tests.
     *
     * @return int
     */
    public static function getLogTypeMax() : int
    {
        return 9;
    }

    /**
     * Get the log types.
     *
     * @return array<int, int>
     */
    public static function getLogTypes() : array
    {
        return [
            self::USER_LOGIN,
            self::USER_LOGOUT,
            self::USER_REGISTER,
            self::USER_UPDATE_PROFILE,
            self::USER_AZURE_READ,
            self::USER_AZURE_UPLOAD,
            self::USER_AZURE_UPDATE,
            self::USER_AZURE_DELETE,
            self::USER_AZURE_DOWNLOAD,
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

        static::creating(function (Log $log) {
            $log->uuid = Str::uuid();

            if ($log->type == self::USER_LOGIN) {
                $log->description = 'User logged in.';
            } elseif ($log->type == self::USER_LOGOUT) {
                $log->description = 'User logged out.';
            } elseif ($log->type == self::USER_REGISTER) {
                $log->description = 'User registered.';
            } elseif ($log->type == self::USER_UPDATE_PROFILE) {
                $log->description = 'User updated profile.';
            }
        });
    }

    /**
     * Get the user that owns the log.
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
