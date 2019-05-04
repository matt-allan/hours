<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use Carbon\CarbonInterface;
use LaravelZero\Framework\Commands\Command;

class CancelCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'cancel';

    /**
     * @var string
     */
    protected $description = 'Cancel the active frame.';

    public function handle(): void
    {
        $frame = Frame::active()->first();

        if (! $frame) {
            $this->error('Time tracking is not currently running.');

            return;
        }

        $frame->delete();

        $this->info("Time tracking for {$frame->project->name} cancelled (started {$frame->elapsed->forHumans(CarbonInterface::DIFF_RELATIVE_TO_NOW)}).");
    }
}
