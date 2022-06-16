<?php

namespace RefactorKatas\TellDontAsk\UseCase\Request;

/**
 * Class SellItemRequest
 * @package Archel\TellDontAsk\UseCase
 */
class SellItemRequest
{
    private int $quantity;
    private string $productName;

    public function __construct(int $quantity, string $productName)
    {
        $this->quantity = $quantity;
        $this->productName = $productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProductName() : string
    {
        return $this->productName;
    }
}