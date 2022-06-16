<?php

namespace RefactorKatas\TellDontAsk\UseCase\Request;

/**
 * Class SellItemRequest
 * @package Archel\TellDontAsk\UseCase
 */
class SellItemRequest
{
    private ?int $quantity = null;

    private ?string $productName = null;

    public function setQuantity(int $quantity) : void
    {
        $this->quantity = $quantity;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function setProductName(string $productName) : void
    {
        $this->productName = $productName;
    }

    public function getProductName() : string
    {
        return $this->productName;
    }
}