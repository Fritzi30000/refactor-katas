<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\UseCase\Request\OrderApprovalRequest;

/**
 * Class OrderApprovalUseCase
 * @package Archel\TellDontAsk\UseCase
 */
class OrderApprovalUseCase
{
    public function __construct(private OrderRepository $orderRepository)
    {
    }

    /**
     * @throws Exception\RejectedOrderCannotBeApprovedException
     * @throws Exception\ApprovedOrderCannotBeRejectedException
     * @throws Exception\ShippedOrdersCannotBeChangedException
     */
    public function run(OrderApprovalRequest $request) : void
    {
        $order = $this->orderRepository->getById($request->getOrderId());

        if (!$order) {
            return;
        }

        $order->updateStatus($request);

        $this->orderRepository->save($order);
    }
}