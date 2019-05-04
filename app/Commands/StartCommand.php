<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use App\Project;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use LaravelZero\Framework\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'start {project}';

    /**
     * @var string
     */
    protected $description = 'Start tracking time for the given project.';

    public function handle(): void
    {
        if ($active = Frame::active()->first()) {
            if (! $this->confirm(
                "Time is already being tracked for {$active->project->name} (started {$active->elapsed->forHumans(CarbonInterface::DIFF_RELATIVE_TO_NOW)}).  ".
                    'Do you want to stop the active frame?'
            )) {
                return;
            }
            $this->call('stop');
        }

        $frame = Frame::start($this->argument('project'));

        $this->info("Starting {$frame->project->name} at {$frame->started_at->presentTime()}");
    }
}
