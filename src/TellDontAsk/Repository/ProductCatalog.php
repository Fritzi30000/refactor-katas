<?php

namespace RefactorKatas\TellDontAsk\Repository;

use RefactorKatas\TellDontAsk\Domain\Product;

/**
 * Interface ProductCatalog
 * @package Archel\TellDontAsk\Repository
 */
interface ProductCatalog
{
    public function getByName(string $name) : ?Product;
}
