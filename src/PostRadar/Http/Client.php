<?php

namespace PostRadar\Http;

use PostRadar\Response\ApiResponse;


class Client
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PUT = 'PUT';

    /**
     * Base URL. "http://postradar.ru" for example
     *
     * @var
     */
    protected $url;

    /**
     * Default parameters. Being seted at apiClient object creating. Api token for example
     *
     * @var array
     */
    protected $defaultParameters;

    /**
     * Client constructor.
     *
     * @param $url
     * @param array $defaultParameters
     */
    public function __construct($url, array $defaultParameters = [])
    {
        if ('/' !== $url[strlen($url) - 1]) {
            $url .= '/';
        }

        if (false === stripos($url, 'https://')) {
            throw new \InvalidArgumentException(
                'API schema requires HTTPS protocol'
            );
        }
        $this->url = $url;
        $this->defaultParameters = $defaultParameters;
    }

    /**
     * Make HTTP request using curl
     *
     * @param string $path request url
     * @param string $method HTTP method (GET/POST/PUT...)
     * @param array $parameters (default: array())
     * @return ApiResponse
     * @throws \HttpException
     */
    public function makeRequest($path, $method, array $parameters = [])
    {
        $allowedMethods = [self::METHOD_GET, self::METHOD_POST, self::METHOD_DELETE, self::METHOD_PUT];

        if (!in_array($method, $allowedMethods, false)) {
            throw new \HttpException(
                'Method not allowed'
            );
        }

        $parameters = array_merge($this->defaultParameters, $parameters);
        $url = $this->url.$path;

        if (self::METHOD_GET === $method && count($parameters)) {
            $url .= '?'.http_build_query($parameters, '', '&');
        }

        $curlHandler = curl_init();
        $headers = [
            'X-Api-Token: '.$parameters['X-Api-Token'],
        ];
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
            curl_setopt($curlHandler, CURLOPT_POSTFIELDS, json_encode($parameters));
            $headers[] = 'Content-Type: application/json';
        }

        if (self::METHOD_PUT === $method) {
            curl_setopt($curlHandler, CURLOPT_HEADER, 0);
            curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandler, CURLOPT_POSTFIELDS, json_encode($parameters));
            curl_setopt($curlHandler, CURLOPT_CUSTOMREQUEST, "PUT");
            $headers[] = 'Content-Type: application/json';
        }

        if (self::METHOD_DELETE === $method) {
            curl_setopt($curlHandler, CURLOPT_HEADER, 0);
            curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $parameters);
            curl_setopt($curlHandler, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, $headers);

        $responseBody = curl_exec($curlHandler);
        $statusCode = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);
        $errNo = curl_errno($curlHandler);
        $error = curl_error($curlHandler);
        curl_close($curlHandler);

        if ($errNo) {
            throw new \InvalidArgumentException("curl error #{$errNo} {$error}");
        }

        return new ApiResponse($statusCode, $responseBody);
    }
}