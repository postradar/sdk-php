<?php

namespace PostRadar\Entities;

class Order extends Entity
{
    protected static $path = '';

    public static function fromArray($data)
    {
        $entity = parent::fromArray($data);
        $entity->args = [$entity->id];

        return $entity;
    }
}