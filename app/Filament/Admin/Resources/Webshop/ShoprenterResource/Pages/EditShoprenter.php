<?php

namespace App\Filament\Admin\Resources\Webshop\ShoprenterResource\Pages;

use App\Filament\Admin\Resources\Webshop\ShoprenterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShoprenter extends EditRecord
{
    protected static string $resource = ShoprenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
