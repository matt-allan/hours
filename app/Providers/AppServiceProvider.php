<?php

declare(strict_types=1);

namespace App\Providers;

use App\Carbon\PresentMixin;
use App\Config;
use Carbon\CarbonImmutable;
use Illuminate\Support\DateFactory;
use App\Bootstrap\InitializeDatabase;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Console\Application as Artisan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InitializeDatabase::class, function () {
            return new InitializeDatabase(
                $this->app->make(FilesystemManager::class)->disk('data'),
                $this->app->make(Migrator::class),
                basename(config('database.connections.sqlite.database'))
            );
        });

        $this->app->singleton(Config::class, function () {
            return Config::get();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Artisan::starting(function () {
            $this->app
                ->make(InitializeDatabase::class)
                ->bootstrap();
        });

        DateFactory::use(CarbonImmutable::class);

        CarbonImmutable::mixin($this->app->make(PresentMixin::class));
    }
}
