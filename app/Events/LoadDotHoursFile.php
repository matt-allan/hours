<?php

declare(strict_types=1);

namespace App\Bootstrap;

use Dotenv\Dotenv;

/**
 * Load .hours file if it exists.
 */
class LoadDotHoursFile
{
    public function handle(): void
    {
        $file = getcwd().DIRECTORY_SEPARATOR.'.hours';

        if (! file_exists($file)) {
            return;
        }

        Dotenv::create($file)->load();
    }
}
