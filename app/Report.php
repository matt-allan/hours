<?php

declare(strict_types=1);

namespace App;

use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Report
{
    /**
     * @var Frame[]|Collection
     */
    private $frames;

    /**
     * @var string[]
     */
    private $projects;

    /**
     * @param Collection|Frame[] $frames
     * @param string[]           $projects
     */
    public function __construct(Collection $frames, array $projects = [])
    {
        $this->frames = $frames;
        $this->projects = $projects;
    }

    public static function create(CarbonInterface $start, CarbonInterface $end, array $projects = []): self
    {
        $frames = Frame::between($start, $end)
            ->when($projects, function (Builder $query, array $projects): Builder {
                return $query
                    ->whereHas('project', function (Builder $query) use ($projects): Builder {
                        return $query->whereIn('name', $projects);
                    });
            })
            ->get();

        return new self($frames, $projects);
    }

    public function headers(): Collection
    {
        return collect(['Project', 'Date', 'Start', 'End', 'Elapsed'])
            ->unless($this->multipleProjects(), function (Collection $headers) {
                return $headers->slice(1);
            });
    }

    public function data(): Collection
    {
        return $this->frames->map(function (Frame $frame) {
            return collect([
               $frame->project->name,
               $frame->started_at->presentDate(),
               $frame->started_at->presentTime(),
               $frame->stopped_at->presentTime(),
               $frame->elapsed->presentInterval(),
           ]);
        })->unless($this->multipleProjects(), function (Collection $frames) {
            return $frames
               ->map(function (Collection $frame) {
                   return $frame->slice(1);
               });
        });
    }

    public function total(): CarbonInterval
    {
        return $this->frames
            ->pluck('elapsed')
            ->reduce(function (CarbonInterval $carry, CarbonInterval $item): CarbonInterval {
                return $item->add($carry);
            }, new CarbonInterval(null));
    }

    private function multipleProjects(): bool
    {
        return count($this->projects) !== 1;
    }
}
