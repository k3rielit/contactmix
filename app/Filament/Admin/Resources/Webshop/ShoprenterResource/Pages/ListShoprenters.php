<?php

namespace App\Filament\Admin\Resources\Webshop\ShoprenterResource\Pages;

use App\Filament\Admin\Resources\Webshop\ShoprenterResource;
use App\Filament\Exports\Webshop\ShoprenterExporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Shoprenter\Filament\Components\Actions\ShoprenterScrapeAction;

class ListShoprenters extends ListRecords
{
    protected static string $resource = ShoprenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ShoprenterScrapeAction::make(),
            Actions\ExportAction::make()->exporter(ShoprenterExporter::class)->color('success')->icon('heroicon-o-table-cells')->label('Export'),
            Actions\CreateAction::make(),
        ];
    }

}
