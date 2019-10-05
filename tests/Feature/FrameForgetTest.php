<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Frame;
use Tests\TestCase;

class FrameForgetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFrameForget()
    {
        $frame = factory(Frame::class)->create();

        $this->artisan('frame:forget 1')
            ->expectsOutput('Frame deleted.')
            ->assertExitCode(0);

        $this->assertDatabaseMissing('frames', ['id' => $frame->id]);
    }

    public function testFrameForgetNonExistingFrame()
    {
        $frame = factory(Frame::class)->create();

        $this->artisan('frame:forget 2')
            ->expectsOutput('Frame does not exist.')
            ->assertExitCode(1);

        $this->assertDatabaseHas('frames', ['id' => $frame->id]);
    }
}
