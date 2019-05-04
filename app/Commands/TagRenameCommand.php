<?php

declare(strict_types=1);

namespace App\Commands;

use App\Tag;
use LaravelZero\Framework\Commands\Command;

class TagRenameCommand extends Command
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
}
