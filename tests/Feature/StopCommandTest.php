<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\CarbonImmutable;

class StopCommandTest extends TestCase
{
    public function testStop()
    {
        CarbonImmutable::setTestNow($now = CarbonImmutable::now());

        $this->artisan('start blog');

        CarbonImmutable::setTestNow($now->addMinutes(5));

        $this->artisan('stop')
            ->expectsOutput('Time tracking for blog stopped (started 5 minutes ago).')
            ->assertExitCode(0);
    }
}
