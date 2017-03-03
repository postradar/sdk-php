<?php

namespace Postradar\Api\Sdk;

use Postradar\Api\Sdk\Http\Client;

class ApiClient
{
    /**
     * Instance of Http/Client.php class
     *
     * @var Client
     */
    protected $client;

    /**
     * ApiClient constructor.
     * @param $url
     * @param $apiKey
     */
    public function __construct($url, $apiKey)
    {
        if ('/' !== $url[strlen($url) - 1]) {
            $url .= '/';
        }

        $this->client = new Client($url, array('X-Api-Token' => $apiKey));
    }

    /**
     * Getting profile info
     *
     * @param array $params
     * @return Response\ApiResponse
     */
    public function getProfile($params = array())
    {
        return $this->client->makeRequest('profile', 'GET', $params);
    }

    /**
     *Showing list of attached assembly operators
     *
     * @param array $params
     * @return Response\ApiResponse
     */
    public function getAssembler($params = array())
    {
        return $this->client->makeRequest('settings/assembly/operators', 'GET', $params);
    }

    /**
     * Creating and ataching new assembly operator.
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
     * Deleting assembly operator
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function deleteAssembler(string $id)
    {
        return $this->client->makeRequest('settings/assembly/operators/' . $id, 'DELETE', array());
    }

    /**
     * Showing assembly operator information
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function showAssembler(string $id)
    {
        return $this->client->makeRequest('settings/assembly/operators/' . $id, 'GET', array());
    }

    /**
     * Updating assembler information
     *
     * @param string $id
     * @param string $email
     * @param string $phone
     * @param string $name
     * @param string $password
     * @param $tags
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
     * Showing list of attached call-center operators
     *
     * @return Response\ApiResponse
     */
    public function getListOfOperators()
    {
        return $this->client->makeRequest('settings/calls/operators', 'GET', array());
    }

    /**
     * Creating new call-center operator
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
     * Deleting call-center operator
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function deleteOperator(string $id)
    {
        return $this->client->makeRequest('settings/calls/operators/' . $id, 'DELETE', array());
    }

    /**
     * Showing call-center operator info
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function showOperator(string $id)
    {
        return $this->client->makeRequest('settings/calls/operators/' . $id, 'GET', array());
    }

    /**
     * Updating call-center operator info
     *
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

    /**
     * Shoing list of owned shops
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function getShopList()
    {
        return $this->client->makeRequest('shops/', 'GET', array());
    }

    /**
     * Creating and attaching shop
     *
     * @param string $title
     * @param string $url
     * @return Response\ApiResponse
     */
    public function addShop(string $title, string $url)
    {
        $params = [];
        $params['title'] = $title;
        $params['url'] = $url;

        return $this->client->makeRequest('shops/', 'POST', $params);
    }

    /**
     * Showing shop info
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function getShop(string $id)
    {
        return $this->client->makeRequest('shops/' . $id, 'GET', array());
    }

    /**
     * Update shop info
     *
     * @param string $id
     * @param string $title
     * @param string $url
     * @return Response\ApiResponse
     */
    public function updateShop(string $id, string $title, string $url)
    {
        $params = [];
        $params['title'] = $title;
        $params['url'] = $url;

        return $this->client->makeRequest('shops/' . $id, 'PUT', $params);
    }

    /**
     * Deleting shop
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function removeShop(string $id)
    {
        return $this->client->makeRequest('shops/' . $id, 'DELETE', array());
    }

    /**
     * Showing list of legals attached to shop
     *
     * @param string $id
     * @return Response\ApiResponse
     */
    public function getShopLegalList(string $id)
    {
        return $this->client->makeRequest('shops/' . $id . '/legals', 'GET', array());
    }

    /**
     * Creating and attaching legal
     *
     * @param string $id
     * @param string $name
     * @param string $inn
     * @param string $bik
     * @param string $bank
     * @param string $corrAccount
     * @param string $finAccount
     * @param string $address
     * @return Response\ApiResponse
     */
    public function addLegal(string $id, string $name, string $inn, string $bik, string $bank, string $corrAccount, string $finAccount, string $address)
    {
        $params = [];
        $params['name'] = $name;
        $params['inn'] = $inn;
        $params['bik'] = $bik;
        $params['bank'] = $bank;
        $params['corr_account'] = $corrAccount;
        $params['fin_account'] = $finAccount;
        $params['address'] = $address;

        return $this->client->makeRequest('/shops/' . $id . '/legals', 'POST', $params);
    }

    /**
     * Showing legal info
     *
     * @param string $id
     * @param string $legalId
     * @return Response\ApiResponse
     */
    public function getLegal(string $id, string $legalId)
    {
        return $this->client->makeRequest('/shops/' . $id . '/legals/' . $legalId, 'GET', array());
    }

    /**
     * Update legal info
     *
     * @param string $id
     * @param string $legalId
     * @param string $name
     * @param string $inn
     * @param string $bik
     * @param string $bank
     * @param string $corrAccount
     * @param string $finAccount
     * @param string $address
     * @return Response\ApiResponse
     */
    public function updateLegal(string $id, string $legalId, string $name, string $inn, string $bik, string $bank, string $corrAccount, string $finAccount, string $address)
    {
        $params = [];
        $params['name'] = $name;
        $params['inn'] = $inn;
        $params['bik'] = $bik;
        $params['bank'] = $bank;
        $params['corr_account'] = $corrAccount;
        $params['fin_account'] = $finAccount;
        $params['address'] = $address;

        return $this->client->makeRequest('/shops/' . $id . '/legals/' . $legalId, 'PUT', $params);
    }

    /**
     * Deleting legal
     *
     * @param string $id
     * @param string $legalId
     * @return Response\ApiResponse
     */
    public function removeLegal(string $id, string $legalId)
    {
        return $this->client->makeRequest('/shops/' . $id . '/legals/' . $legalId, 'DELETE', array());
    }

}