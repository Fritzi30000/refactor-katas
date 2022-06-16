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
    private ?Order $shippedOrder = null;

    public function getShippedOrder() : ?Order
    {
        return $this->shippedOrder;
    }

    public function ship(Order $order): void
    {
        $this->shippedOrder = $order;
    }
}