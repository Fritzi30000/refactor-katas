<?php

namespace RefactorKatas\GildedRose\AlterItemPolicy;

use RefactorKatas\GildedRose\AlterItemPolicy;
use RefactorKatas\GildedRose\Item;

final class NormalItemPolicy implements AlterItemPolicy
{
    public function supports(Item $item): bool
    {
        return true;
    }

    public function apply(Item $item): void
    {
        if ($item->sell_in > 0) {
            $item->quality--;
        } else {
            $item->quality -= 2;
        }
        if ($item->quality < 0) {
            $item->quality = 0;
        }
        $item->sell_in--;
    }
}
