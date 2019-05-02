<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Config;
use Tests\TestCase;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StartCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testStart()
    {
        CarbonImmutable::setTestNow($now = CarbonImmutable::now());

        $this->artisan('start blog')
            ->expectsOutput('Starting blog at '.$now->presentTime())
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
            ->expectsOutput('Starting blog at '.$now->addSeconds(5)->presentTime())
            ->assertExitCode(0);
    }
}
