<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\CarbonImmutable;

class StatusCommandTest extends TestCase
{
    public function testStatus()
    {
        CarbonImmutable::setTestNow($now = CarbonImmutable::now());

        $this->artisan('start blog');

        CarbonImmutable::setTestNow($now->addMinutes(5));

        $this->artisan('status')
            ->expectsOutput('Time tracking for blog started 5 minutes ago.')
            ->assertExitCode(0);
    }
}
