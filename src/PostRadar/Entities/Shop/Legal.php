<?php

namespace PostRadar\Entities\Shop;

use PostRadar\Entities\Entity;
use PostRadar\Wrap;

class Legal extends Entity
{
    protected static $path = 'legals';

    public static function fromArray($data)
    {
        $entity = parent::fromArray($data);
        $entity->args = [$entity->id];

        return $entity;
    }
}