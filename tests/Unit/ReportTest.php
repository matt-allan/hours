<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Frame;
use App\Project;
use App\Report;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class ReportTest extends TestCase
{
    public function testTotal()
    {
        $project = factory(Project::class)->create(['name' => 'blog']);

        // 8:00
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-03 9:00 AM'),
            'stopped_at' => Date::parse('2019-05-03 5:00 PM'),
        ]);

        // 8:00
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-04 9:00 AM'),
            'stopped_at' => Date::parse('2019-05-04 5:00 PM'),
        ]);

        // 8:15
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-05 9:00 AM'),
            'stopped_at' => Date::parse('2019-05-05 5:15 PM'),
        ]);

        // 00:15
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-06 9:00 AM'),
            'stopped_at' => Date::parse('2019-05-06 9:15 AM'),
        ]);

        // 00:30
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-06 9:15 AM'),
            'stopped_at' => Date::parse('2019-05-06 9:45 AM'),
        ]);

        // 00:45
        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-06 9:45 AM'),
            'stopped_at' => Date::parse('2019-05-06 10:30 AM'),
        ]);

        $report = Report::build()
            ->from(Date::create(2019, 05, 01))
            ->to(Date::create(2019, 05, 31))
            ->create();

        $this->assertSame('25:45', $report->total()->presentInterval());
    }
}
