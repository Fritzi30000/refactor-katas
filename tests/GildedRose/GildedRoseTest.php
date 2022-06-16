<?php

declare(strict_types=1);

namespace RefactorKatas\Tests\GildedRose;

use PHPUnit\Framework\TestCase;
use RefactorKatas\GildedRose\GildedRose;
use RefactorKatas\GildedRose\Item;

/**
 * @covers \RefactorKatas\GildedRose\GildedRose
 */
class GildedRoseTest extends TestCase
{
    public function testStandardUpdateOfItemInSell(): void
    {
        // Given
        $items = [new Item('foo', 10, 5)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(9, $items[0]->sell_in);
        self::assertSame(4, $items[0]->quality);
    }

    public function testStandardUpdateOfItemOutOfSell(): void
    {
        // Given
        $items = [new Item('foo', 0, 5)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(-1, $items[0]->sell_in);
        self::assertSame(3, $items[0]->quality);
    }

    public function testStandardUpdateOfItemOutOfSell2(): void
    {
        // Given
        $items = [new Item('foo', 1, 5)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(0, $items[0]->sell_in);
        self::assertSame(4, $items[0]->quality);
    }

    public function testStandardUpdateOfItemOutOfSell3(): void
    {
        // Given
        $items = [new Item('foo', 3, 0)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(2, $items[0]->sell_in);
        self::assertSame(0, $items[0]->quality);
    }

    public function testShouldIncreaseAgedBrieAsItsSellRises(): void
    {
        // Given
        $items = [new Item('Aged Brie', 3, 0)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(2, $items[0]->sell_in);
        self::assertSame(1, $items[0]->quality);
    }

    public function testShouldIncreaseAgedBrieAsItsSellRisesButNotMoreThan50(): void
    {
        // Given
        $items = [new Item('Aged Brie', 3, 50)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(2, $items[0]->sell_in);
        self::assertSame(50, $items[0]->quality);
    }

    public function testShouldIncreaseQualityOfBackstagePasses(): void
    {
        // Given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 15, 30)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(14, $items[0]->sell_in);
        self::assertSame(31, $items[0]->quality);
    }

    public function testShouldIncreaseQualityOfBackstagePasses2(): void
    {
        // Given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 9, 30)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(8, $items[0]->sell_in);
        self::assertSame(32, $items[0]->quality);
    }

    public function testShouldIncreaseQualityOfBackstagePasses3(): void
    {
        // Given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 4, 30)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(3, $items[0]->sell_in);
        self::assertSame(33, $items[0]->quality);
    }

    public function testShouldIncreaseQualityOfBackstagePasses4(): void
    {
        // Given
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 0, 30)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(-1, $items[0]->sell_in);
        self::assertSame(0, $items[0]->quality);
    }

    public function testShouldLeaveSulfurasAtTheSameLevelOfQuality(): void
    {
        // Given
        $items = [new Item('Sulfuras, Hand of Ragnaros', 3, 80)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(3, $items[0]->sell_in);
        self::assertSame(80, $items[0]->quality);
    }

    public function testShouldDegrateQualityOfConjuredItemTwoTimesFasterAsStandard(): void
    {
        // Given
        $items = [new Item('Conjured', 3, 40)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(2, $items[0]->sell_in);
        self::assertSame(38, $items[0]->quality);
    }

    public function testShouldDegrateQualityOfConjuredItemTwoTimesFasterAsStandard2(): void
    {
        // Given
        $items = [new Item('Conjured', 0, 40)];
        $gildedRose = new GildedRose($items);

        // When
        $gildedRose->updateQuality();

        // Then
        self::assertSame(-1, $items[0]->sell_in);
        self::assertSame(36, $items[0]->quality);
    }
}
