<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Config;
use Tests\TestCase;
use Carbon\CarbonImmutable;

class AddCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app->instance(Config::class, new Config('F j, Y', 'g:i a', 'America/New_York'));
    }

    public function testAdd()
    {
        $this->artisan('add blog --from \'2019-05-01 05:34:46\' --to \'2019-05-01 06:34:46\'')
            ->expectsOutput('Added frame for blog from May 1, 2019 5:34 am to May 1, 2019 6:34 am (1 hour).')
            ->assertExitCode(0);
    }

    public function testAddWithFromDiff()
    {
        CarbonImmutable::setTestNow(
            (new CarbonImmutable('2019-05-01 05:34:46', 'America/New_York'))->setTimezone('UTC')
        );

        $this->artisan('add blog --from \'2 hours ago\'')
            ->expectsOutput('Added frame for blog from May 1, 2019 3:34 am to May 1, 2019 5:34 am (2 hours).')
            ->assertExitCode(0);
    }

    public function testAddWithInterval()
    {
        $this->artisan('add blog --from \'2019-05-01 05:34:46\' --interval \'2h 12m 6s\'')
            ->expectsOutput('Added frame for blog from May 1, 2019 5:34 am to May 1, 2019 7:46 am (2 hours).')
            ->assertExitCode(0);
    }
}
