<?php

declare(strict_types=1);

namespace App\Commands\Concerns;

use App\Config;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;

trait AcceptsDateRangeOptions
{
    abstract public function option($key = null);

    protected function getFromOption(): CarbonInterface
    {
        return (new CarbonImmutable($this->option('from'), $this->config()->timezone))
            ->utc();
    }

    protected function getToOption(): CarbonInterface
    {
        if ($this->option('to')) {
            return (new CarbonImmutable($this->option('to'), $this->config()->timezone))
                ->utc();
        }

        if ($this->option('interval')) {
            return $this->getFromOption()
                ->add(CarbonInterval::fromString($this->option('interval')))
                ->utc();
        }

        return CarbonImmutable::now();
    }

    private function config(): Config
    {
        return app(Config::class);
    }
}
