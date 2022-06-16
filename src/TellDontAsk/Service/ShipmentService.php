<?php

namespace RefactorKatas\TellDontAsk\Service;

use RefactorKatas\TellDontAsk\Domain\Order;

/**
 * Class ShipmentService
 * @package Archel\TellDontAsk\Service
 */
interface ShipmentService
{
    public function ship(Order $order) : void;
}