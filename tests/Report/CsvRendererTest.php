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

class CsvRendererTest extends TestCase
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
            ->render($output, 'csv');

        $expected = <<<'CSV'
Project,Date,Start,End,Elapsed
blog,"May 4, 2019","12:00 pm","12:30 pm",0:30
blog,"May 5, 2019","12:00 pm","1:30 pm",1:30

CSV;

        $this->assertSame($expected, $output->fetch());
    }
}
