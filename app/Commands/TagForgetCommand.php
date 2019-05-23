<?php

declare(strict_types=1);

namespace App\Commands;

use App\Tag;
use LaravelZero\Framework\Commands\Command;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionContext;
use Stecman\Component\Symfony\Console\BashCompletion\Completion\CompletionAwareInterface;

class TagForgetCommand extends Command implements CompletionAwareInterface
{
    /**
     * @var string
     */
    protected $signature = 'tag:forget {tag*}';

    /**
     * @var string
     */
    protected $description = 'Delete the given tag(s)';

    public function handle()
    {
        Tag::query()
            ->whereIn('name', $this->argument('tag'))
            ->delete();

        $this->info('Tags deleted.');
    }

    public function completeOptionValues($optionName, CompletionContext $context): array
    {
        return [];
    }

    public function completeArgumentValues($argumentName, CompletionContext $context): array
    {
        switch ($argumentName) {
            case 'tag':
                return Tag::all()->map->name->toArray();
            default:
                return [];
        }
    }
}
