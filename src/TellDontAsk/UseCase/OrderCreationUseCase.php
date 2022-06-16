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
        $order->setStatus(OrderStatus::created());
        $order->setCurrency("EUR");
        $order->setTotal(0.0);
        $order->setTax(0.0);

        $itemsRequest = $request->getRequests();
        foreach ($itemsRequest as $itemRequest) {
            $product = $this->productCatalog->getByName($itemRequest->getProductName());

            if (empty($product)) {
                throw new UnknownProductException();
            } else {
                $unitaryTax = round(
                    ($product->getPrice() / 100) * $product->getCategory()->getTaxPercentage(),
                    2
                );
                $unitaryTaxedAmount = round($product->getPrice() + $unitaryTax, 2);
                $taxedAmount = round($unitaryTaxedAmount * $itemRequest->getQuantity(), 2);
                $taxAmount = round($unitaryTax * $itemRequest->getQuantity(), 2);

                $orderItem = new OrderItem();
                $orderItem->setProduct($product);
                $orderItem->setQuantity($itemRequest->getQuantity());
                $orderItem->setTax($taxAmount);
                $orderItem->setTaxedAmount($taxedAmount);
                $order->addItem($orderItem);

                $total = $order->getTotal() + $taxedAmount;
                $order->setTotal($total);

                $tax = $order->getTax() + $taxAmount;
                $order->setTax($tax);
            }
        }

        $this->orderRepository->save($order);
    }
}
