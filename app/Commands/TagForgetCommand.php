<?php

declare(strict_types=1);

namespace App\Commands;

use App\Tag;
use LaravelZero\Framework\Commands\Command;

class TagForgetCommand extends Command
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
}
