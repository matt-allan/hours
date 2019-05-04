<?php

declare(strict_types=1);

namespace App\Commands;

use App\Config;
use LaravelZero\Framework\Commands\Command;

class ConfigCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'config
    {key? : The configuration key to edit}
    {value? : The value to set}';

    /**
     * @var string
     */
    protected $description = 'Edit the configuration file.';

    public function handle(Config\Repository $config): void
    {
        if (! $this->argument('key') || ! $this->argument('value')) {
            if ($config instanceof Config\Editable) {
                $config->edit();

                return;
            }
            $this->error('A configuration key must be specified');

            return;
        }

        $config->set($this->argument('key'), $this->argument('value'));

        $this->info("Updated {$this->argument('key')} to {$this->argument('value')}");
    }
}
