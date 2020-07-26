<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Frame;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class RestartCommandTest extends TestCase
{
    public function testRestart()
    {
        Date::setTestNow($now = Date::now());

        $frame = factory(Frame::class)->create()
            ->addTags(['writing', 'editing']);

        $this
            ->artisan('restart')
            ->assertExitCode(0)
            ->expectsOutput("Restarting frame for {$frame->project->name} (writing, editing) at {$now->presentTime()}");

        $restarted = Frame::active()->first();

        $this->assertFalse($frame->is($restarted));
        $this->assertTrue($frame->project->is($restarted->project));
    }

    public function testRestartWhenTimeTrackingIsAlreadyRunning()
    {
        $this->artisan('start blog');

        $this
            ->artisan('restart')
            ->expectsOutput('Time tracking is already running.');
    }
}
