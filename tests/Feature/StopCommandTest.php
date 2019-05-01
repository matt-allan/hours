<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Tests\TestCase;

class StopCommandTest extends TestCase
{
    public function testStop()
    {
        Carbon::setTestNow($now = Carbon::now());

        $this->artisan('start blog');

        Carbon::setTestNow($now->addMinutes(5));

        $this->artisan('stop')
            ->expectsOutput('Time tracking for blog stopped (started 5 minutes ago).')
            ->assertExitCode(0);
    }
}
