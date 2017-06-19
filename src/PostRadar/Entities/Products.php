<?php

namespace PostRadar\Entities;

class Products extends Entity
{
    protected static $path = 'products';
    protected $itemClass = Product::class;

    /**
     * @param string $sku
     * @param string $name
     * @param string $description
     * @param array $prices
     * @param int $weight
     *
     * @return Product
     */
    public function create($sku, $name, $description, array $prices, $weight)
    {
        $params = [
            'name' => $name,
            'sku' => $sku,
            'description' => $description,
            'prices' => $prices,
            'weight' => $weight,
        ];

        return parent::_create($params);
    }
}