<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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
     * Standard boot function for defining proper action handling.
     *
     * @return void
     */
    public static function boot() : void
    {
        parent::boot();

        static::creating(function (User $user) {
            $user->uuid = Str::uuid();
        });
    }

    /**
     * Get the logs for the user.
     *
     * @return HasMany
     */
    public function logs() : HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get latest log for the user.
     *
     * @return HasMany
     */
    public function log() : HasOne
    {
        return $this->hasOne(Log::class)->latestOfMany();
    }

    /**
     * Get the permissions for the user.
     *
     * @return HasMany
     */
    public function userPermissions() : HasMany
    {
        return $this->hasMany(UserPermission::class);
    }

    /**
     * Get the files for the user.
     *
     * @return HasMany
     */
    public function files() : HasMany
    {
        return $this->hasMany(File::class);
    }
}
