<?php

namespace RefactorKatas\GildedRose;

interface AlterItemPolicy
{
    public function supports(Item $item): bool;

    public function apply(Item $item): void;
}
