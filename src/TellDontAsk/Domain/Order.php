<?php

namespace RefactorKatas\TellDontAsk\Domain;

use RefactorKatas\TellDontAsk\UseCase\SellItemRequest;

/**
 * Class Order
 * @package Archel\TellDontAsk\Domain
 */
class Order
{
    private ?float $total = null;

    private ?string $currency = null;

    private array $items = [];

    private ?float $tax = null;

    private ?OrderStatus $status = null;

    private ?int $id = null;

    public function __construct()
    {
        $this->status = OrderStatus::created();
        $this->currency = "EUR";
        $this->total = 0.0;
        $this->tax = 0.0;
    }


    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getCurrency() : string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency) : void
    {
        $this->currency = $currency;
    }

    public function getItems() : array
    {
        return $this->items;
    }

    /**
     * @param OrderItem[] ...$items
     */
    public function setItems(OrderItem... $items) : void
    {
        $this->items = $items;
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

    public function setTax(float $tax) : void
    {
        $this->tax = $tax;
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