<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/**
 * Schedule
 */

Schedule::command(\Modules\Unas\Commands\UnasScrapeReferences::class)->hourly();
Schedule::command(\Modules\Shoprenter\Commands\ShoprenterScrapeReferences::class)->daily();
