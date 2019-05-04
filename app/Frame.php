<?php

declare(strict_types=1);

namespace App;

use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;

/**
 * @property int                  $id
 * @property CarbonInterface      $started_at
 * @property CarbonInterface|null $stopped_at
 * @property int                  $project_id
 * @property-read CarbonInterval  $elapsed
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property string|null          $deleted_at
 * @property-read \App\Project    $project
 * @method static Builder active()
 * @method static Builder between(CarbonInterface $start, CarbonInterface $end)
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

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->whereNull('stopped_at')
            ->orderByDesc('started_at');
    }

    public function scopeBetween(Builder $query, CarbonInterface $start, CarbonInterface $end): Builder
    {
        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $query
            ->whereDate('started_at', '>=', $start)
            ->whereDate('stopped_at', '<=', $end)
            ->whereNotNull('stopped_at');
    }

    /**
     * @param Project|string       $project
     * @param CarbonInterface|null $startedAt
     *
     * @return Frame
     */
    public static function start($project, ?CarbonInterface $startedAt = null): Frame
    {
        if (!$project instanceof Project) {
            $project = Project::firstOrCreate([
                'name' => $project,
            ]);
        }

        return $project->frames()->create([
            'started_at' => $startedAt ?? Date::now(),
        ]);
    }

    public function stop(CarbonInterface $stoppedAt = null): bool
    {
        $this->stopped_at = $stoppedAt ?? Date::now();

        return $this->save();
    }

    /**
     * @param Project|string       $project
     * @param CarbonInterface      $startedAt
     * @param CarbonInterface|null $stoppedAt
     *
     * @return Frame
     */
    public static function add($project, CarbonInterface $startedAt, CarbonInterface $stoppedAt = null): Frame
    {
        return tap(static::start($project, $startedAt), function (Frame $frame) use ($stoppedAt) {
            $frame->stop($stoppedAt);
        });
    }

    public function getElapsedAttribute(): CarbonInterval
    {
        return $this->started_at->diffAsCarbonInterval($this->stopped_at);
    }
}
