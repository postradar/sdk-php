<?php

namespace PostRadar\Entities;

class Product extends Entity
{
    protected static $path = 'products';

    public function update($sku, $name, $description, array $prices, $weight)
    {
        $params = [
            'name' => $name,
            'sku' => $sku,
            'description' => $description,
            'prices' => $prices,
            'weight' => $weight,
        ];

        return parent::_update($params);
    }

    public static function fromArray($data)
    {
        $entity = parent::fromArray($data);
        $entity->args = [$entity->id];

        return $entity;
    }
}