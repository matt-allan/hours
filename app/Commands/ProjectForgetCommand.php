<?php

declare(strict_types=1);

namespace App\Commands;

use App\Project;
use LaravelZero\Framework\Commands\Command;
use Stecman\Component\Symfony\Console\BashCompletion\Completion\CompletionAwareInterface;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionContext;

class ProjectForgetCommand extends Command implements CompletionAwareInterface
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

    public function completeOptionValues($optionName, CompletionContext $context): array
    {
        return [];
    }

    public function completeArgumentValues($argumentName, CompletionContext $context): array
    {
        switch ($argumentName) {
            case 'project':
                return Project::all()->map->name->toArray();
            default:
                return [];
        }
    }
}
