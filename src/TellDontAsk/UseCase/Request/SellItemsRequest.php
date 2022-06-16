<?php

namespace RefactorKatas\TellDontAsk\UseCase\Request;

/**
 * Class SellItemsRequest
 * @package Archel\TellDontAsk\UseCase
 */
class SellItemsRequest
{
    private array $requests;

    /**
     * @param SellItemRequest ...$requests
     */
    public function setRequests(SellItemRequest... $requests) : void
    {
        $this->requests = $requests;
    }

    public function getRequests() : array
    {
        return $this->requests;
    }
}