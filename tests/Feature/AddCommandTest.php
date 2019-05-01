<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\CarbonImmutable;
use Tests\TestCase;

class AddCommandTest extends TestCase
{
    public function testAdd()
    {
        $this->artisan('add blog --from \'2019-05-01 22:34:46\' --to \'2019-05-01 23:34:46\'')
            ->expectsOutput('Added frame for blog from 2019-05-01 22:34:46 to 2019-05-01 23:34:46 (1 hour).')
            ->assertExitCode(0);
    }

    public function testAddWithFromDiff()
    {
        CarbonImmutable::setTestNow($now = CarbonImmutable::now());

        $this->artisan('add blog --from \'2 hours ago\'')
            ->expectsOutput("Added frame for blog from {$now->subHours(2)} to {$now} (2 hours).")
            ->assertExitCode(0);
    }

    public function testAddWithInterval()
    {
        $this->artisan('add blog --from \'2019-05-01 22:34:46\' --interval \'2h 12m 6s\'')
            ->expectsOutput('Added frame for blog from 2019-05-01 22:34:46 to 2019-05-02 00:46:52 (2 hours).')
            ->assertExitCode(0);
    }
}
