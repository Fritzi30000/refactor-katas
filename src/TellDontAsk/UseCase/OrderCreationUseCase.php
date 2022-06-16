<?php

namespace RefactorKatas\TellDontAsk\UseCase;

use RefactorKatas\TellDontAsk\Domain\Order;
use RefactorKatas\TellDontAsk\Repository\OrderRepository;
use RefactorKatas\TellDontAsk\Repository\ProductCatalog;
use RefactorKatas\TellDontAsk\UseCase\Exception\UnknownProductException;
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

    /**
     * @param SellItemsRequest $request
     * @throws UnknownProductException
     * @return void
     */
    public function run(SellItemsRequest $request): void
    {
        $order = new Order();

        $itemsRequest = $request->getRequests();

        foreach ($itemsRequest as $itemRequest) {
            $product = $this->productCatalog->getByName($itemRequest->getProductName());

            if ($product === null) {
                throw new UnknownProductException($itemRequest->getProductName());
            }

            $order->addItem($itemRequest, $product);
        }

        $this->orderRepository->save($order);
    }
}
