<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\UseCase\Request\OrderStatusUpdateRequest;

/**
 * Class OrderApprovalUseCase
 * @package Archel\TellDontAsk\UseCase
 */
class OrderApprovalUseCase
{
    public function __construct(private OrderRepository $orderRepository)
    {
    }

    public function run(OrderStatusUpdateRequest $request) : void
    {
        $order = $this->orderRepository->getById($request->getOrderId());

        if (!$order) {
            return;
        }

        $order->updateStatus($request);

        if ($order->hasChanged()) {
            $this->orderRepository->save($order);
        }
    }
}