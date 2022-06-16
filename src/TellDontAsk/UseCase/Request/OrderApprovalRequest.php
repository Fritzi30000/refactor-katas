<?php

namespace RefactorKatas\TellDontAsk\UseCase\Request;

/**
 * Class OrderApprovalRequest
 * @package Archel\TellDontAsk\UseCase
 */
class OrderApprovalRequest
{
    private int $orderId;
    private bool $approved;

    public function __construct(int $orderId, bool $approved)
    {
        $this->orderId = $orderId;
        $this->approved = $approved;
    }

    public function getOrderId() : int
    {
        return $this->orderId;
    }

    public function isApproved() : bool
    {
        return $this->approved;
    }
}