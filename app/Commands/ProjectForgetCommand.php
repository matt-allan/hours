<?php

declare(strict_types=1);

namespace App\Commands;

use App\Project;
use LaravelZero\Framework\Commands\Command;

class ProjectForgetCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'project:forget {project*}';

    /**
     * @var string
     */
    protected $description = 'Delete the given project(s)';

    public function handle()
    {
        Project::query()
            ->whereIn('name', $this->argument('project'))
            ->delete();

        $this->info('Projects deleted.');
    }
}
