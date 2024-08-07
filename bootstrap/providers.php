<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    /**
     * Modules
     */
    Modules\Shoprenter\Providers\ShoprenterServiceProvider::class,
    Modules\Unas\Providers\UnasServiceProvider::class,
];
