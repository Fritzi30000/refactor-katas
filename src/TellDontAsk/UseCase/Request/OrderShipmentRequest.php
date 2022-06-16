<?php

namespace RefactorKatas\TellDontAsk\UseCase\Request;

/**
 * Class OrderShipmentRequest
 * @package Archel\TellDontAsk\UseCase
 */
class OrderShipmentRequest
{
    private int $orderId;

    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getOrderId() : int
    {
        return $this->orderId;
    }
}