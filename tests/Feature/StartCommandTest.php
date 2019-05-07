<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Frame;
use Tests\TestCase;
use Illuminate\Support\Facades\Date;

class StartCommandTest extends TestCase
{
    public function testStart()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog')
            ->expectsOutput('Starting frame for blog at '.$now->presentTime())
            ->assertExitCode(0);
    }

    public function testStartWhenAlreadyRunning()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog');

        Date::setTestNow($now->addSeconds(5));

        $this->artisan('start blog')
            ->expectsQuestion(
                'Time is already being tracked for blog (started 5 seconds ago).  '.
                    'Do you want to stop the active frame?',
                'yes'
            )
            ->expectsOutput('Time tracking for blog stopped (started 5 seconds ago).')
            ->expectsOutput('Starting frame for blog at '.$now->addSeconds(5)->presentTime())
            ->assertExitCode(0);
    }

    public function testStartWithTags()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog --tag writing --tag editing')
            ->expectsOutput('Starting frame for blog (writing, editing) at '.$now->presentTime())
            ->assertExitCode(0);

        /** @var Frame $frame */
        $frame = Frame::forProject('blog')->first();

        $this->assertSame(
            ['writing', 'editing'],
            $frame->tags->map->name->toArray()
        );
    }

    public function testStartWithAtOption()
    {
        Date::setTestNow($now = Date::now());

        $this->artisan('start blog --at \'05:34:46\'')
            ->expectsOutput('Starting frame for blog at 5:34 am')
            ->assertExitCode(0);
    }
}
