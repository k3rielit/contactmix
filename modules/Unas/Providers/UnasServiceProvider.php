<?php

namespace Modules\Unas\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Unas\Commands\UnasScrapeReferences;
use Modules\Unas\Scrape\UnasScraper;
use Illuminate\Contracts\Foundation\Application;

class UnasServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        /**
         * Binding
         */
        $this->app->singleton(UnasScraper::class, function(Application $app) {
            return UnasScraper::make();
        });
    }

    public function boot(): void
    {
        $this->commands([
            UnasScrapeReferences::class,
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../Configurations/unas.php', 'unas');
    }

}
