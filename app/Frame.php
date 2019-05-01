<?php

declare(strict_types=1);

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $stopped_at
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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

    public function stop(Carbon $stoppedAt = null): bool
    {
        $this->stopped_at = $stoppedAt ?? Carbon::now();

        return $this->save();
    }

    public function diff(): string
    {
        return $this->started_at->diffForHumans($this->stopped_at, Carbon::DIFF_RELATIVE_TO_NOW);
    }
}
