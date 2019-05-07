<?php

declare(strict_types=1);

namespace App\Commands;

use App\Settings\Repository;
use LaravelZero\Framework\Commands\Command;

class SettingsEditCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'settings:edit
    {key : The key to edit}
    {value : The value to set}';

    /**
     * @var string
     */
    protected $description = 'Edit the application settings.';

    public function handle(Repository $settings): void
    {
        $settings->set($this->argument('key'), $this->argument('value'));

        $this->info("Updated {$this->argument('key')} to {$this->argument('value')}");
    }
}
