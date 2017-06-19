<?php

namespace PostRadar;

use PostRadar\Response\ApiResponse;

/**
 * @property \PostRadar\Http\Client $client
 */
class Wrap
{
    protected static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __set($key, $val)
    {
        if ($key != 'client') {
            throw new Exception('Wrong wrap setter!');
        }
        $this->$key = $val;
    }

    public function __get($key)
    {
        var_dump($key);
    }

    public static function getEntity($entity, $args)
    {
        $key = __NAMESPACE__.'\Entities\\'.mb_convert_case(
                self::mapEntity($entity), MB_CASE_TITLE
            );
        if (!class_exists($key)) {
            throw new Exception('Entity not exists');
        }

        $keyClass = new \ReflectionClass($key);
        $props = $keyClass->getDefaultProperties();
        $itemClass = isset($props['itemClass']) ? $props['itemClass'] : null;
        if (count($args) == 1 && $itemClass) {
            $key = $itemClass;
        }

        return new $key($args);
    }

    public function __call($method, $args)
    {
        var_dump($method, $args);
    }

    protected static function mapEntity($entity)
    {
        switch ($entity) {
            default:
                return $entity;
        }
    }
}