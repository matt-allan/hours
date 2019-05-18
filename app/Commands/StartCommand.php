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

    /**
     * @var string
     */
    protected $help = <<<'HELP'
The only required argument is the project name.

You may specify the start time using the --at option. This is useful if you
forgot to start time tracking. For example, `hours start blog --at '5 minutes ago'`
would begin a frame 5 minutes ago for the 'blog' project.

Tags may be specified with the --tag option.  If the tag does not exist it will
be created.

You can attach notes to the frame with the --notes option.  The notes option
accepts any text that you would like to add to the frame.
HELP;

    public function __construct()
    {
        parent::__construct();

        $this->setHelp($this->help);
    }

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

        $frame = Frame::start($this->argument('project'), $this->dateOption('at'))
            ->addTags($this->option('tag'))
            ->addNotes($this->option('notes'));

        $this->info(
            "Starting frame for {$frame->project->name} ".
            ($frame->tags->isNotEmpty() ? "({$frame->tags->implode('name', ', ')}) " : '').
            "at {$frame->started_at->presentTime()}"
        );
    }
}
