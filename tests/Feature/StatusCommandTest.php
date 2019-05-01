<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Tests\TestCase;

class StatusCommandTest extends TestCase
{
    public function testStatus()
    {
        Carbon::setTestNow($now = Carbon::now());

        $this->artisan('start blog');

        Carbon::setTestNow($now->addMinutes(5));

        $this->artisan('status')
            ->expectsOutput('Time tracking for blog started 5 minutes ago.')
            ->assertExitCode(0);
    }
}
