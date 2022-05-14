<?php

namespace RefactorKatas\GildedRose\AlterItemPolicy;

use RefactorKatas\GildedRose\AlterItemPolicy;
use RefactorKatas\GildedRose\Item;

final class BackstagePassesItemPolicy implements AlterItemPolicy
{
    public function supports(Item $item): bool
    {
        return $item->name === 'Backstage passes to a TAFKAL80ETC concert';
    }

    public function apply(Item $item): void
    {
        if ($item->sell_in > 10) {
            $item->quality++;
        } elseif ($item->sell_in > 5) {
            $item->quality += 2;
        } elseif ($item->sell_in > 0) {
            $item->quality += 3;
        } else {
            $item->quality = 0;
        }
        $item->sell_in--;
    }
}
