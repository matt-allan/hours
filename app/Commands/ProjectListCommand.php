<?php

declare(strict_types=1);

namespace App\Commands;

use App\Project;
use LaravelZero\Framework\Commands\Command;

class ProjectListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'project:list';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List all of the projects.';

    public function handle()
    {
        $this->output->writeln(
            Project::all()->map->name
        );
    }
}
