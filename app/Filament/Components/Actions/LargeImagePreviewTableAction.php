<?php

namespace App\Filament\Components\Actions;

use App\Forms\Components\ImagePreview;
use Filament\Tables\Actions\Action as TableAction;
use Illuminate\Database\Eloquent\Model;
use Closure;

class LargeImagePreviewTableAction extends TableAction
{

    protected Closure|string|null $imageUrl = null;

    public static function getDefaultName(): ?string
    {
        return 'large_image_preview';
    }

    public function imageUrl(Closure|string|null $imageUrl): static
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function getImageUrl(): string|null
    {
        return $this->evaluate($this->imageUrl);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-photo');
        $this->label('Preview');
        $this->modalHeading('Preview');
        $this->modalSubmitAction(false);
        $this->modalCancelAction(false);
        $this->stickyModalHeader();

        $this->form(fn() => [
            ImagePreview::make('preview')->source(fn() => $this->getImageUrl()),
        ]);
    }

}
