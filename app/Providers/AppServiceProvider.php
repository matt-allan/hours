<?php

declare(strict_types=1);

namespace App\Providers;

use App\Facades\Settings;
use Carbon\CarbonInterval;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Dotenv\Dotenv;
use Illuminate\Console\Command;
use App\Carbon\CarbonPresentMixin;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\DateFactory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use App\Carbon\CarbonIntervalPresentMixin;
use Illuminate\Contracts\Support\Arrayable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DateFactory::use(CarbonImmutable::class);

        CarbonImmutable::mixin($this->app->make(CarbonPresentMixin::class));

        CarbonInterval::mixin($this->app->make(CarbonIntervalPresentMixin::class));

        Collection::macro('toCsv', function () {
            /* @var Collection $this */
            return $this->map(function ($value) {
                $fh = fopen('php://temp', 'r+');
                fputcsv($fh, $value instanceof Arrayable ? $value->toArray() : (array) $value);
                rewind($fh);
                $contents = stream_get_contents($fh);
                fclose($fh);

                return $contents;
            });
        });

        Command::macro('dateOption', function (string $key): ?CarbonInterface {
            /** @var Command $this */
            if (! $this->option($key)) {
                return null;
            }

            return Date::parse(
                $this->option($key),
                Settings::get('timezone')
            )->utc();
        });

        Command::macro('projectArgument', function () {
            /** @var Command $this */
            $project = $this->argument('project');

            if (!$project) {
                $project = getenv('default_project');
            }

            if (!$project) {
                $project = Settings::get('default_project');
            }

            return $project;
        });

        if (file_exists($localConfig = getcwd() . DIRECTORY_SEPARATOR . '.hours')) {
            Dotenv::create(getcwd(), '.hours')->load();
        }
    }
}
