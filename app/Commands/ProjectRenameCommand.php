<?php

declare(strict_types=1);

namespace App\Commands;

use App\Project;
use LaravelZero\Framework\Commands\Command;
use Stecman\Component\Symfony\Console\BashCompletion\Completion\CompletionAwareInterface;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionContext;

class ProjectRenameCommand extends Command implements CompletionAwareInterface
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

    public function completeOptionValues($optionName, CompletionContext $context): array
    {
        return [];
    }

    public function completeArgumentValues($argumentName, CompletionContext $context): array
    {
        switch ($argumentName) {
            case 'from':
            case 'to':
                return Project::all()->map->name->toArray();
            default:
                return [];
        }
    }
}
