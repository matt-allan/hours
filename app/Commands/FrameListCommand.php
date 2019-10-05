<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use LaravelZero\Framework\Commands\Command;

class FrameListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'frame:list';

    /**
     * @var string
     */
    protected $description = 'List all frames.';

    public function handle()
    {
        $this->table(
            ['ID', 'Project', 'Tags', 'Notes', 'Date', 'Start', 'End', 'Elapsed'],
            Frame::query()->latest()->with(['project', 'tags'])->get()->map(function (Frame $frame) {
                return [
                    $frame->getKey(),
                    $frame->project->name,
                    $frame->tags->implode('name', ', '),
                    $frame->notes,
                    $frame->created_at->presentDate(),
                    $frame->created_at->presentTime(),
                    optional($frame->stopped_at)->presentTime(),
                    $frame->elapsed->presentInterval(),
                ];
            })
        );
    }
}
