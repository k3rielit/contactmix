<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class IframePreview extends Field
{

    protected string $view = 'forms.components.iframe-preview';
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
