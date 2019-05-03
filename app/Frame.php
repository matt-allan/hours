<?php

declare(strict_types=1);

namespace App;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property \Carbon\CarbonImmutable $started_at
 * @property \Carbon\CarbonImmutable|null $stopped_at
 * @property int $project_id
 * @property-read \Carbon\CarbonInterval $elapsed
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Project $project
 */
class Frame extends Model
{
    protected $fillable = [
        'started_at',
        'stopped_at',
        'project_id',
    ];

    protected $dates = [
        'started_at',
        'stopped_at',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public static function active(): ?self
    {
        return static::query()
            ->whereNull('stopped_at')
            ->orderByDesc('started_at')
            ->first();
    }

    public function stop(CarbonImmutable $stoppedAt = null): bool
    {
        $this->stopped_at = $stoppedAt ?? CarbonImmutable::now();

        return $this->save();
    }

    public function getElapsedAttribute(): CarbonInterval
    {
        return $this->started_at->diffAsCarbonInterval($this->stopped_at);
    }
}
