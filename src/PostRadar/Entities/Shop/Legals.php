<?php

namespace PostRadar\Entities\Shop;

use PostRadar\Entities\Entity;

class Legals extends Entity
{
    protected static $path = 'legals';
    protected $itemClass = Legal::class;

    /**
     * @param string $name
     * @param string $inn
     * @param string $bik
     * @param string $bank
     * @param string $corrAccount
     * @param string $finAccount
     * @param string $address
     *
     * @return Legal
     */
    public function create($name, $inn, $bik, $bank, $corrAccount, $finAccount, $address)
    {
        $params = [
            'name' => $name,
            'inn' => $inn,
            'bik' => $bik,
            'bank' => $bank,
            'corr_account' => $corrAccount,
            'fin_account' => $finAccount,
            'address' => $address,
        ];

        return parent::_create($params);
    }
}