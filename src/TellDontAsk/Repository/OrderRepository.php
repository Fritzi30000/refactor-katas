<?php

namespace RefactorKatas\TellDontAsk\Repository;

use RefactorKatas\TellDontAsk\Domain\Order;

/**
 * Class OrderRepository
 * @package Archel\TellDontAsk\Repository
 */
interface OrderRepository
{
    public function save(Order $order) : void;

    /**
     * @return Order
     */
    public function getById(int $orderId) : ?Order;
}