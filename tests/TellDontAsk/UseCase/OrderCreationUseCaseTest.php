<?php

namespace RefactorKatas\Tests\TellDontAsk\UseCase;

use PHPUnit\Framework\TestCase;
use RefactorKatas\TellDontAsk\Domain\Category;
use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\Domain\Product;
use RefactorKatas\TellDontAsk\UseCase\Exception\UnknownProductException;
use RefactorKatas\TellDontAsk\UseCase\OrderCreationUseCase;
use RefactorKatas\TellDontAsk\UseCase\Request\SellItemRequest;
use RefactorKatas\TellDontAsk\UseCase\Request\SellItemsRequest;
use RefactorKatas\Tests\TellDontAsk\Doubles\InMemoryProductCatalog;
use RefactorKatas\Tests\TellDontAsk\Doubles\TestOrderRepository;

/**
 * Class OrderCreationUseCaseTest
 * @package Archel\TellDontAskTest\UseCase
 */
class OrderCreationUseCaseTest extends TestCase
{
    private TestOrderRepository $orderRepository;
    private OrderCreationUseCase $useCase;

    public function setUp(): void
    {
        $this->orderRepository = new TestOrderRepository();
        $food = new Category('food', 10.0);
        $productCatalog = new InMemoryProductCatalog(
            new Product('salad', 3.56, $food),
            new Product('tomato', 4.65, $food)
        );
        $this->useCase = new OrderCreationUseCase($this->orderRepository, $productCatalog);
    }

    public function testShouldSellMultipleItems(): void
    {
        // Given
        $request = new SellItemsRequest(
            new SellItemRequest(2, "salad"),
            new SellItemRequest(3, "tomato")
        );

        // When
        $this->useCase->run($request);

        // Then
        $insertedOrder = $this->orderRepository->getSavedOrder();
        $products = $insertedOrder->getItems();
        $this->assertEquals(OrderStatus::CREATED, $insertedOrder->getStatus()->getType());
        $this->assertEquals(23.20, $insertedOrder->getTotal());
        $this->assertEquals(2.13, $insertedOrder->getTax());
        $this->assertEquals("EUR", $insertedOrder->getCurrency());
        $this->assertCount(2, $products);

        //TODO: this should be moved and checked somewhere else
        $this->assertEquals("salad", $products[0]->getProduct()->getName());
        $this->assertEquals(3.56, $products[0]->getProduct()->getPrice());
        $this->assertEquals(2, $products[0]->getQuantity());
        $this->assertEquals(7.84, $products[0]->getTaxedAmount());
        $this->assertEquals(0.72, $products[0]->getTax());
        $this->assertEquals("tomato", $products[1]->getProduct()->getName());
        $this->assertEquals(4.65, $products[1]->getProduct()->getPrice());
        $this->assertEquals(3, $products[1]->getQuantity());
        $this->assertEquals(15.36, $products[1]->getTaxedAmount());
        $this->assertEquals(1.41, $products[1]->getTax());
    }

    public function testShouldNotSellUnknownProduct(): void
    {
        // Expects
        $this->expectException(UnknownProductException::class);

        // Given
        $unknownProductRequest = new SellItemRequest(1, 'unknown product');
        $request = new SellItemsRequest($unknownProductRequest);

        // When
        $this->useCase->run($request);
    }


}