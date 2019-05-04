<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use Carbon\CarbonInterface;
use LaravelZero\Framework\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'start
        {project : The name of the project to start tracking time for}
        {--a|at= : The time to start the frame at (Defaults to the current time)}
        {--t|tag=* : The tags to add to the frame}
        {--notes= : The notes to add to the frame}';

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

        $frame = Frame::start($this->argument('project'))
            ->addTags($this->option('tag'))
            ->addNotes($this->option('notes'));

        $this->info(
            "Starting frame for {$frame->project->name} ".
            ($frame->tags->isNotEmpty() ? "({$frame->tags->implode('name', ', ')}) " : '').
            "at {$frame->started_at->presentTime()}"
        );
    }
}
