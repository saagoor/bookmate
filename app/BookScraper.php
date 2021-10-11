<?php

namespace App;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BookScraper
{

    protected $baseUrl = 'https://www.rokomari.com/';
    protected $url;
    protected $params;
    protected $xpath;

    public static function url(string $url, array $params = [])
    {
        $instance = new self();
        $instance->url = $url;
        if ($params) {
            $instance->params = $params;
        }
        return $instance;
    }

    public function params(array $params = [])
    {
        $this->params = $params;
        return $this;
    }

    public function get(array $params = [])
    {
        $url = $this->url;
        if (!Str::startsWith($url, 'http')) {
            $url = $this->baseUrl . $url;
        }
        $response = Http::get($url, $this->params);
        $htmlString = (string) $response->getBody();

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($htmlString);

        $this->xpath = new DOMXPath($doc);

        return $this;
    }

    public function price()
    {
        $priceEls = $this->xpath->query('//div[@class="browse__content-books-wrapper"]/div/div[1]//p[@class="book-price"]/*');
        if ($priceEls) {
            $bookPrice = (int) filter_var($priceEls->item(0)->textContent, FILTER_SANITIZE_NUMBER_INT);
            return $bookPrice;
        }
        return -1;
    }
}
