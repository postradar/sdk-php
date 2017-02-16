<?php

namespace Postradar\Api\Sdk\Response;


class ApiResponse
{
    protected $statusCode;

    protected $response;

    /**
     * ApiResponse constructor.
     * @param $statusCode
     * @param null $responseBody
     * @throws \HttpRequestException
     */
    public function __construct($statusCode, $responseBody = null)
    {
        $this->statusCode = (int) $statusCode;
        if (!empty($responseBody)) {
            $response = json_decode($responseBody, true);
            if (!$response && JSON_ERROR_NONE !== ($error = json_last_error())) {
                echo "Invalid JSON in the API response body. Error code #$error";
            }
            $this->response = $response;
        }
    }

    /**
     * Return HTTP response status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * HTTP request was successful
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->statusCode < 400;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \HttpRequestException
     */
    public function __call($name, $arguments)
    {
        // convert getSomeProperty to someProperty
        $propertyName = strtolower(substr($name, 3, 1)) . substr($name, 4);
        if (!isset($this->response[$propertyName])) {
            throw new \HttpRequestException("Method \"$name\" not found");
        }
        return $this->response[$propertyName];
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (!isset($this->response[$name])) {
            throw new \InvalidArgumentException("Property \"$name\" not found");
        }
        return $this->response[$name];
    }

    /**
     * Offset set
     *
     * @throws \BadMethodCallException
     * @return void
     */
    public function offsetSet()
    {
        throw new \BadMethodCallException('This activity not allowed');
    }

    /**
     * Offset unset
     *
     * @throws \BadMethodCallException
     * @return void
     */
    public function offsetUnset()
    {
        throw new \BadMethodCallException('This call not allowed');
    }

    /**
     * Check offset
     *
     * @param mixed $offset offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->response[$offset]);
    }

    /**
     * Get offset
     *
     * @param mixed $offset offset
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (!isset($this->response[$offset])) {
            throw new \InvalidArgumentException("Property \"$offset\" not found");
        }
        return $this->response[$offset];
    }
}