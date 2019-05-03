<?php

declare(strict_types=1);

namespace App\Carbon;

use App\Config;
use Carbon\CarbonInterval;

/**
 * @mixin CarbonInterval
 */
class CarbonIntervalPresentMixin
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

    public function presentInterval(): \Closure
    {
        $config = $this->config;

        return function () use ($config) {
            return $this
                ->cascade()
                ->format($config->intervalFormat);
        };
    }
}
