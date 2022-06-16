<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\UseCase\ApprovedOrderCannotBeRejectedException;
use RefactorKatas\TellDontAsk\UseCase\OrderApprovalRequest;
use RefactorKatas\TellDontAsk\UseCase\RejectedOrderCannotBeApprovedException;
use RefactorKatas\TellDontAsk\UseCase\ShippedOrdersCannotBeChangedException;

/**
 * Class OrderApprovalUseCase
 * @package Archel\TellDontAsk\UseCase
 */
class OrderApprovalUseCase
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * OrderApprovalUseCase constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function run(OrderApprovalRequest $request) : void
    {
        $order = $this->orderRepository->getById($request->getOrderId());

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