<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bootstrap\InitializeDatabase;
use App\Events\ConfigureTimezone;
use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ArtisanStarting::class => [
            InitializeDatabase::class,
        ],
        CommandStarting::class => [
            ConfigureTimezone::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
