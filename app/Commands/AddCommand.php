<?php

declare(strict_types=1);

namespace App\Commands;

use App\Commands\Concerns\AcceptsDateRangeOptions;
use App\Frame;
use App\Project;
use Illuminate\Support\Facades\Date;
use LaravelZero\Framework\Commands\Command;

class AddCommand extends Command
{
    use AcceptsDateRangeOptions;

    /**
     * @var string
     */
    protected $signature = 'add
        {project : The name of the project to add a frame to}
        {--f|from= : The start time of the frame}
        {--t|to= : the end time of the frame}
        {--i|interval= : An interval for the length of the frame}';

    /**
     * @var string
     */
    protected $description = <<<'DESCRIPTION'
Add a frame that happened in the past to the given project.

The start time of the frame must be specified with the --from option.  The start time may be any textual datetime
format such as '2019-05-01 22:34:46' or a human readable difference such as '2 hours ago'.

You may specify an end time with the --to option.  The --to option accepts all of the same datetime formats as the
--from option.

If you would rather specify an interval than a specific end time you can use the --interval option.  The --interval
option accepts intervals such as '3h 12m' (meaning 3 hours, 12 minutes in this example).

If neither the --to or --interval options are specified the frame will end at the current time.
DESCRIPTION;

    public function handle(): void
    {
        if (! $this->option('from')) {
            $this->error('Please specify a start time with the --from|-f option.');

            return;
        }

        $from = $this->getFromOption();
        $to = $this->getToOption() ?? Date::now();

        $project = Project::firstOrCreate([
            'name' => $this->argument('project'),
        ]);

        /** @var Frame $frame */
        $frame = $project->frames()->create([
            'started_at' => $from,
            'stopped_at' => $to,
        ]);

        $this->info(
            "Added frame for {$project->name} from ".
            "{$frame->started_at->presentDateTime()} ".
            "to {$frame->stopped_at->presentDateTime()} ".
            "({$frame->elapsed->forHumans()})."
        );
    }

}
