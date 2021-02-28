<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Application
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @mixin \Eloquent
 */
class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the user associated with the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
