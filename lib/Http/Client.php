<?php

namespace Postradar\Api\Sdk\Http;

use Postradar\Api\Sdk\Response\ApiResponse;


class Client
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    protected $url;
    protected $defaultParameters;

    public function __construct($url, array $defaultParameters = array())
    {
        if (false === stripos($url, 'http://')) {
            throw new \InvalidArgumentException(
                'API schema requires HTTP protocol'
            );
        }
        $this->url = $url;
        $this->defaultParameters = $defaultParameters;
    }

    /**
     * Make HTTP request
     *
     * @param string $path       request url
     * @param string $method     (default: 'GET')
     * @param array  $parameters (default: array())
     *
     * @return ApiResponse
     */
    public function makeRequest($path, $method, array $parameters = []) {
        $allowedMethods = array(self::METHOD_GET, self::METHOD_POST);

        if (!in_array($method, $allowedMethods, false)) {
            echo 'tut budet exception';
        }

        $parameters = array_merge($this->defaultParameters, $parameters);
        $url = $this->url . $path;

        if (self::METHOD_GET === $method && count($parameters)) {
            $url .= '?' . http_build_query($parameters, '', '&');
        }

        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, $url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandler, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curlHandler, CURLOPT_FAILONERROR, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlHandler, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandler, CURLOPT_CONNECTTIMEOUT, 30);

        if (self::METHOD_POST === $method) {
            curl_setopt($curlHandler, CURLOPT_POST, true);
            curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $parameters);
            curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array(
                    'X-Api-Token: ' . $parameters['X-Api-Token'],
                )
            );
        }

        $responseBody = curl_exec($curlHandler);
        $statusCode = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
        $errno = curl_errno($curlHandler);
        $error = curl_error($curlHandler);
        curl_close($curlHandler);

        if ($errno) {
            echo 'tut budet exception';
            echo $responseBody . '<br>';
            echo $statusCode . '<br>';
            echo $errno . '<br>';
            echo $error . '<br>';
        }

        return new ApiResponse($statusCode, $responseBody);
    }
}