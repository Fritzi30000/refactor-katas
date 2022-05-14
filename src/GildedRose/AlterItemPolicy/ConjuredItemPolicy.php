<?php

namespace RefactorKatas\GildedRose\AlterItemPolicy;

use RefactorKatas\GildedRose\AlterItemPolicy;
use RefactorKatas\GildedRose\Item;

final class ConjuredItemPolicy implements AlterItemPolicy
{
    public function supports(Item $item): bool
    {
        return $item->name === 'Conjured';
    }

    public function apply(Item $item): void
    {
        if ($item->sell_in > 0) {
            $item->quality -= 2;
        } else {
            $item->quality -= 4;
        }
        if ($item->quality < 0) {
            $item->quality = 0;
        }
        $item->sell_in--;
    }
}
