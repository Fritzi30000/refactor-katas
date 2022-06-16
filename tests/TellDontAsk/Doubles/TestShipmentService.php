<?php

namespace RefactorKatas\Tests\TellDontAsk\Doubles;

use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Service\ShipmentService;

/**
 * Class TestShipmentService
 * @package Archel\TellDontAskTest\Doubles
 */
class TestShipmentService implements ShipmentService
{
    private $shippedOrder = null;

    /**
     * @return Order|null
     */
    public function getShippedOrder() : ?Order
    {
        return $this->shippedOrder;
    }

    /**
     * @param Order $order
     */
    public function ship(Order $order): void
    {
        $this->shippedOrder = $order;
    }
}