<?php

declare(strict_types=1);

namespace App\Carbon;

use App\Facades\Config;
use Carbon\CarbonImmutable;

/**
 * @mixin CarbonImmutable
 */
class CarbonPresentMixin
{
    public function presentDate(): \Closure
    {
        return function (): string {
            return $this
                ->setTimezone(Config::get('timezone', 'UTC'))
                ->format(Config::get('date_format', 'F j, Y'));
        };
    }

    public function presentTime(): \Closure
    {
        return function (): string {
            return $this
                ->setTimezone(Config::get('timezone', 'UTC'))
                ->format(Config::get('time_format', 'g:i a'));
        };
    }

    public function presentDateTime(): \Closure
    {
        return function (): string {
            return $this
                ->setTimezone(Config::get('timezone', 'UTC'))
                ->format(Config::get('date_format', 'F j, Y').' '.Config::get('time_format', 'g:i a'));
        };
    }
}
