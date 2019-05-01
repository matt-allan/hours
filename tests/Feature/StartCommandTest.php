<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StartCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testStart()
    {
        CarbonImmutable::setTestNow($now = CarbonImmutable::now());

        $this->artisan('start blog')
            ->expectsOutput('Starting blog at '.(string) $now)
            ->assertExitCode(0);
    }

    public function testStartWhenAlreadyRunning()
    {
        CarbonImmutable::setTestNow($now = CarbonImmutable::now());

        $this->artisan('start blog');

        CarbonImmutable::setTestNow($now->addSeconds(5));

        $this->artisan('start blog')
            ->expectsQuestion(
                'Time is already being tracked for blog (started 5 seconds ago).  '.
                    'Do you want to stop the active frame?',
                'yes'
            )
            ->expectsOutput('Time tracking for blog stopped (started 5 seconds ago).')
            ->expectsOutput('Starting blog at '.(string) $now->addSeconds(5))
            ->assertExitCode(0);
    }
}
