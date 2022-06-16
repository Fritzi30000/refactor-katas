<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\Service\ShipmentService;
use RefactorKatas\TellDontAsk\UseCase\Exception\OrderCannotBeShippedException;
use RefactorKatas\TellDontAsk\UseCase\Exception\OrderCannotBeShippedTwiceException;
use RefactorKatas\TellDontAsk\UseCase\Request\OrderShipmentRequest;

/**
 * Class OrderShipmentUseCase
 * @package Archel\TellDontAsk\UseCase
 */
class OrderShipmentUseCase
{
    public function __construct(private OrderRepository $orderRepository, private ShipmentService $shipmentService)
    {
    }

    /**
     * @throws OrderCannotBeShippedException
     * @throws OrderCannotBeShippedTwiceException
     */
    public function run(OrderShipmentRequest $request) : void
    {
        $order = $this->orderRepository->getById($request->getOrderId());

        if (!$order) {
            return;
        }

        if ($order->getStatus()->getType() === OrderStatus::CREATED
            || $order->getStatus()->getType() === OrderStatus::REJECTED
        ) {
            throw new OrderCannotBeShippedException();
        }

        if ($order->getStatus()->getType() === OrderStatus::SHIPPED) {
            throw new OrderCannotBeShippedTwiceException();
        }

        $this->shipmentService->ship($order);
        $order->setStatus(OrderStatus::shipped());

        $this->orderRepository->save($order);
    }
}