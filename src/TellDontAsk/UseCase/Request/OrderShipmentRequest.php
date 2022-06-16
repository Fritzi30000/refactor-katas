<?php

namespace RefactorKatas\TellDontAsk\UseCase\Request;

/**
 * Class OrderShipmentRequest
 * @package Archel\TellDontAsk\UseCase
 */
class OrderShipmentRequest
{
    private ?int $orderId = null;

    public function setOrderId(int $orderId) : void
    {
        $this->orderId = $orderId;
    }

    public function getOrderId() : int
    {
        return $this->orderId;
    }
}