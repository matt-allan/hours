<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Tests\WithoutConfig;
use Illuminate\Support\Facades\Date;

class StopCommandTest extends TestCase
{
    use WithoutConfig;

    public function testStop()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog');

        Date::setTestNow($now->addMinutes(5));

        $this->artisan('stop')
            ->expectsOutput('Time tracking for blog stopped (started 5 minutes ago).')
            ->assertExitCode(0);
    }
}
