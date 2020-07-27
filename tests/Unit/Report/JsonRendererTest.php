<?php

declare(strict_types=1);

namespace Tests\Unit\Report;

use App\Facades\Settings;
use App\Frame;
use App\Project;
use App\Report;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCase;

class JsonRendererTest extends TestCase
{
    public function testRender()
    {
        Settings::set('timezone', 'America/New_York');

        $project = factory(Project::class)->create(['name' => 'blog']);

        factory(Frame::class)->create([
            'project_id' => $project->id,
            'notes' => 'Starting work on the new theme',
            'started_at' => Date::parse('2019-05-04 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-04 12:30 PM', 'America/New_York')->utc(),
        ]);

        factory(Frame::class)->create([
            'project_id' => $project->id,
            'notes' => 'Adding the mailing list signup component',
            'started_at' => Date::parse('2019-05-05 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-05 1:30 PM', 'America/New_York')->utc(),
        ]);

        $output = new BufferedOutput();

        Report::build()
            ->from(Date::create(2019, 05, 03))
            ->to(Date::create(2019, 05, 05))
            ->create()
            ->render($output, 'json');

        $expected = [
            'date_range' => [
                'from' => 'May 2, 2019 8:00 pm',
                'to' => 'May 4, 2019 8:00 pm',
            ],
            'total' => '2:00',
            'frames' => [
                [
                    'project' => 'blog',
                    'tags' => '',
                    'notes' => 'Starting work on the new theme',
                    'date' => 'May 4, 2019',
                    'start' => '12:00 pm',
                    'end' => '12:30 pm',
                    'elapsed' => '0:30',
                ],
                [
                    'project' => 'blog',
                    'tags' => '',
                    'notes' => 'Adding the mailing list signup component',
                    'date' => 'May 5, 2019',
                    'start' => '12:00 pm',
                    'end' => '1:30 pm',
                    'elapsed' => '1:30',
                ],
            ],
        ];

        $this->assertSame($expected, json_decode($output->fetch(), true));
    }
}
