<?php

declare(strict_types=1);

namespace App\Providers;

use App\Config;
use App\Report\RendererFactory;
use App\Report\RendererManager;
use Carbon\CarbonInterval;
use Carbon\CarbonImmutable;
use App\Carbon\CarbonPresentMixin;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\DateFactory;
use App\Bootstrap\InitializeDatabase;
use Illuminate\Support\ServiceProvider;
use App\Carbon\CarbonIntervalPresentMixin;
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

        $this->app->singleton(RendererFactory::class, RendererManager::class);
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

        CarbonImmutable::mixin($this->app->make(CarbonPresentMixin::class));

        CarbonInterval::mixin($this->app->make(CarbonIntervalPresentMixin::class));

        Collection::macro('toCsv', function () {
            /** @var Collection $this */
            return $this->map(function ($value) {
                $fh = fopen('php://temp', 'r+');
                fputcsv($fh, $value instanceof Arrayable ? $value->toArray() : (array) $value);
                rewind($fh);
                $contents = stream_get_contents($fh);
                fclose($fh);
                return $contents;
            });
        });
    }
}
