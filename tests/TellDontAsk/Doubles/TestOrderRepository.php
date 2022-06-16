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
    /**
     * @var Order
     */
    private $insertedOrder;

    /**
     * @var array
     */
    private $orders = [];

    /**
     * @param Order $order
     */
    public function save(Order $order): void
    {
        $this->insertedOrder = $order;
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function getById(int $orderId): ?Order
    {
        $order = array_filter($this->orders, function ($order) use ($orderId) {
            return $order->getId() === $orderId;
        });

        return !empty($order) ? current($order) : null;
    }

    /**
     * @param Order $order
     */
    public function addOrder(Order $order) : void
    {
        $this->orders[] = $order;
    }

    /**
     * @return Order
     */
    public function getSavedOrder() : Order
    {
        return $this->insertedOrder;
    }
}