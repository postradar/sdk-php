<?php

namespace PostRadar\Entities;

use PostRadar\Exception;
use PostRadar\Wrap;

class Entity implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $args;

    /**
     * @var string
     */
    protected static $path;

    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @var bool
     */
    protected $isSuccessful;

    /**
     * @var array
     */
    protected $entityData = [];

    /**
     * @var bool
     */
    protected $isPaging = false;

    /**
     * @var bool
     */
    protected $hasPageNext = false;

    /**
     * @var bool
     */
    protected $hasPagePrevious = false;

    /**
     * Entity constructor.
     * @param $args
     * @param bool $fetch
     */
    public function __construct($args = [], $fetch = true)
    {
        $this->args = $args;

        if ($fetch) {
            $this->fetch();
        }
    }

    public static function getDefaultPath()
    {
        return static::$path;
    }

    public static function fromArray($data)
    {
        $entity = new static([$data['id']], false);
        if ($entity->itemClass) {
            $class = $entity->itemClass;
            $entity = new $class([$data['id']], false);
        }
        $entity->entityData = $data;

        return $entity;
    }

    public static function fromEntity(Entity $entity, $path = null)
    {
        $requestEntity = new static([], false);
        $requestEntity->fetch($entity->getPath());

        return $requestEntity;
    }

    public function getPath(array $pathParams = [])
    {
        $path = static::getDefaultPath();

        if (count($this->args) == 1) {
            $path .= '/'.$this->args[0];
        }

        return $path;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        if ($this->isPaging && is_int($offset)) {
            return isset($this->entityData['items'][$offset]) ? true : false;
        } else {
            return isset($this->entityData[$offset]) ? true : false;
        }
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        if ($this->isPaging && is_int($offset)) {
            return isset($this->entityData['items'][$offset]) ? $this->entityData['items'][$offset] : null;
        } else {
            return isset($this->entityData[$offset]) ? $this->entityData[$offset] : null;
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ($this->isPaging && is_int($offset)) {
            $this->entityData['items'][$offset] = $value;
        } else {
            $this->entityData[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->isPaging && is_int($offset)) {
            if (isset($this->entityData['items'][$offset])) {
                unset($this->entityData['items'][$offset]);
            }
        } else {
            if (isset($this->entityData[$offset])) {
                unset($this->entityData[$offset]);
            }
        }
    }

    protected function _create(array $params = [], array $pathParams = [])
    {
        $response = Wrap::getInstance()->client->makeRequest($this->getPath($pathParams), 'POST', $params);
        if ($response->getStatusCode() != 201) {
            Exception::ExceptionPostHandler(
                'Request error, see details',
                $response->getStatusCode(),
                $response->getError()
            );
        }

        return static::fromArray($response->getFullResponse());
    }

    protected function _update(array $params = [])
    {
        $response = Wrap::getInstance()->client->makeRequest($this->getPath(), 'PUT', $params);
        if ($response->getStatusCode() != 200) {
            Exception::ExceptionPostHandler(
                'Request error, see details',
                $response->getStatusCode(),
                $response->getError()
            );
        }

        return static::fromArray($response->getFullResponse());
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function delete()
    {
        if (count($this->args) != 1) {
            throw new Exception('Cant find entity ID', 400);
        }

        $response = Wrap::getInstance()->client->makeRequest($this->getPath(), 'DELETE');

        if ($response->getStatusCode() != 202) {
            Exception::ExceptionPostHandler(
                'Request error, see details',
                $response->getStatusCode(),
                $response->getError()
            );
        }

        return true;
    }

    public function fetch($prePath = null)
    {
        $path = $this->getPath();
        if ($prePath) {
            $path = $prePath.'/'.$path;
        }

        $response = Wrap::getInstance()->client->makeRequest($path, 'GET');
        $this->isSuccessful = $response->isSuccessful();
        $this->entityData = $response->isSuccessful()
            ? $response->getFullResponse()
            : ['error' => $response->getError()];

        if (
            array_key_exists('items', $this->entityData) &&
            array_key_exists('limit', $this->entityData) &&
            array_key_exists('offset', $this->entityData) &&
            array_key_exists('next', $this->entityData) &&
            array_key_exists('previous', $this->entityData) &&
            array_key_exists('total', $this->entityData) &&
            array_key_exists('href', $this->entityData)
        ) {
            $this->isPaging = true;
            if ($this->entityData['next']) {
                $this->hasPageNext = true;
            }
            if ($this->entityData['previous']) {
                $this->hasPagePrevious = true;
            }

            if ($this->itemClass) {
                $entityClass = $this->itemClass;
                foreach ($this->entityData['items'] as &$item) {
                    $item = $entityClass::fromArray($item);
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->isSuccessful;
    }

    /**
     * @param $key
     *
     */
    public function get($key)
    {
        return $key::fromEntity($this, $this->getPath());
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return isset($this->entityData[$key]) ? $this->entityData[$key] : null;
    }
}