<?php

namespace Modules\Shoprenter\Providers;

use Illuminate\Support\ServiceProvider;

class ShoprenterServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Configurations/shoprenter.php', 'shoprenter');
    }

}
