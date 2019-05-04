<?php

declare(strict_types=1);

namespace Tests\Report;

use App\Frame;
use App\Report;
use App\Project;
use Tests\TestCase;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Console\Output\BufferedOutput;

class TextRendererTest extends TestCase
{
    public function testRender()
    {
        $this->withConfig(['timezone' => 'America/New_York']);

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
            ->render($output, 'text');

        $expected = <<<'TEXT'
May 2, 2019 to May 4, 2019
+---------+------+------------------------------------------+-------------+----------+----------+---------+
| Project | Tags | Notes                                    | Date        | Start    | End      | Elapsed |
+---------+------+------------------------------------------+-------------+----------+----------+---------+
| blog    |      | Starting work on the new theme           | May 4, 2019 | 12:00 pm | 12:30 pm | 0:30    |
| blog    |      | Adding the mailing list signup component | May 5, 2019 | 12:00 pm | 1:30 pm  | 1:30    |
+---------+------+------------------------------------------+-------------+----------+----------+---------+
Total hours: 2:00

TEXT;

        $this->assertSame($expected, $output->fetch());
    }
}
