<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use LaravelZero\Framework\Commands\Command;

class RestartCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'restart
        {--a|at= : The time to restart the frame at (Defaults to the current time)}';

    /**
     * @var string
     */
    protected $description = 'Restart time tracking for the last active project.';

    public function handle(): void
    {
        if (Frame::active()->first()) {
            $this->error('Time tracking is already running.');
            return;
        }

        /** @var Frame $frame */
        $frame = Frame::latestClosed()->first();

        if (! $frame) {
            $this->error('No closed frames were found');

            return;
        }

        $frame = $frame->restart($this->dateOption('at'));

        $this->info(
            "Restarting frame for {$frame->project->name} ".
            ($frame->tags->isNotEmpty() ? "({$frame->tags->implode('name', ', ')}) " : '').
            "at {$frame->started_at->presentTime()}"
        );
    }
}
