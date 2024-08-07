<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Closure;

class ImagePreview extends Field
{

    protected string $view = 'forms.components.image-preview';
    protected bool | Closure $isLabelHidden = true;
    protected Closure|string|null $source = null;

    public function source(Closure|string|null $source): static
    {
        $this->source = $source;
        return $this;
    }

    public function getSource(): string|null
    {
        return $this->evaluate($this->source);
    }

}
