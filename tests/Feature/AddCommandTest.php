<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Facades\Settings;
use Illuminate\Support\Facades\Date;

class AddCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testAdd()
    {
        $this
            ->artisan('add blog --from \'2019-05-01 05:34:46\' --to \'2019-05-01 06:34:46\'')
            ->expectsOutput('Added frame for blog from May 1, 2019 5:34 am to May 1, 2019 6:34 am (1 hour).')
            ->assertExitCode(0);
    }

    public function testAddWithFromDiff()
    {
        Date::setTestNow(
            Date::parse('2019-05-01 05:34:46', 'America/New_York')->setTimezone('UTC')
        );

        Settings::set('timezone', 'America/New_York');

        $this
            ->artisan('add blog --from \'2 hours ago\'')
            ->expectsOutput('Added frame for blog from May 1, 2019 3:34 am to May 1, 2019 5:34 am (2 hours).')
            ->assertExitCode(0);
    }

    public function testAddWithInterval()
    {
        $this
            ->artisan('add blog --from \'2019-05-01 05:34:46\' --interval \'2h 12m 6s\'')
            ->expectsOutput('Added frame for blog from May 1, 2019 5:34 am to May 1, 2019 7:46 am (2 hours 12 minutes 6 seconds).')
            ->assertExitCode(0);
    }

    public function testAddWithTags()
    {
        $this->artisan('add blog --from \'2019-05-01 05:34:46\' --to \'2019-05-01 06:34:46\' --tag writing --tag editing')
            ->expectsOutput('Added frame for blog (writing, editing) from May 1, 2019 5:34 am to May 1, 2019 6:34 am (1 hour).')
            ->assertExitCode(0);
    }

    public function testAddUsesTodayWhenOnlyProvidinggTime()
    {
        Date::setTestNow(
            Date::parse('2019-05-01 14:00:00', 'America/New_York')->setTimezone('UTC')
        );

        $this
            ->artisan('add blog --from \'11:00 am\' --to \'1:00 pm\'')
            ->expectsOutput('Added frame for blog from May 1, 2019 11:00 am to May 1, 2019 1:00 pm (2 hours).')
            ->assertExitCode(0);
    }
}
