<?php

declare(strict_types=1);

namespace Tests\Unit\Report;

use App\Facades\Settings;
use App\Frame;
use App\Project;
use App\Report;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCase;

class TextRendererTest extends TestCase
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
            'estimate' => CarbonInterval::create(0)->add('minutes', 30),
        ]);

        factory(Frame::class)->create([
            'project_id' => $project->id,
            'notes' => 'Adding the mailing list signup component',
            'started_at' => Date::parse('2019-05-05 12:00 PM', 'America/New_York')->utc(),
            'stopped_at' => Date::parse('2019-05-05 1:30 PM', 'America/New_York')->utc(),
            'estimate' => CarbonInterval::create(0)->add('minutes', 30),
        ]);

        $output = new BufferedOutput();

        Report::build()
            ->from(Date::create(2019, 05, 03))
            ->to(Date::create(2019, 05, 05))
            ->create()
            ->render($output, 'text');

        $expected = <<<'TEXT'
May 2, 2019 to May 4, 2019
+---------+------+------------------------------------------+-------------+----------+----------+---------+----------+----------+
| Project | Tags | Notes                                    | Date        | Start    | End      | Elapsed | Estimate | Velocity |
+---------+------+------------------------------------------+-------------+----------+----------+---------+----------+----------+
| blog    |      | Starting work on the new theme           | May 4, 2019 | 12:00 pm | 12:30 pm | 0:30    | 0:30     | 1        |
| blog    |      | Adding the mailing list signup component | May 5, 2019 | 12:00 pm | 1:30 pm  | 1:30    | 0:30     | 0.3      |
+---------+------+------------------------------------------+-------------+----------+----------+---------+----------+----------+
Total hours: 2:00

TEXT;

        $this->assertSame($expected, $output->fetch());
    }
}
