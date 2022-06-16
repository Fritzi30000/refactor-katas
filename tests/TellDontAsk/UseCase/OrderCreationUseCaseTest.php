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

    private Category $food;

    private InMemoryProductCatalog $productCatalog;

    private OrderCreationUseCase $useCase;

    public function setUp(): void
    {
        $this->orderRepository = new TestOrderRepository();
        $this->food = new Category();
        $this->food->setName('food');
        $this->food->setTaxPercentage(10.0);

        $product1 = new Product();
        $product1->setName('salad');
        $product1->setPrice(3.56);
        $product1->setCategory($this->food);

        $product2 = new Product();
        $product2->setName('tomato');
        $product2->setPrice(4.65);
        $product2->setCategory($this->food);

        $products = [$product1, $product2];

        $this->productCatalog = new InMemoryProductCatalog(...$products);
        $this->useCase = new OrderCreationUseCase($this->orderRepository, $this->productCatalog);
    }

    /**
     * @test
     */
    public function sellMultipleItems(): void
    {
        $saladRequest = new SellItemRequest(2, "salad");

        $tomatoRequest = new SellItemRequest(3, "tomato");

        $request = new SellItemsRequest($saladRequest, $tomatoRequest);

        $this->useCase->run($request);

        $insertedOrder = $this->orderRepository->getSavedOrder();
        $products = $insertedOrder->getItems();
        $this->assertEquals(OrderStatus::CREATED, $insertedOrder->getStatus()->getType());
        $this->assertEquals($insertedOrder->getTotal(), 23.20);
        $this->assertEquals($insertedOrder->getTax(), 2.13);
        $this->assertEquals("EUR", $insertedOrder->getCurrency());
        $this->assertEquals(2, count($products));
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

    /**
     * @test
     */
    public function unknownProduct(): void
    {
        $this->expectException(UnknownProductException::class);
        $unknownProductRequest = new SellItemRequest(1, 'unknown product');
        $request = new SellItemsRequest($unknownProductRequest);
        $this->useCase->run($request);
    }


}