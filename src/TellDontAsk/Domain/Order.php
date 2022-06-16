<?php

namespace RefactorKatas\TellDontAsk\Domain;

use RefactorKatas\TellDontAsk\Domain\OrderItem;
use RefactorKatas\TellDontAsk\Domain\OrderStatus;

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

    private ?\RefactorKatas\TellDontAsk\Domain\OrderStatus $status = null;

    private ?int $id = null;

    public function getTotal() : float
    {
        return $this->total;
    }

    public function setTotal(float $total)
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

    public function addItem(OrderItem $item) : void
    {
        $this->items[] = $item;
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