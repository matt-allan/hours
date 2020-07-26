<?php

declare(strict_types=1);

namespace App\Commands;

use App\Tag;
use LaravelZero\Framework\Commands\Command;
use Stecman\Component\Symfony\Console\BashCompletion\Completion\CompletionAwareInterface;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionContext;

class TagRenameCommand extends Command implements CompletionAwareInterface
{
    /**
     * @var string
     */
    protected $signature = 'tag:rename {from} {to}';

    /**
     * @var string
     */
    protected $description = 'Rename the given tag';

    public function handle()
    {
        Tag::query()
            ->where('name', $this->argument('from'))
            ->update(['name' => $this->argument('to')]);

        $this->info('Tag renamed.');
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
                return Tag::all()->map->name->toArray();
            default:
                return [];
        }
    }
}
