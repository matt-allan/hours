<?php

declare(strict_types=1);

namespace App\Providers;

use App\Settings\DatabaseRepository;
use App\Settings\Repository;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Repository::class, DatabaseRepository::class);
    }
}
