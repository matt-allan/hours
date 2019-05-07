<?php

declare(strict_types=1);

namespace App\Providers;

use App\Report\RendererFactory;
use App\Report\RendererManager;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RendererManager::class, function () {
            return new RendererManager($this->app);
        });

        $this->app->singleton(RendererFactory::class, RendererManager::class);
    }
}
