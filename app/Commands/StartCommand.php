<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use App\Project;
use Carbon\CarbonImmutable;
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
                "Time is already being tracked for {$active->project->name} (started {$active->elapsed->forHumans(CarbonImmutable::DIFF_RELATIVE_TO_NOW)}).  ".
                    'Do you want to stop the active frame?'
            )) {
                return;
            }
            $this->call('stop');
        }

        $project = Project::firstOrCreate([
            'name' => $this->argument('project'),
        ]);

        $frame = $project->frames()->create([
            'started_at' => CarbonImmutable::now(),
        ]);

        $this->info("Starting {$project->name} at {$frame->started_at->presentTime()}");
    }
}
