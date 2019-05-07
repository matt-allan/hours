<?php

declare(strict_types=1);

namespace App\Config;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class FileRepository implements Repository, Editable
{
    private const PATH = 'config.json';

    /**
     * @var Collection
     */
    private $items;

    /**
     * @var bool
     */
    private $loaded = false;

    public function __construct($items = [])
    {
        $this->items = collect($items);

        if ($this->items->isNotEmpty()) {
            $this->loaded = true;
        }
    }

    public function get(string $key, $default = null)
    {
        $this->load();

        return $this->items->get($key, $default);
    }

    public function set(string $key, $value): Repository
    {
        $this->load();

        $this->items->put($key, $value);

        return $this;
    }

    public function edit(): void
    {
        system(
            $this->editor().' '.home_config_path(self::PATH).(PHP_OS_FAMILY === 'win' ? '' : ' > `tty`')
        );
        $this->load(true);
    }

    private function editor(): string
    {
        if ($editor = getenv('VISUAL')) {
            return escapeshellcmd($editor);
        }

        if ($editor = getenv('EDITOR')) {
            return escapeshellcmd($editor);
        }

        if (PHP_OS_FAMILY === 'win') {
            return 'notepad';
        }

        foreach (['vim', 'vi', 'nano'] as $editor) {
            if (exec('which '.$editor)) {
                return $editor;
            }
        }

        throw new \RuntimeException('A valid editor could not be found');
    }

    public function __destruct()
    {
        $this->save();
    }

    private function load(bool $force = false): void
    {
        if ($this->loaded && ! $force) {
            return;
        }

        if (! Storage::disk('config')->exists(self::PATH)) {
            $this->loaded = true;

            return;
        }

        $items = json_decode(Storage::disk('config')->get(self::PATH), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON: '.json_last_error_msg());
        }

        if (! empty($items)) {
            $this->items = collect($items);
        }

        $this->loaded = true;
    }

    private function save(): bool
    {
        if ($this->items->isEmpty()) {
            return true;
        }

        return Storage::disk('config')->put(self::PATH, $this->items->toJson(JSON_PRETTY_PRINT));
    }
}
