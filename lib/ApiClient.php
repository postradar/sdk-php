<?php

namespace Postradar\Api\Sdk;

use Postradar\Api\Sdk\Http\Client;

class ApiClient
{
    protected $client;

    public function __construct($url, $apiKey)
    {
        if ('/' !== $url[strlen($url) - 1]) {
            $url .= '/';
        }

        $this->client = new Client($url, array('apiKey' => $apiKey));
    }

}