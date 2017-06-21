<?php

namespace PostRadar\Entities;

class Orders extends Entity
{
    protected static $path = 'orders';
    protected $itemClass = Order::class;

    /**
     * @param string $shopId
     * @param string $legalId
     * @param array $items
     * @param string $status
     * @param string $phone
     * @param array $client
     * @param string $address
     * @param string $externalId
     * @param string $deliveryKey
     * @param int $priceInsurance
     * @param int $pricePay
     *
     * @return Order
     */
    public function create(
        $shopId,
        $legalId,
        array $items,
        $status,
        $phone,
        $client = null,
        $address,
        $externalId = null,
        $deliveryKey = null,
        $priceInsurance = null,
        $pricePay = null
    ) {
        $params = [
            'items' => $items,
            'status' => $status,
            'phone' => ['digits' => $phone],
            'client' => $client,
            'address' => $address ? ['origin' => $address] : null,
            'delivery_key' => $deliveryKey,
            'external_id' => $externalId,
            'price_insurance' => $priceInsurance,
            'price_pay' => $pricePay
        ];

        return parent::_create($params, ['shopId' => $shopId, 'legalId' => $legalId]);
    }

    public function getPath(array $pathParams = [])
    {
        $path = parent::getPath($pathParams);
        if (isset($pathParams['shopId']) && isset($pathParams['legalId'])) {
            $path = Shops::getDefaultPath().'/'.$pathParams['shopId'].'/legals/'.$pathParams['legalId'].'/orders';
        }

        return $path;
    }
}