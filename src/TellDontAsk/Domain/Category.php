<?php

namespace RefactorKatas\TellDontAsk\Domain;

/**
 * Class Category
 * @package Archel\TellDontAsk\Domain
 */
class Category
{
    private ?string $name = null;

    private ?float $taxPercentage = null;

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getTaxPercentage() : float
    {
        return $this->taxPercentage;
    }

    public function setTaxPercentage(float $taxPercentage) : void
    {
        $this->taxPercentage = $taxPercentage;
    }
}