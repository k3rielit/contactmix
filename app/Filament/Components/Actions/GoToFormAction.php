<?php

namespace App\Filament\Components\Actions;

use Filament\Forms\Components\Actions\Action as FormAction;

class GoToFormAction extends FormAction
{

    public static function getDefaultName(): ?string
    {
        return 'go_to';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->url('#');
        $this->label('Open');
        $this->icon('heroicon-o-arrow-top-right-on-square');
        $this->openUrlInNewTab();
    }

}
