<?php

namespace RefactorKatas\TellDontAsk\UseCase\Exception;

/**
 * Class UnknownProductException
 * @package Archel\TellDontAsk\UseCase
 */
class UnknownProductException extends \Exception
{
    public function __construct(string $productName)
    {
        parent::__construct("Product $productName does not exist");
    }
}