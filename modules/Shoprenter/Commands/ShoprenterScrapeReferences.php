<?php

namespace Modules\Shoprenter\Commands;

use App\Models\Webshop\Shoprenter;
use Illuminate\Console\Command;
use Modules\Shoprenter\Scrape\ShoprenterScraper;

class ShoprenterScrapeReferences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shoprenter:scrape-references';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes Shoprenter reference website URLs.';

    protected array $tableHeaders = [
        'Title',
        'URL',
        'Image',
        'Checked',
    ];

    /**
     * Execute the console command.
     */
    public function handle(ShoprenterScraper $scraper)
    {
        $references = $scraper->getReferences();
        $referencesTableRows = $references->map(fn(Shoprenter $item) => [
            $item->title,
            $item->url,
            $item->image_url,
            $item->checked ? 'True' : 'False',
        ]);
        $this->table($this->tableHeaders, $referencesTableRows);
    }

}
