<?php

declare(strict_types=1);

namespace RefactorKatas\GildedRose;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        $alterStrategy = new AlterStrategy();
        foreach ($this->items as $item) {
            $alterStrategy->run($item);
        }
    }
}
