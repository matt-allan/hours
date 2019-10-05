<?php

declare(strict_types=1);

namespace App\Commands;

use App\Frame;
use LaravelZero\Framework\Commands\Command;

class FrameForgetCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'frame:forget {id}';

    /**
     * @var string
     */
    protected $description = 'Delete a given frame.';

    public function handle()
    {
        if (! Frame::destroy($this->argument('id'))) {
            $this->getOutput()->writeln('<comment>Frame does not exist.</comment>');

            return 1;
        }

        $this->getOutput()->writeln('<info>Frame deleted.</info>');
    }
}
