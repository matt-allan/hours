<?php

declare(strict_types=1);

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Builder;

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

    public function __construct()
    {
        $this->from = Date::now($this->config()->timezone)->firstOfMonth()->utc();
        $this->to = Date::now($this->config()->timezone)->utc();
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

    public function projects($projects): self
    {
        $this->projects = Arr::wrap($projects);

        return $this;
    }

    public function create(): Report
    {
        return new Report(
            $this->getFrames(),
            $this->from,
            $this->to,
            $this->projects
        );
    }

    private function getFrames(): Collection
    {
        return Frame::between($this->from, $this->to)
            ->when($this->projects, function (Builder $query, array $projects): Builder {
                return $query
                    ->whereHas('project', function (Builder $query) use ($projects): Builder {
                        return $query->whereIn('name', $projects);
                    });
            })
            ->get();
    }

    private function config(): Config
    {
        return app(Config::class);
    }
}
