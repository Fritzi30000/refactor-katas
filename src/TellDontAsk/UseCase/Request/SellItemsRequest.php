<?php

namespace RefactorKatas\TellDontAsk\UseCase\Request;

/**
 * Class SellItemsRequest
 * @package Archel\TellDontAsk\UseCase
 */
class SellItemsRequest
{
    private array $requests;

    public function __construct(SellItemRequest...$requests)
    {
        $this->requests = $requests;
    }


    public function getRequests() : array
    {
        return $this->requests;
    }
}