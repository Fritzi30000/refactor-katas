<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\Repository\ProductCatalog;
use RefactorKatas\TellDontAsk\UseCase\Request\SellItemsRequest;

/**
 * Class OrderCreationUseCase
 * @author Daniel J. Perez <danieljordi@bab-soft.com>
 * @package Archel\TellDontAsk\UseCase
 */
class OrderCreationUseCase
{
    public function __construct(private OrderRepository $orderRepository, private ProductCatalog $productCatalog)
    {
    }

    public function run(SellItemsRequest $request): void
    {
        $order = new Order();

        $itemsRequest = $request->getRequests();

        foreach ($itemsRequest as $itemRequest) {
            $product = $this->productCatalog->getByName($itemRequest->getProductName());

            if (!$product) {
                return;
            }

            $order->addItem($itemRequest, $product);
        }

        if ($order->hasChanged()) {
            $this->orderRepository->save($order);
        }
    }
}
