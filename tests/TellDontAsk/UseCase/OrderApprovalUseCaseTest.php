<?php

namespace RefactorKatas\Tests\TellDontAsk\UseCase;

use PHPUnit\Framework\TestCase;
use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\UseCase\Exception\RejectedOrderCannotBeApprovedException;
use RefactorKatas\TellDontAsk\UseCase\Exception\ShippedOrdersCannotBeChangedException;
use RefactorKatas\TellDontAsk\UseCase\OrderApprovalUseCase;
use RefactorKatas\TellDontAsk\UseCase\Request\OrderApprovalRequest;
use RefactorKatas\Tests\TellDontAsk\Doubles\TestOrderRepository;

/**
 * Class OrderApprovalUseCaseTest
 * @package Archel\TellDontAskTest\UseCase
 */
class OrderApprovalUseCaseTest extends TestCase
{
    private TestOrderRepository $orderRepository;

    private OrderApprovalUseCase $useCase;

    /**
     * OrderApprovalUseCaseTest constructor.
     */
    public function setUp(): void
    {
        $this->orderRepository = new TestOrderRepository();
        $this->useCase = new OrderApprovalUseCase($this->orderRepository);
    }

    /**
     * @test
     */
    public function approvedExistingOrder(): void
    {
        $initialOrder = new Order();
        $initialOrder->setStatus(OrderStatus::created());
        $initialOrder->setId(1);
        $this->orderRepository->addOrder($initialOrder);

        $request = new OrderApprovalRequest();
        $request->setOrderId(1);
        $request->setApproved(true);

        $this->useCase->run($request);

        $savedOrder = $this->orderRepository->getSavedOrder();

        $this->assertEquals(OrderStatus::APPROVED, $savedOrder->getStatus()->getType());
    }

    /**
     * @test
     */
    public function rejectExistingOrder(): void
    {
        $initialOrder = new Order();
        $initialOrder->setStatus(OrderStatus::created());
        $initialOrder->setId(1);
        $this->orderRepository->addOrder($initialOrder);

        $request = new OrderApprovalRequest();
        $request->setOrderId(1);
        $request->setApproved(false);

        $this->useCase->run($request);

        $savedOrder = $this->orderRepository->getSavedOrder();

        $this->assertEquals(OrderStatus::REJECTED, $savedOrder->getStatus()->getType());
    }

    /**
     * @test
     */
    public function cannotApproveRejectedOrder(): void
    {
        $this->expectException(RejectedOrderCannotBeApprovedException::class);
        $initialOrder = new Order();
        $initialOrder->setStatus(OrderStatus::rejected());
        $initialOrder->setId(1);
        $this->orderRepository->addOrder($initialOrder);

        $request = new OrderApprovalRequest();
        $request->setOrderId(1);
        $request->setApproved(true);

        $this->useCase->run($request);

        $this->assertEmpty($this->orderRepository->getSavedOrder());
    }

    /**
     * @test
     */
    public function shippedOrdersCannotBeRejected(): void
    {
        $this->expectException(ShippedOrdersCannotBeChangedException::class);
        $initialOrder = new Order();
        $initialOrder->setStatus(OrderStatus::shipped());
        $initialOrder->setId(1);
        $this->orderRepository->addOrder($initialOrder);

        $request = new OrderApprovalRequest();
        $request->setOrderId(1);
        $request->setApproved(false);

        $this->useCase->run($request);

        $this->assertEmpty($this->orderRepository->getSavedOrder());
    }
}
