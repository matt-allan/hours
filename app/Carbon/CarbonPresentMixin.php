<?php

declare(strict_types=1);

namespace App\Carbon;

use App\Config;
use Carbon\CarbonImmutable;

/**
 * @mixin CarbonImmutable
 */
class CarbonPresentMixin
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config = null)
    {
        // Can't use proper DI, see https://github.com/briannesbitt/Carbon/issues/1706
        $this->config = $config ?? app(Config::class);
    }

    public function presentDate(): \Closure
    {
        $config = $this->config;

        return function () use ($config) {
            return $this
                ->setTimezone($config->timezone)
                ->format($config->dateFormat);
        };
    }

    public function presentTime(): \Closure
    {
        $config = $this->config;

        return function () use ($config) {
            return $this
                ->setTimezone($config->timezone)
                ->format($config->timeFormat);
        };
    }

    public function presentDateTime(): \Closure
    {
        $config = $this->config;

        return function () use ($config) {
            return $this
                ->setTimezone($config->timezone)
                ->format($config->dateFormat.' '.$config->timeFormat);
        };
    }
}
