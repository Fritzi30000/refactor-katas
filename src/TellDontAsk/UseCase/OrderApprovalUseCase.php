<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\UseCase\Exception\ApprovedOrderCannotBeRejectedException;
use RefactorKatas\TellDontAsk\UseCase\Exception\RejectedOrderCannotBeApprovedException;
use RefactorKatas\TellDontAsk\UseCase\Exception\ShippedOrdersCannotBeChangedException;

/**
 * Class OrderApprovalUseCase
 * @package Archel\TellDontAsk\UseCase
 */
class OrderApprovalUseCase
{
    /**
     * OrderApprovalUseCase constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(private OrderRepository $orderRepository)
    {
    }

    public function run(OrderApprovalRequest $request) : void
    {
        $order = $this->orderRepository->getById($request->getOrderId());

        if (!$order) {
            return;
        }

        if ($order->getStatus()->getType() === OrderStatus::SHIPPED) {
            throw new ShippedOrdersCannotBeChangedException();
        }

        if ($request->isApproved() && $order->getStatus()->getType() === OrderStatus::REJECTED) {
            throw new RejectedOrderCannotBeApprovedException();
        }

        if (!$request->isApproved() && $order->getStatus()->getType() === OrderStatus::APPROVED) {
            throw new ApprovedOrderCannotBeRejectedException();
        }

        $order->setStatus($request->isApproved() ? OrderStatus::approved() : OrderStatus::rejected());
        $this->orderRepository->save($order);
    }
}