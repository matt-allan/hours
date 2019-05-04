<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Date;

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
