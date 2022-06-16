<?php

namespace RefactorKatas\TellDontAsk\Domain;

use RefactorKatas\TellDontAsk\Service\ShipmentService;
use RefactorKatas\TellDontAsk\UseCase\Request\OrderStatusUpdateRequest;
use RefactorKatas\TellDontAsk\UseCase\Request\SellItemRequest;

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

    private ?int $id;

    private int $changed;

    public function __construct(?int $id = null, ?OrderStatus $status = null)
    {
        $this->id = $id;
        $this->status = $status ?: OrderStatus::created();
        $this->currency = "EUR";
        $this->total = 0.0;
        $this->tax = 0.0;
        $this->items = [];
        $this->changed = 0;
    }

    public function addItem(SellItemRequest $itemRequest, Product $product): void
    {
        $item = new OrderItem($itemRequest, $product);
        $this->items[] = $item;
        $this->total += $item->getTaxedAmount();
        $this->tax += $item->getTax();
        $this->changed++;
    }

    public function updateStatus(OrderStatusUpdateRequest $request): void
    {
        if ($this->status->getType() === OrderStatus::CREATED) {
            $this->status = $request->isApproved() ? OrderStatus::approved() : OrderStatus::rejected();
            $this->changed++;
        }
    }

    public function ship(ShipmentService $shipmentService): void
    {
        if ($this->status->getType() === OrderStatus::APPROVED) {
            $shipmentService->ship($this);
            $this->status = OrderStatus::shipped();
            $this->changed++;
        }
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function hasChanged(): bool
    {
        return $this->changed > 0;
    }
}