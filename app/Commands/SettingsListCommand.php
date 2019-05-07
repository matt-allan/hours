<?php

declare(strict_types=1);

namespace App\Commands;

use App\Settings\Repository;
use LaravelZero\Framework\Commands\Command;

class SettingsListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'settings:list';

    /**
     * @var string
     */
    protected $description = 'List the application settings.';

    public function handle(Repository $settings): void
    {
        $this->table(['name', 'value'], $settings->all());
    }
}
