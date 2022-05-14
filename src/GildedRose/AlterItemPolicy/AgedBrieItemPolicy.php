<?php

namespace RefactorKatas\GildedRose\AlterItemPolicy;

use RefactorKatas\GildedRose\AlterItemPolicy;
use RefactorKatas\GildedRose\Item;

final class AgedBrieItemPolicy implements AlterItemPolicy
{
    public function supports(Item $item): bool
    {
        return $item->name === 'Aged Brie';
    }

    public function apply(Item $item): void
    {
        $item->sell_in--;
        if ($item->quality >= 50) {
            $item->quality = 50;
            return;
        }
        $item->quality++;
    }
}
