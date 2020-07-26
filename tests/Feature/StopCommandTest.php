<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class StopCommandTest extends TestCase
{
    public function testStop()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog');

        Date::setTestNow($now->addMinutes(5));

        $this->artisan('stop')
            ->expectsOutput('Time tracking for blog stopped (started 5 minutes ago).')
            ->assertExitCode(0);
    }

    public function testStopAt()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog');

        Date::setTestNow($now->addHour());

        $this->artisan("stop --at '15 minutes ago'")
            ->expectsOutput('Time tracking for blog stopped (started 45 minutes ago).')
            ->assertExitCode(0);
    }
}
