<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use LaravelZero\Framework\Commands\Command;

class StatusCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'status';

    /**
     * @var string
     */
    protected $description = 'Checks the current status of time tracking.';

    public function handle(): void
    {
        $frame = Frame::active();

        if (! $frame) {
            $this->info('No active projects.');

            return;
        }

        $this->info("Time tracking for {$frame->project->name} started {$frame->diff()}.");
    }
}
