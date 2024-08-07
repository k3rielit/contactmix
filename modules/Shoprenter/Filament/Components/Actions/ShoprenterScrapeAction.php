<?php

namespace Modules\Shoprenter\Filament\Components\Actions;

use App\Models\Webshop\Shoprenter;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Shoprenter\Scrape\ShoprenterScraper;

class ShoprenterScrapeAction extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'shoprenter_scrape';
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->label('Scrape');
        $this->icon('heroicon-o-bolt');
        $this->color('warning');
        $this->requiresConfirmation();

        $this->action(function(ShoprenterScraper $scraper) {
            // Scrape
            $countBefore = Shoprenter::query()->count();
            $results = $scraper->getReferences();
            $countAfter = Shoprenter::query()->count();
            $createdUnasModels = $countAfter - $countBefore;
            // Notify user
            Notification::make('unas_scrape_results')
                ->iconColor('warning')
                ->icon('heroicon-o-bolt')
                ->title('Scrape complete')
                ->body("Found and saved {$results->count()} entries. {$createdUnasModels} new UNAS models have been created.")
                ->persistent()
                ->send();
        });
    }

}
