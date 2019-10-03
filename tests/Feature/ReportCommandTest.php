<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Frame;
use App\Project;
use Tests\TestCase;
use App\Facades\Settings;
use Illuminate\Support\Facades\Date;

class ReportCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Settings::set('timezone', 'America/New_York');
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
            ->expectsOutput('Total hours: 3:30');
    }

    public function testReportWithProjectFilter()
    {
        $project = factory(Project::class)->create(['name' => 'blog']);

        // not within the date range
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => date::parse('2019-05-03 12:00 pm', 'america/new_york')->utc(),
            'stopped_at' => date::parse('2019-05-03 12:30 pm', 'america/new_york')->utc(),
        ]);

        // other project
        factory(Frame::class)->create([
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
            ->expectsOutput('Total hours: 0:30');
    }

    public function testReportWithTagFilter()
    {
        $project = factory(Project::class)->create(['name' => 'blog']);

        // not within the date range
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => date::parse('2019-05-03 12:00 pm', 'america/new_york')->utc(),
            'stopped_at' => date::parse('2019-05-03 12:30 pm', 'america/new_york')->utc(),
        ]);

        // other tag
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => date::parse('2019-05-04 12:00 pm', 'america/new_york')->utc(),
            'stopped_at' => date::parse('2019-05-04 12:30 pm', 'america/new_york')->utc(),
        ])->addTags('editing');

        // 30 elapsed
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-04 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-04 12:30 PM', 'America/New_York')->utc(),
        ])->addTags('writing');

        $this
            ->artisan("report --project blog --tag writing --from '2019-05-04' --to '2019-05-30'")
            ->assertExitCode(0)
            ->expectsOutput('May 4, 2019 to May 30, 2019')
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

    public function testReportWithOpenFrames()
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


        Date::setTestNow(
            Date::create(2019, 5, 5, 15, 30, 0, 'America/New_York')->utc()
        );
        // 1:30 elapsed open frame
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-05 2:00 PM', 'America/New_York')->utc(),
            'stopped_at' => null,
        ]);

        $this
            ->artisan("report --from '2019-05-04' --to '2019-05-30' --with-open-frames")
            ->assertExitCode(0)
            ->expectsOutput('May 4, 2019 to May 30, 2019')
            ->expectsOutput('Total hours: 3:30');
   }
}
