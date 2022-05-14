<?php

namespace RefactorKatas\GildedRose;

use RefactorKatas\GildedRose\AlterItemPolicy\AgedBrieItemPolicy;
use RefactorKatas\GildedRose\AlterItemPolicy\BackstagePassesItemPolicy;
use RefactorKatas\GildedRose\AlterItemPolicy\ConjuredItemPolicy;
use RefactorKatas\GildedRose\AlterItemPolicy\NormalItemPolicy;
use RefactorKatas\GildedRose\AlterItemPolicy\SulfurasItemPolicy;

final class AlterStrategy
{
    /**
     * @var AlterItemPolicy[]
     */
    private $policies;

    public function __construct()
    {
        $this->policies = [
            new AgedBrieItemPolicy(),
            new BackstagePassesItemPolicy(),
            new SulfurasItemPolicy(),
            new ConjuredItemPolicy(),
            new NormalItemPolicy(),
        ];
    }

    public function run(Item $item): void
    {
        foreach ($this->policies as $policy) {
            if ($policy->supports($item)) {
                $policy->apply($item);
                return;
            }
        }
    }
}
