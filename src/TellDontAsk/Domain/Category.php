<?php

namespace RefactorKatas\TellDontAsk\Domain;

/**
 * Class Category
 * @package Archel\TellDontAsk\Domain
 */
class Category
{
    private string $name;
    private float $taxPercentage;

    public function __construct(string $name, float $taxPercentage)
    {
        $this->name = $name;
        $this->taxPercentage = $taxPercentage;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTaxPercentage(): float
    {
        return $this->taxPercentage;
    }
}