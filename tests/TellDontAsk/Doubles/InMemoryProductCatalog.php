<?php

namespace RefactorKatas\Tests\TellDontAsk\Doubles;

use RefactorKatas\TellDontAsk\Domain\Product;
use RefactorKatas\TellDontAsk\Repository\ProductCatalog;

/**
 * Class InMemoryProductCatalog
 * @package Archel\TellDontAskTest\Doubles
 */
class InMemoryProductCatalog implements ProductCatalog
{
    private array $products = [];

    /**
     * InMemoryProductCatalog constructor.
     * @param Product ...$products
     */
    public function __construct(Product... $products)
    {
        $this->products = $products;
    }

    public function getByName(string $name) : ?Product
    {
        $product = array_filter($this->products, fn($product) => $product->getName() === $name);

        return !empty($product) ? current($product) : null;
    }
}