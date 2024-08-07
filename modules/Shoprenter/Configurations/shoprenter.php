<?php

return [
    'scrape' => [
        'references_url' => env('SHOPRENTER_SCRAPE_REFERENCES', 'https://www.shoprenter.hu/referenciak'),
    ],
    'contacts_page' => env('SHOPRENTER_CONTACTS', '/index.php?route=information/contact'),
];
