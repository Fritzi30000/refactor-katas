<?php

namespace RefactorKatas\Tests\TellDontAsk\UseCase;

use PHPUnit\Framework\TestCase;
use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\UseCase\OrderApprovalUseCase;
use RefactorKatas\TellDontAsk\UseCase\Request\OrderStatusUpdateRequest;
use RefactorKatas\Tests\TellDontAsk\Doubles\TestOrderRepository;

/**
 * Class OrderApprovalUseCaseTest
 * @package Archel\TellDontAskTest\UseCase
 */
class OrderApprovalUseCaseTest extends TestCase
{
    private TestOrderRepository $orderRepository;
    private OrderApprovalUseCase $useCase;

    public function setUp(): void
    {
        $this->orderRepository = new TestOrderRepository();
        $this->useCase = new OrderApprovalUseCase($this->orderRepository);
    }

    public function testShouldApproveExistingOrder(): void
    {
        // Given
        $initialOrder = new Order(1);
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderStatusUpdateRequest(1, true);

        // When
        $this->useCase->run($request);

        //Then
        $savedOrder = $this->orderRepository->getSavedOrder();
        $this->assertEquals(OrderStatus::APPROVED, $savedOrder->getStatus()->getType());
    }

    public function testShouldRejectExistingOrder(): void
    {
        // Given
        $initialOrder = new Order(1);
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderStatusUpdateRequest(1, false);

        // When
        $this->useCase->run($request);

        //Then
        $savedOrder = $this->orderRepository->getSavedOrder();
        $this->assertEquals(OrderStatus::REJECTED, $savedOrder->getStatus()->getType());
    }

    public function testShouldNotApproveRejectedOrder(): void
    {
        // Given
        $initialOrder = new Order(1, OrderStatus::rejected());
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderStatusUpdateRequest(1, true);

        // When
        $this->useCase->run($request);

        //Then
        $this->assertEmpty($this->orderRepository->getSavedOrder());
    }

    public function testShouldNotShipRejectedOrder(): void
    {
        // Given
        $initialOrder = new Order(1, OrderStatus::shipped());
        $this->orderRepository->addOrder($initialOrder);
        $request = new OrderStatusUpdateRequest(1, false);

        // When
        $this->useCase->run($request);

        //Then
        $this->assertEmpty($this->orderRepository->getSavedOrder());
    }
}
