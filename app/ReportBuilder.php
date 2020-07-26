<?php

declare(strict_types=1);

namespace App;

use App\Facades\Settings;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

class ReportBuilder
{
    /**
     * @var CarbonInterface
     */
    private $from;

    /**
     * @var CarbonInterface
     */
    private $to;

    /**
     * @var string[]
     */
    private $projects = [];

    /**
     * @var string[]
     */
    private $tags = [];

    /**
     * @var bool
     */
    private $withOpenFrames = false;

    public function __construct()
    {
        $this->from = Date::now(Settings::get('timezone'))->firstOfMonth()->utc();
        $this->to = Date::now(Settings::get('timezone'))->utc();
    }

    public function from(?CarbonInterface $from): self
    {
        if ($from) {
            $this->from = $from;
        }

        return $this;
    }

    public function to(?CarbonInterface $to): self
    {
        if ($to) {
            $this->to = $to;
        }

        return $this;
    }

    /**
     * @param  string|string[] $projects
     * @return self
     */
    public function projects($projects): self
    {
        $this->projects = Arr::wrap($projects);

        return $this;
    }

    /**
     * @param  string|string[] $tags
     * @return self
     */
    public function tags($tags)
    {
        $this->tags = Arr::wrap($tags);

        return $this;
    }

    /**
     * @param bool $withOpenFrames
     *
     * @return $this
     */
    public function withOpenFrames($withOpenFrames = true): self
    {
        $this->withOpenFrames = $withOpenFrames;

        return $this;
    }

    public function create(): Report
    {
        return new Report(
            $this->getFrames(),
            $this->from,
            $this->to,
            $this->projects,
            $this->tags
        );
    }

    /**
     * @return Collection|Frame[]
     */
    private function getFrames(): Collection
    {
        return Frame::query()
            ->where(function (Builder $query) {
                return $query->where(function (Builder $query) {
                    return $query->between($this->from, $this->to);
                })->when($this->withOpenFrames, function (Builder $query) {
                    return $query->orWhere(function (Builder $query) {
                        return $query->activeBetween($this->from, $this->to);
                    });
                });
            })
            ->when($this->projects, function (Builder $query, array $projects): Builder {
                return $query->forProject($projects);
            })
            ->when($this->tags, function (Builder $query, array $tags): Builder {
                return $query->forTag($tags);
            })
            ->get();
    }
}
