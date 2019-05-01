<?php

namespace App\Providers;

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
        $this->app->bind(InitializeDatabase::class, function () {
            return new InitializeDatabase(
                $this->app->make(FilesystemManager::class)->disk('data'),
                $this->app->make(Migrator::class),
                basename(config('database.connections.sqlite.database'))
            );
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
    }
}
