<?php

namespace RefactorKatas\Tests\TellDontAsk\UseCase;

use PHPUnit\Framework\TestCase;
use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\UseCase\OrderShipmentUseCase;
use RefactorKatas\TellDontAsk\UseCase\Request\OrderShipmentRequest;
use RefactorKatas\Tests\TellDontAsk\Doubles\TestOrderRepository;
use RefactorKatas\Tests\TellDontAsk\Doubles\TestShipmentService;

/**
 * Class OrderShipmentUseCaseTest
 * @package Archel\TellDontAskTest\UseCase
 */
class OrderShipmentUseCaseTest extends TestCase
{
    private TestOrderRepository $orderRepository;
    private TestShipmentService $shipmentService;
    private OrderShipmentUseCase $useCase;

    public function setUp(): void
    {
        $this->orderRepository = new TestOrderRepository();
        $this->shipmentService = new TestShipmentService();
        $this->useCase = new OrderShipmentUseCase($this->orderRepository, $this->shipmentService);
    }

    public function testShouldShipApprovedOrder(): void
    {
        // Given
        $initialOrder = new Order(1, OrderStatus::approved());
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderShipmentRequest(1);

        // When
        $this->useCase->run($request);

        //Then
        $this->assertEquals(OrderStatus::SHIPPED, $this->orderRepository->getSavedOrder()->getStatus()->getType());
        $this->assertEquals($this->shipmentService->getShippedOrder()->getId(), $initialOrder->getId());
    }

    public function testShouldNotShipCreatedButNotApprovedOrder(): void
    {
        // Given
        $initialOrder = new Order(1);
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderShipmentRequest(1);

        // When
        $this->useCase->run($request);

        //Then
        $this->assertEmpty($this->orderRepository->getSavedOrder());
        $this->assertEmpty($this->shipmentService->getShippedOrder());
    }

    public function testShouldNotShipRejectedOrder(): void
    {
       // Given
        $initialOrder = new Order(1, OrderStatus::rejected());
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderShipmentRequest(1);

        // When
        $this->useCase->run($request);

        //Then
        $this->assertEmpty($this->orderRepository->getSavedOrder());
        $this->assertEmpty($this->shipmentService->getShippedOrder());
    }

    public function testShouldNotShipOrderThatHasAlreadyBeenShipped(): void
    {
        // Given
        $initialOrder = new Order(1, OrderStatus::shipped());
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderShipmentRequest(1);

        // When
        $this->useCase->run($request);

        //Then
        $this->assertEmpty($this->orderRepository->getSavedOrder());
        $this->assertEmpty($this->shipmentService->getShippedOrder());
    }
}
