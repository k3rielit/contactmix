<?php

namespace App\Filament\Admin\Resources\Webshop\UnasResource\Pages;

use App\Filament\Admin\Resources\Webshop\UnasResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUnas extends ViewRecord
{
    protected static string $resource = UnasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
