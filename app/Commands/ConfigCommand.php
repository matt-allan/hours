<?php

declare(strict_types=1);

namespace App\Commands;

use App\Config;
use Illuminate\Support\Str;
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

    public function handle(Config $config): void
    {
        if (! $this->argument('key') || ! $this->argument('value')) {
            $this->openEditor();

            return;
        }

        $key = Str::camel($this->argument('key'));
        $value = $this->argument('value');

        $config->{$key} = $value;
        $config->save();

        $this->info("Updated {$key} to {$value}");
    }

    private function openEditor(): void
    {
        system(
            $this->editor().' '.home_config_path(Config::PATH).(PHP_OS_FAMILY === 'win' ? '' : ' > `tty`')
        );
    }

    private function editor(): ?string
    {
        if ($editor = escapeshellcmd(getenv('VISUAL'))) {
            return $editor;
        }

        if ($editor = escapeshellcmd(getenv('EDITOR'))) {
            return $editor;
        }

        if (PHP_OS_FAMILY === 'win') {
            return 'notepad';
        }

        foreach (['vim', 'vi', 'nano'] as $editor) {
            if (exec('which '.$editor)) {
                return $editor;
            }
        }

        return null;
    }
}
