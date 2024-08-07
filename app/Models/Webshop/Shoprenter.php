<?php

namespace App\Models\Webshop;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Webshop\ShoprenterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoprenter extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'checked' => 'boolean',
        ];
    }

    protected $appends = [
        'favicon',
        'contacts_page_url',
    ];

    protected static function newFactory(): ShoprenterFactory|Factory
    {
        return ShoprenterFactory::new();
    }

    // Attributes

    public function getFaviconAttribute(): string|null
    {
        return "https://www.google.com/s2/favicons?size=64&domain_url=" . $this->url;
    }

    public function getContactsPageUrlAttribute(): string|null
    {
        return trim($this->url, " \n\r\t\v\0/") . config('shoprenter.contacts_page');
    }

}
