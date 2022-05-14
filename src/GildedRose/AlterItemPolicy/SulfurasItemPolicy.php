<?php

namespace RefactorKatas\GildedRose\AlterItemPolicy;

use RefactorKatas\GildedRose\AlterItemPolicy;
use RefactorKatas\GildedRose\Item;

final class SulfurasItemPolicy implements AlterItemPolicy
{
    public function supports(Item $item): bool
    {
        return $item->name === 'Sulfuras, Hand of Ragnaros';
    }

    public function apply(Item $item): void
    {
        $item->quality = 80;
    }
}
