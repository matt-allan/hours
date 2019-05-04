<?php

declare(strict_types=1);

namespace App\Carbon;

use App\Facades\Config;
use Carbon\CarbonInterval;

/**
 * @mixin CarbonInterval
 */
class CarbonIntervalPresentMixin
{
    public function presentInterval(): \Closure
    {
        return function (): string {
            return $this
                ->cascade()
                ->format(Config::get('interval_format', '%h:%I'));
        };
    }
}
