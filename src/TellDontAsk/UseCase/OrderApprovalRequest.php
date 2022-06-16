<?php

namespace RefactorKatas\TellDontAsk\UseCase;

/**
 * Class OrderApprovalRequest
 * @package Archel\TellDontAsk\UseCase
 */
class OrderApprovalRequest
{
    private ?int $orderId = null;

    private ?bool $approved = null;

    public function setOrderId(int $orderId) : void
    {
        $this->orderId = $orderId;
    }

    public function getOrderId() : int
    {
        return $this->orderId;
    }

    public function setApproved(bool $approved) : void
    {
        $this->approved = $approved;
    }

    public function isApproved() : bool
    {
        return $this->approved;
    }
}