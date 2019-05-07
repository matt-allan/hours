<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Date;

class CancelCommandTest extends TestCase
{
    public function testCancel()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog');

        Date::setTestNow($now->addMinutes(5));

        $this->artisan('cancel')
            ->expectsOutput('Time tracking for blog cancelled (started 5 minutes ago).')
            ->assertExitCode(0);
    }
}
