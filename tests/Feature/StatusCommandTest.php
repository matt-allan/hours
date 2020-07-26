<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class StatusCommandTest extends TestCase
{
    public function testStatus()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog');

        Date::setTestNow($now->addMinutes(5));

        $this->artisan('status')
            ->expectsOutput('Time tracking for blog started 5 minutes ago.')
            ->assertExitCode(0);
    }
}
