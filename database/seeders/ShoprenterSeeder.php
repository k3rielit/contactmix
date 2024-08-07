<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Shoprenter\Scrape\ShoprenterScraper;

class ShoprenterSeeder extends Seeder
{

    /**
     * Using the ShoprenterScraper, automatically scrape all reference websites.
     */
    public function run(ShoprenterScraper $scraper): void
    {
        $scraper->getReferences();
    }

}
