<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Frame;
use App\Tag;
use Tests\TestCase;
use Illuminate\Support\Facades\Date;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StartCommandTest extends TestCase
{
    use RefreshDatabase;

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
}
