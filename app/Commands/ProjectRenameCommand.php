<?php

declare(strict_types=1);

namespace App\Commands;

use App\Project;
use LaravelZero\Framework\Commands\Command;

class ProjectRenameCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'project:rename {from} {to}';

    /**
     * @var string
     */
    protected $description = 'Rename the given project';

    public function handle()
    {
        Project::query()
            ->where('name', $this->argument('from'))
            ->update(['name' => $this->argument('to')]);

        $this->info('Project renamed.');
    }
}
