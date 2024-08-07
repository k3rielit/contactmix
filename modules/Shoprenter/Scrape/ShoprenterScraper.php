<?php

namespace Modules\Shoprenter\Scrape;

use Illuminate\Support\Collection;
use PHPHtmlParser\Dom;

class ShoprenterScraper
{

    protected Dom|null $dom = null;
    protected string|null $referencesUrl = null;
    protected string|null $selector = null;

    public function __construct()
    {
        $this->dom = new Dom;
        $this->referencesUrl = config('shoprenter.scrape.references_url');
    }

    public static function make(): static
    {
        return new static();
    }

    public function referencesUrl(string|null $referencesUrl): static
    {
        $this->referencesUrl = $referencesUrl;
        return $this;
    }

    public function getReferencesUrl(): string|null
    {
        return $this->referencesUrl;
    }

    public function getReferences(): Collection
    {
        return collect();
    }

}
