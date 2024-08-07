<?php

namespace App\Filament\Admin\Resources\Webshop\UnasResource\Pages;

use App\Filament\Admin\Resources\Webshop\UnasResource;
use App\Filament\Exports\Webshop\UnasExporter;
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
            Actions\ExportAction::make()->exporter(UnasExporter::class)->color('success')->icon('heroicon-o-table-cells')->label('Export'),
            Actions\CreateAction::make(),
        ];
    }

}
