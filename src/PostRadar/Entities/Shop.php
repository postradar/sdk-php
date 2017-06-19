<?php

namespace PostRadar\Entities;

use PostRadar\Entities\Shop\Legals;

class Shop extends Entity
{
    protected static $path = 'shops';

    public function update($title, $url)
    {
        $params = [
            'title' => $title,
            'url' => $url
        ];

        return parent::_update($params);
    }

    public static function fromArray($data)
    {
        $entity = parent::fromArray($data);
        $entity->args = [$entity->id];

        return $entity;
    }

    public function __call($key, $args)
    {
        switch ($key) {
            case 'legals':
                return $this->get(Legals::class);
            default:
                return null;
        }
    }
}