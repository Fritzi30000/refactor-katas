<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\Service\ShipmentService;
use RefactorKatas\TellDontAsk\UseCase\OrderCannotBeShippedException;
use RefactorKatas\TellDontAsk\UseCase\OrderCannotBeShippedTwiceException;
use RefactorKatas\TellDontAsk\UseCase\OrderShipmentRequest;

/**
 * Class OrderShipmentUseCase
 * @package Archel\TellDontAsk\UseCase
 */
class OrderShipmentUseCase
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ShipmentService
     */
    private $shipmentService;

    public function __construct(OrderRepository $orderRepository, ShipmentService $shipmentService)
    {
        $this->orderRepository = $orderRepository;
        $this->shipmentService = $shipmentService;
    }

    /**
     * @param OrderShipmentRequest $request
     * @throws OrderCannotBeShippedException
     * @throws OrderCannotBeShippedTwiceException
     */
    public function run(OrderShipmentRequest $request) : void
    {
        $order = $this->orderRepository->getById($request->getOrderId());

        if ($order->getStatus()->getType() === OrderStatus::CREATED
            ||$order->getStatus()->getType() === OrderStatus::REJECTED
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