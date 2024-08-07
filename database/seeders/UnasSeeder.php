<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Unas\Scrape\UnasScraper;

class UnasSeeder extends Seeder
{

    /**
     * Using the UnasScraper, automatically scrape all reference websites.
     */
    public function run(UnasScraper $scraper): void
    {
        $scraper->getReferences();
    }

}
