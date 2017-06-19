<?php

namespace PostRadar\Entities;

class Order extends Entity
{
    protected static $path = '';

    public function update($sku, $name, $description, array $prices, $weight)
    {
        die;
//        $params = [
//            'name' => $name,
//            'sku' => $sku,
//            'description' => $description,
//            'prices' => $prices,
//            'weight' => $weight,
//        ];

        return parent::_update($params);
    }

    public static function fromArray($data)
    {
        $entity = parent::fromArray($data);
        $entity->args = [$entity->id];

        return $entity;
    }
}