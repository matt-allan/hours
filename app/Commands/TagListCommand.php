<?php

declare(strict_types=1);

namespace App\Commands;

use App\Tag;
use LaravelZero\Framework\Commands\Command;

class TagListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'tag:list';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List all of the tags.';

    public function handle()
    {
        $this->table(
            ['name'],
            Tag::all()->map(function (Tag $tag) {
                return [$tag->name];
            })
        );
    }
}
