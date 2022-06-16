<?php

declare(strict_types=1);

namespace RefactorKatas\GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(private array $items)
    {
    }

    public function updateQuality(): void
    {
        $alterStrategy = new AlterStrategy();
        foreach ($this->items as $item) {
            $alterStrategy->run($item);
        }
    }
}
