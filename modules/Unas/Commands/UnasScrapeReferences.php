<?php

namespace Modules\Unas\Commands;

use App\Models\Webshop\Unas;
use Illuminate\Console\Command;
use Modules\Unas\Scrape\UnasScraper;

class UnasScrapeReferences extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unas:scrape-references';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes UNAS reference website URLs.';

    protected array $tableHeaders = [
        'Title',
        'URL',
        'Image',
        'Checked',
    ];

    /**
     * Execute the console command.
     */
    public function handle(UnasScraper $scraper)
    {
        $references = $scraper->getReferences();
        $referencesTableRows = $references->map(fn(Unas $item) => [
            $item->title,
            $item->url,
            $item->image_url,
            $item->checked ? 'True' : 'False',
        ]);
        $this->table($this->tableHeaders, $referencesTableRows);
    }

}
