<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Domain\OrderItem;
use RefactorKatas\TellDontAsk\Domain\OrderStatus;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\Repository\ProductCatalog;
use RefactorKatas\TellDontAsk\UseCase\SellItemsRequest;
use RefactorKatas\TellDontAsk\UseCase\UnknownProductException;

/**
 * Class OrderCreationUseCase
 * @author Daniel J. Perez <danieljordi@bab-soft.com>
 * @package Archel\TellDontAsk\UseCase
 */
class OrderCreationUseCase
{
    /**
     * OrderCreationUseCase constructor.
     * @param OrderRepository $orderRepository
     * @param ProductCatalog $productCatalog
     */
    public function __construct(private OrderRepository $orderRepository, private ProductCatalog $productCatalog)
    {
    }

    public function run(SellItemsRequest $request) : void
    {
        $order = new Order();

        $itemsRequest = $request->getRequests();
        foreach ($itemsRequest as $itemRequest) {
            $product = $this->productCatalog->getByName($itemRequest->getProductName());

            if ($product === null) {
                throw new UnknownProductException();
            }

            $order->addItem($itemRequest, $product);
        }

        $this->orderRepository->save($order);
    }
}
