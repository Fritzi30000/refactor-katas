<?php

namespace RefactorKatas\TellDontAsk\UseCase;

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

        $order->ship($this->shipmentService);

        $this->orderRepository->save($order);
    }
}