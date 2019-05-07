<?php

declare(strict_types=1);

namespace Tests\Unit\Report;

use App\Frame;
use App\Report;
use App\Project;
use Tests\TestCase;
use App\Facades\Settings;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Console\Output\BufferedOutput;

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
                    'Project' => 'blog',
                    'Tags' => '',
                    'Notes' => 'Starting work on the new theme',
                    'Date' => 'May 4, 2019',
                    'Start' => '12:00 pm',
                    'End' => '12:30 pm',
                    'Elapsed' => '0:30',
                ],
                [
                    'Project' => 'blog',
                    'Tags' => '',
                    'Notes' => 'Adding the mailing list signup component',
                    'Date' => 'May 5, 2019',
                    'Start' => '12:00 pm',
                    'End' => '1:30 pm',
                    'Elapsed' => '1:30',
                ],
            ],
        ];

        $this->assertSame($expected, json_decode($output->fetch(), true));
    }
}
