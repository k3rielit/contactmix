<?php

namespace App\Filament\Admin\Resources\Webshop\ShoprenterResource\Pages;

use App\Filament\Admin\Resources\Webshop\ShoprenterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShoprenter extends ViewRecord
{
    protected static string $resource = ShoprenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
