<?php

namespace RefactorKatas\TellDontAsk\Domain;

/**
 * Class Product
 * @package Archel\TellDontAsk\Domain
 */
class Product
{
    private ?string $name = null;

    private ?float $price = null;

    private ?Category $category = null;

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function setPrice(float $price) : void
    {
        $this->price = $price;
    }

    public function getCategory() : Category
    {
        return $this->category;
    }

    public function setCategory(Category $category) : void
    {
        $this->category = $category;
    }
}