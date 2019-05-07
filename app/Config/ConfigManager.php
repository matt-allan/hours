<?php

declare(strict_types=1);

namespace App\Config;

use Illuminate\Support\Manager;

class ConfigManager extends Manager implements ConfigFactory
{
    public function getDefaultDriver()
    {
        return $this->app['config']['config.default'];
    }

    public function createFileDriver(): FileRepository
    {
        return new FileRepository();
    }

    public function createMemoryDriver(): MemoryRepository
    {
        return new MemoryRepository();
    }
}
