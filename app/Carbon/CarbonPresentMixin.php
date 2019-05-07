<?php

declare(strict_types=1);

namespace App\Carbon;

use App\Facades\Settings;
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
                ->setTimezone(Settings::get('timezone', 'UTC'))
                ->format(Settings::get('date_format', 'F j, Y'));
        };
    }

    public function presentTime(): \Closure
    {
        return function (): string {
            return $this
                ->setTimezone(Settings::get('timezone', 'UTC'))
                ->format(Settings::get('time_format', 'g:i a'));
        };
    }

    public function presentDateTime(): \Closure
    {
        return function (): string {
            return $this
                ->setTimezone(Settings::get('timezone', 'UTC'))
                ->format(Settings::get('date_format', 'F j, Y').' '.Settings::get('time_format', 'g:i a'));
        };
    }
}
