<?php

namespace PostRadar\Entities;

class Shops extends Entity
{
    protected static $path = 'shops';
    protected $itemClass = Shop::class;

    /**
     * @param string $title
     * @param string $url
     *
     * @return Shop
     */
    public function create($title, $url)
    {
        $params = [
            'title' => $title,
            'url' => $url
        ];

        return parent::_create($params);
    }
}