<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Frame;
use App\Config;
use App\Project;
use Tests\TestCase;
use Illuminate\Support\Facades\Date;

class ReportCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app->instance(Config::class, new Config('F j, Y', 'g:i a', '%h:%I', 'America/New_York'));
    }

    public function testReport()
    {
        $project = factory(Project::class)->create();

        // not within the date range
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-03 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-03 12:30 PM', 'America/New_York')->utc(),
        ]);

        // 30 elapsed
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-04 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-04 12:30 PM', 'America/New_York')->utc(),
        ]);

        // 1:30 elapsed
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-05 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-05 1:30 PM', 'America/New_York')->utc(),
        ]);

        // 1:30 elapsed
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-05 2:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-05 3:30 PM', 'America/New_York')->utc(),
        ]);

        $this
            ->artisan("report --project {$project->name} --from '2019-05-04' --to '2019-05-30'")
            ->assertExitCode(0)
            ->expectsOutput('May 4, 2019 to May 30, 2019')
            ->expectsOutput('| May 4, 2019 | 12:00 pm | 12:30 pm | 0:30    |')
            ->expectsOutput('| May 5, 2019 | 12:00 pm | 1:30 pm  | 1:30    |')
            ->expectsOutput('| May 5, 2019 | 2:00 pm  | 3:30 pm  | 1:30    |')
            ->expectsOutput('Total hours: 3:30');
    }
}
