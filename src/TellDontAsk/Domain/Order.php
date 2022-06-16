<?php

namespace RefactorKatas\TellDontAsk\Domain;

use RefactorKatas\TellDontAsk\UseCase\SellItemRequest;

/**
 * Class Order
 * @package Archel\TellDontAsk\Domain
 */
class Order
{
    private float $total;

    private string $currency;

    private array $items;

    private float $tax;

    private OrderStatus $status;

    private ?int $id = null;

    public function __construct()
    {
        $this->status = OrderStatus::created();
        $this->currency = "EUR";
        $this->total = 0.0;
        $this->tax = 0.0;
        $this->items = [];
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCurrency() : string
    {
        return $this->currency;
    }

    public function getItems() : array
    {
        return $this->items;
    }

    public function addItem(SellItemRequest $itemRequest, Product $product): void
    {
        $item = new OrderItem($itemRequest, $product);
        $this->items[] = $item;
        $this->total += $item->getTaxedAmount();
        $this->tax += $item->getTax();
    }

    public function getTax() : float
    {
        return $this->tax;
    }

    public function getStatus() : OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $orderStatus) : void
    {
        $this->status = $orderStatus;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }
}