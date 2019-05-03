<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use Carbon\CarbonInterface;
use LaravelZero\Framework\Commands\Command;

class StopCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'stop';

    /**
     * @var string
     */
    protected $description = 'Stop tracking time for the current project.';

    public function handle(): void
    {
        $frame = Frame::active()->first();

        if (! $frame) {
            $this->error('Time tracking is not currently running.');

            return;
        }

        $frame->stop();

        $this->info("Time tracking for {$frame->project->name} stopped (started {$frame->elapsed->forHumans(CarbonInterface::DIFF_RELATIVE_TO_NOW)}).");
    }
}
