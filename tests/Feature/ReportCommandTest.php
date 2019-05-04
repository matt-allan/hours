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
        $project = factory(Project::class)->create(['name' => 'blog']);

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
            ->artisan("report --from '2019-05-04' --to '2019-05-30'")
            ->assertExitCode(0)
            ->expectsOutput('May 4, 2019 to May 30, 2019')
            ->expectsOutput('| Project | Date        | Start    | End      | Elapsed |')
            ->expectsOutput('| blog    | May 4, 2019 | 12:00 pm | 12:30 pm | 0:30    |')
            ->expectsOutput('| blog    | May 5, 2019 | 12:00 pm | 1:30 pm  | 1:30    |')
            ->expectsOutput('| blog    | May 5, 2019 | 2:00 pm  | 3:30 pm  | 1:30    |')
            ->expectsOutput('Total hours: 3:30');
    }

    public function testReportWithProjectFilter()
    {
        $project = factory(project::class)->create(['name' => 'blog']);

        // not within the date range
        factory(frame::class)->create([
            'project_id' => $project->id,
            'started_at' => date::parse('2019-05-03 12:00 pm', 'america/new_york')->utc(),
            'stopped_at' => date::parse('2019-05-03 12:30 pm', 'america/new_york')->utc(),
        ]);

        // other project
        factory(frame::class)->create([
            'started_at' => date::parse('2019-05-04 12:00 pm', 'america/new_york')->utc(),
            'stopped_at' => date::parse('2019-05-04 12:30 pm', 'america/new_york')->utc(),
        ]);

        // 30 elapsed
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-04 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-04 12:30 PM', 'America/New_York')->utc(),
        ]);

        $this
            ->artisan("report --project blog --from '2019-05-04' --to '2019-05-30'")
            ->assertExitCode(0)
            ->expectsOutput('May 4, 2019 to May 30, 2019')
            ->expectsOutput('| Date        | Start    | End      | Elapsed |')
            ->expectsOutput('| May 4, 2019 | 12:00 pm | 12:30 pm | 0:30    |')
            ->expectsOutput('Total hours: 0:30');
    }

    public function testReportDefaultsToCurrentMonth()
    {
        Date::setTestNow(
            Date::create(2019, 1, 15, 0, 0, 0, 'America/New_York')->utc()
        );

        $this
            ->artisan('report')
            ->assertExitCode(0)
            ->expectsOutput('January 1, 2019 to January 15, 2019');
    }
}
