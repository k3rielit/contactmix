<?php

namespace App\Filament\Admin\Resources\Webshop\UnasResource\Pages;

use App\Filament\Admin\Resources\Webshop\UnasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Unas\Filament\Components\Actions\UnasScrapeAction;

class ListUnas extends ListRecords
{
    protected static string $resource = UnasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            UnasScrapeAction::make(),
            Actions\CreateAction::make(),
        ];
    }

}
