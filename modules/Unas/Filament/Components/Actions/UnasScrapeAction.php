<?php

namespace Modules\Unas\Filament\Components\Actions;

use App\Models\Webshop\Unas;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Unas\Scrape\UnasScraper;

class UnasScrapeAction extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'unas_scrape';
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->label('Scrape');
        $this->icon('heroicon-o-bolt');
        $this->color('warning');
        $this->requiresConfirmation();

        $this->action(function(UnasScraper $scraper) {
            // Scrape
            $countBefore = Unas::query()->count();
            $results = $scraper->getReferences();
            $countAfter = Unas::query()->count();
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
