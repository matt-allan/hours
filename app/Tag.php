<?php

declare(strict_types=1);

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Tag.
 *
 * @property int $id
 * @property string $name
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection|Frame[] $frames
 */
class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function frames(): BelongsToMany
    {
        return $this->belongsToMany(Frame::class);
    }
}
