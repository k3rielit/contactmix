<?php

namespace Modules\Shoprenter\Scrape;

use App\Models\Webshop\Shoprenter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\Collection as DomCollection;
use PHPHtmlParser\Dom\HtmlNode;

class ShoprenterScraper
{

    protected Dom|null $dom = null;
    protected string|null $referencesUrl = null;
    protected string|null $selector = ".element-item";

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
        $references = collect();
        $url = $this->getReferencesUrl();

        /**
         * Try loading from URL
         */
        if(!$url) {
            return $references;
        }
        try {
            $this->dom->loadFromUrl($url);
        }
        catch(Throwable $exception) {
            error_log($exception->getMessage());
            Log::error($exception->getMessage(), $exception->getTrace());
            return $references;
        }

        /**
         * Collect reference item nodes
         */
        try {
            $referenceNodes = $this->dom->find($this->selector);
        }
        catch(Throwable $exception) {
            error_log($exception->getMessage());
            Log::error($exception->getMessage(), $exception->getTrace());
            return $references;
        }
        if(!$referenceNodes instanceof DomCollection) {
            return $references;
        }

        /**
         * Process reference item nodes.
         * @var HtmlNode $referenceNode
         * @var HtmlNode|null $imageNode
         */
        foreach ($referenceNodes as $referenceNode) {
            $imageNode = $referenceNode?->find('img')[0] ?? null;
            $anchorNode = $referenceNode?->find('a')[0] ?? null;
            $url = $anchorNode?->getAttribute('href');
            $title = $imageNode?->getAttribute('title');
            $imageUrl = $imageNode?->getAttribute('src');
            $modelState = [
                'title' => $title,
                'url' => $url,
                'image_url' => $imageUrl,
            ];
            $shoprenterModel = Shoprenter::query()->where('url', $url)->firstOrCreate($modelState);
            $shoprenterModel->update($modelState);
            $references->push($shoprenterModel);
        }
        return $references;
    }

}
