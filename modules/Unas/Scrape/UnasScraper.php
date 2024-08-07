<?php

namespace Modules\Unas\Scrape;

use App\Models\Webshop\Unas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\CurlException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\StrictException;
use PHPHtmlParser\Dom\Collection as DomCollection;
use PHPHtmlParser\Dom\HtmlNode;
use Throwable;

class UnasScraper
{

    protected Dom|null $dom = null;
    protected string|null $referencesUrl = null;
    protected string|null $selector = ".ref-item > a";
    protected string|null $contactRowsSelector = "#page_contact_content > * tr";

    public function __construct()
    {
        $this->dom = new Dom;
        $this->referencesUrl = config('unas.scrape.references_url');
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
            $url = $referenceNode?->getAttribute('href');
            $title = $referenceNode?->getAttribute('title');
            $imageUrl = $imageNode?->getAttribute('data-src');
            $modelState = [
                'title' => $title,
                'url' => $url,
                'image_url' => $imageUrl,
            ];
            $unasModel = Unas::query()->where('url', $url)->firstOrCreate($modelState);
            $unasModel->update($modelState);
            $references->push($unasModel);
        }
        return $references;
    }

    public function updateContactInformation(Unas $record): Unas
    {
        $keyValueStore = [];
        /**
         * Try loading the contacts page.
         */
        try {
            $this->dom->loadFromUrl($record->contacts_page_url);
        }
        catch(Throwable $exception) {
            error_log($exception->getMessage());
            Log::error($exception->getMessage(), $exception->getTrace());
            return $record;
        }

        /**
         * Get the contact page table rows.
         */
        try {
            $contactRows = $this->dom->find($this->contactRowsSelector);
        }
        catch(Throwable $exception) {
            error_log($exception->getMessage());
            Log::error($exception->getMessage(), $exception->getTrace());
            return $record;
        }
        if(!$contactRows instanceof DomCollection) {
            return $record;
        }

        /**
         * Parse the contact page table rows.
         * @var HtmlNode $contactRow
         */
        foreach ($contactRows as $contactRow) {
            $innerText = $contactRow->text(lookInChildren: true);
            $keyValueStore[] = htmlspecialchars_decode(trim($innerText));
        }
        /**
         * Update the UNAS record with the newly found key-value pairs.
         */
        $record->update([
            'contact_information' => $keyValueStore,
        ]);
        return $record;
    }

}
