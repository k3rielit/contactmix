<?php

namespace App\Filament\Admin\Resources\Webshop\UnasResource\Pages;

use App\Filament\Admin\Resources\Webshop\UnasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnas extends EditRecord
{
    protected static string $resource = UnasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
