<?php

namespace Postradar\Api\Sdk;

use Postradar\Api\Sdk\Http\Client;

class ApiClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $params;


    public function __construct($url, $apiKey)
    {
        if ('/' !== $url[strlen($url) - 1]) {
            $url .= '/';
        }

        $this->client = new Client($url, array('X-Api-Token' => $apiKey));
    }

    /**
     * @param array $params
     * @return Response\ApiResponse
     */
    public function getProfile($params = array())
    {
        return $this->client->makeRequest('profile', 'GET', $params);
    }

    /**
     * @param array $params
     * @return Response\ApiResponse
     */
    public function getAssembler($params = array())
    {
        return $this->client->makeRequest('settings/assembly/operators', 'GET', $params);
    }

    /**
     * Creating new assembler
     *
     * @param string $email
     * @param string $phone
     * @param string $name
     * @param string $password
     * @param array $tags
     * @return Response\ApiResponse
     */
    public function addAssembler(string $email, string $phone, string $name, string $password, $tags)
    {
        $params = [];
        $params['email'] = $email;
        $params['phone'] = $phone;
        $params['fullname'] = $name;
        $params['password'] = $password;
        $params['tags'] = $tags;

        return $this->client->makeRequest('settings/assembly/operators', 'POST', $params);
    }

    /**
     * @param string $id
     * @return Response\ApiResponse
     */
    public function deleteAssembler(string $id)
    {
        return $this->client->makeRequest('settings/assembly/operators/' . $id, 'DELETE', array());
    }

    /**
     * @param string $id
     * @return Response\ApiResponse
     */
    public function showAssembler(string $id)
    {
        return $this->client->makeRequest('settings/assembly/operators/' . $id, 'GET', array());
    }

    /**
     * @param string $id
     * @return Response\ApiResponse
     */
    public function updateAssembler(string $id, string $email, string $phone, string $name, string $password, $tags)
    {
        $params = [];
        $params['email'] = $email;
        $params['phone'] = $phone;
        $params['fullname'] = $name;
        $params['password'] = $password;
        $params['tags'] = $tags;

        return $this->client->makeRequest('settings/assembly/operators/' . $id, 'PUT', $params);
    }

    /**
     * @return Response\ApiResponse
     */
    public function getListOfOperators()
    {
        return $this->client->makeRequest('settings/calls/operators', 'GET', array());
    }

    /**
     * Creating new operator
     *
     * @param string $email
     * @param string $phone
     * @param string $name
     * @param string $password
     * @param array $tags
     * @return Response\ApiResponse
     */
    public function addOperator(string $email, string $phone, string $name, string $password, $tags)
    {
        $params = [];
        $params['email'] = $email;
        $params['phone'] = $phone;
        $params['fullname'] = $name;
        $params['password'] = $password;
        $params['tags'] = $tags;

        return $this->client->makeRequest('settings/calls/operators', 'POST', $params);
    }

    /**
     * @param string $id
     * @return Response\ApiResponse
     */
    public function deleteOperator(string $id)
    {
        return $this->client->makeRequest('settings/calls/operators/' . $id, 'DELETE', array());
    }

    /**
     * @param string $id
     * @return Response\ApiResponse
     */
    public function showOperator(string $id)
    {
        return $this->client->makeRequest('settings/calls/operators/' . $id, 'GET', array());
    }

    /**
     * @param string $id
     * @return Response\ApiResponse
     */
    public function updateOperator(string $id, string $email, string $phone, string $name, string $password, $tags)
    {
        $params = [];
        $params['email'] = $email;
        $params['phone'] = $phone;
        $params['fullname'] = $name;
        $params['password'] = $password;
        $params['tags'] = $tags;

        return $this->client->makeRequest('settings/calls/operators/' . $id, 'PUT', $params);
    }
}