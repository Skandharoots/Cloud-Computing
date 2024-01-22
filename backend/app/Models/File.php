<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'filename',
        'size',
        'version',
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

        static::creating(function (File $file) {
            $file->uuid = Str::uuid();
        });
    }

    /**
     * Get the user that owns the file.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
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
