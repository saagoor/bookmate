<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\Http;

class LocationScraper
{
    protected string $url = 'http://www.geoplugin.net/php.gp';

    function get_user_coordinates($url = null)
    {
        if ($url) {
            $this->url = $url;
        }
        try {
            $ip = request()->ip();
            if ($ip == '127.0.0.1') {
                $ip = '103.217.111.18';
            }
            $response = Http::acceptJson()->get($this->url, ['ip' => $ip]);
            $data = unserialize($response->body());
            return (object)[
                'latitude' => $data['geoplugin_latitude'],
                'longitude' => $data['geoplugin_longitude'],
            ];
        } catch (Exception $e) {
            return false;
        }
    }
}