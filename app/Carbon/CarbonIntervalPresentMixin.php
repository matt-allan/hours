<?php

declare(strict_types=1);

namespace App\Carbon;

use App\Facades\Settings;
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
                ->format(Settings::get('interval_format', '%h:%I'));
        };
    }
}
