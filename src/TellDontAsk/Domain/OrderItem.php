<?php

namespace RefactorKatas\TellDontAsk\Domain;

use RefactorKatas\TellDontAsk\UseCase\Request\SellItemRequest;

/**
 * Class OrderItem
 * @package Archel\TellDontAsk\Domain
 */
class OrderItem
{
    private float $tax;
    private float $taxedAmount;
    private int $quantity;

    public function __construct(SellItemRequest $itemRequest, Product $product)
    {
        $unitaryTax = round(
            ($product->getPrice() / 100) * $product->getCategory()->getTaxPercentage(),
            2
        );
        $unitaryTaxedAmount = round($product->getPrice() + $unitaryTax, 2);
        $taxedAmount = round($unitaryTaxedAmount * $itemRequest->getQuantity(), 2);
        $taxAmount = round($unitaryTax * $itemRequest->getQuantity(), 2);

        $this->quantity = $itemRequest->getQuantity();
        $this->tax = $taxAmount;
        $this->taxedAmount = $taxedAmount;
    }

    public function getTaxedAmount(): float
    {
        return $this->taxedAmount;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}