<?php

namespace RefactorKatas\Tests\TellDontAsk\Doubles;

use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;

/**
 * Class TestOrderRepository
 * @package Archel\TellDontAskTest\Doubles
 */
class TestOrderRepository implements OrderRepository
{
    private ?\RefactorKatas\TellDontAsk\Domain\Order $insertedOrder = null;

    private array $orders = [];

    public function save(Order $order): void
    {
        $this->insertedOrder = $order;
    }

    /**
     * @return Order
     */
    public function getById(int $orderId): ?Order
    {
        $order = array_filter($this->orders, fn($order) => $order->getId() === $orderId);

        return !empty($order) ? current($order) : null;
    }

    public function addOrder(Order $order) : void
    {
        $this->orders[] = $order;
    }

    public function getSavedOrder() : Order
    {
        return $this->insertedOrder;
    }
}