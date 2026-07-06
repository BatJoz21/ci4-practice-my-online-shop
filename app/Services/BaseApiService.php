<?php

namespace App\Services;

use GuzzleHttp\Client;

class BaseApiService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            "base_uri"      => "http://localhost:8080/",
            "timeout"       => 10
        ]);
    }
}
