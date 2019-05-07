<?php

declare(strict_types=1);

namespace App\Providers;

use App\Config\Repository;
use App\Config\ConfigFactory;
use App\Config\ConfigManager;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ConfigManager::class, function () {
            return new ConfigManager($this->app);
        });

        $this->app->singleton(ConfigFactory::class, ConfigManager::class);

        $this->app->singleton(Repository::class, function () {
            return $this->app->make(ConfigManager::class)->driver();
        });
    }
}
