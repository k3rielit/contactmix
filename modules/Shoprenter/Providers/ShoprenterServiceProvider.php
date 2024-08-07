<?php

namespace Modules\Shoprenter\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Shoprenter\Commands\ShoprenterScrapeReferences;
use Modules\Shoprenter\Scrape\ShoprenterScraper;

class ShoprenterServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        /**
         * Binding
         */
        $this->app->singleton(ShoprenterScraper::class, function(Application $app) {
            return ShoprenterScraper::make();
        });
    }

    public function boot(): void
    {
        $this->commands([
            ShoprenterScrapeReferences::class,
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../Configurations/shoprenter.php', 'shoprenter');
    }

}
