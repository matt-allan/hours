<?php

declare(strict_types=1);

namespace Tests\Report;

use App\Config;
use App\Frame;
use App\Project;
use App\Report;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCase;

class JsonRendererTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app->instance(Config::class, new Config('F j, Y', 'g:i a', '%h:%I', 'America/New_York'));
    }

    public function testRender()
    {
        $project = factory(Project::class)->create(['name' => 'blog']);

        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-04 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-04 12:30 PM', 'America/New_York')->utc(),
        ]);

        factory(Frame::class)->create([
            'project_id' => $project->id,
            'started_at' => Date::parse('2019-05-05 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-05 1:30 PM', 'America/New_York')->utc(),
        ]);

        $output = new BufferedOutput();

        Report::create(Date::create(2019, 05, 03), Date::create(2019, 05, 05))
            ->render($output, 'json');

        $expected = [
            "date_range" => [
                "from" => "May 2, 2019 8:00 pm",
                "to" => "May 4, 2019 8:00 pm",
            ],
            "total" => "2:00",
            "frames" => [
                [
                    "Project" => "blog",
                    "Date" => "May 4, 2019",
                    "Start" => "12:00 pm",
                    "End" => "12:30 pm",
                    "Elapsed" => "0:30",
                ],
                [
                    "Project" => "blog",
                    "Date" => "May 5, 2019",
                    "Start" => "12:00 pm",
                    "End" => "1:30 pm",
                    "Elapsed" => "1:30",
                ],
            ],
        ];

        $this->assertSame($expected, json_decode($output->fetch(), true));
    }
}
